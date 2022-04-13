<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Cpanel\CpanelController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Subdomains;
use App\Models\Packages;
use App\Models\Projects;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $data = [];
    
    protected $dbHost = '';
    protected $dbUsername = '';
    protected $dbKey  = '';
    protected $cpanel = '';
    protected $path = '';
    public function __construct()
    {
        $this->dbHost = env('CPANEL_HOST');
        $this->dbUsername = env('CPANEL_USER');
        $this->dbKey = env('CPANEL_KEY');
        $this->cpanel = new CpanelController(env('CPANEL_USER'), env('CPANEL_KEY'), env('CPANEL_HOST'));
          //$this->data['packages'] = ['XDesign360', 'Biroev360'];
        $this->data['menu'] = 'setup';
        $this->path = 'C:\wamp64\www\mutitanancyadmin\.env';
    }
    public function index()
    {
        $this->data['packages'] = DB::table('packages')->orderBy('package_name', 'asc')->get();
        return Inertia::render('Wizard/Index', $this->data);
    }
    public function validateProjectData(Request $request){       
        $request->validate([
            "project_name" => 'required',
            "package" => 'required',
            "status" => Rule::in([0, 1]),
            // "setup_date" => 'required|date',
            "subdomain" => 'required|unique:projects',
        ]);
        return ['status' => 'success'];
    }
    public function SaveClientInfo(Request $request){
        $result = Client::create([
                        "name" => $request->name,
                        "email" => $request->email,
                        "client_code" => $request->client_code,
                        "remarks" => $request->remarks,
                        'status' => 1
                    ]);
        if($result->id){
            return ['status' => 'success', 'client_id' => $result->id];
        }
        return ['status' => 'fail'];
    }
    public function SaveProjectInfo(Request $request){
        $result = Projects::create([
            "client_id" => $request->input('client_id'),
            "module_name" => $request->input('project_name'),
            "subdomain" => $request->input('subdomain'),
            "package_id" => $request->input('package'),
            "notes" => $request->input('notes'),
            "setup_date" => date("Y-m-d H:i:s", strtotime("now")),
            "status" => $request->input("status"),
            "user_id" => Auth::user()->id
        ]);
        if($result->id){
            return ['status' => 'success'];
        }
        return ['status' => 'fail'];
    }  
    public function CreateDatabase(Request $request){      
        ini_set('max_execution_time', 600);  
        $expSubdomain = explode('.', $request->subdomain);
        if($request->package_id == 'xdesign360.com'){
            $dbNameCreated = strtolower('xdesign_'.$expSubdomain[0]);
            $rootdomain = 'xdesign360.com';
        }else{
            $dbNameCreated = strtolower('xdesign_'.$expSubdomain[0]).'vt';
            $rootdomain = 'biorev360.com';
        }
        $create_db = $this->cpanel->uapi(
            'Mysql', 'create_database',
            array(
                'name'    => $dbNameCreated,
            )
        );
        if (!$create_db->status == 1) {
            return ['status' => 'fail'];
        }else{
            return ['status' => 'success', 'dbNameCreated' => $dbNameCreated, 'rootdomain' => $rootdomain];
        }
    }
    public function SetDbPrivileges(Request $request){
        $dbNameCreated = $request->dbNameCreated;
        $set_dbuser_privs = $this->cpanel->uapi(
            'Mysql', 'set_privileges_on_database',
            array(
                'user'       => 'xdesign_b360',
                'database'   => $dbNameCreated,
                'privileges' => 'ALL PRIVILEGES',
            )
        );
        if (!$set_dbuser_privs->status == 1) {
            return ['status' => 'fail'];
        }else{
            return ['status' => 'success'];
        }
    }
    public function AddingSubDomain(Request $request){
        $expSubdomain = explode('.', $request->subdomain);
        $rootdomain = $request->rootdomain;
        $parameters = [
            'domain' => $expSubdomain[0],
            'rootdomain' => $rootdomain,
            'dir' => $request->subdomain,
            'disallowdot' => 1,
        ];
        $addSubDomain = $this->cpanel->execute('api2',"SubDomain", "addsubdomain" , $parameters);
        if($addSubDomain->cpanelresult->data[0]->result == 1){
            return ['status' => 'success'];
        }else{
            return ['status' => 'fail'];
        }
    }
    public function TranasferingFiles(Request $request){
        $source = '/public_html/biorev-superadmin-project1/';
        $destination = '/public_html/'.$request->subdomain;
        $list_files = $this->cpanel->uapi(
            'Fileman', 'list_files',
                array(
                'dir'                               => $source,
                'types'                             => 'dir|file',
                'limit_to_list'                     => '0',
                'show_hidden'                       => '1',
                'check_for_leaf_directories'        => '1',
                'include_mime'                      => '1',
                'include_hash'                      => '0',
                'include_permissions'               => '0',
           )
        );
        $list_files = get_object_vars($list_files)['data'];
        $fullPath = [];
        foreach($list_files as $list_file){
            $list_file = get_object_vars($list_file);
            $file = explode('/home/xdesign', $list_file['fullpath']);
            $fullPath[] = $file[1];
            $fileop = $this->cpanel->api2(
                'Fileman', 'fileop',
                    array(
                    'op'                => 'copy',
                    'sourcefiles'       =>  $file[1],
                    'destfiles'         => $destination,
                    'doubledecode'      => '0'
                )
            );
            //echo '<pre>'; print_r($fileop); echo '</pre>';
        }
        return ['status' => 'success', 'source' => $source, 'destination' => $destination];
    }
    public function UpdatingEnv(Request $request){
        // Retrieve content from file.
        $source = $request->source;
        $destination = $request->destination;
        $dbNameCreated = $request->dbNameCreated;        
        $get_file_content = $this->cpanel->uapi(
            'Fileman', 'get_file_content',
                array(
                'dir'                           => $destination,
                'file'                          => '.env',
                'from_charset'                  => '_DETECT_',
                'to_charset'                    => '_LOCALE_',
                'update_html_document_encoding' => '1',
            )
        );        
        
        $get_file_content = get_object_vars(get_object_vars($get_file_content)['data'])['content'];
        $get_file_content = str_replace('DB_DATABASE=laravel', 'DB_DATABASE='.$dbNameCreated, $get_file_content);
        $get_file_content = str_replace('DB_USERNAME=root', 'DB_USERNAME='.$this->dbUsername, $get_file_content);
        $get_file_content = str_replace('DB_PASSWORD=', 'DB_PASSWORD='.$this->dbKey, $get_file_content);
        // Save example.html's content.
        $save_file_content = $this->cpanel->uapi(
            'Fileman', 'save_file_content',
            array(
                'dir'           => $destination,
                'file'          => '.env',
                'from_charset'      => 'UTF-8',
                'to_charset'        => 'ASCII',
                'content'       => $get_file_content,
                'fallback'      => '0',
            )
        );
        if (!$save_file_content->status == 1) {
            return ['status' => 'fail'];
        }else{
            return ['status' => 'success'];
        }
    }
    public function UpdateLocalEnv(Request $request){ //Request $request        
        //$database = 'testing_db';
        $database = $request->dbNameCreated;
        DB::statement("CREATE DATABASE $database");
        // adding credentials to local env
        $fp = fopen($this->path, 'a');
        $c = "\nSETUP_DB_DATABASE=$database\nSETUP_DB_USERNAME=root\nSETUP_DB_PASSWORD=";
        fwrite($fp, $c);  
        return ['status' => 'success'];
    }
    public function UpdateDatabase(){ //Request $request
        //run sql
        try {
            $database = 'testing_db2';
            // $database = $request->dbNameCreated;
            config('database.connections.mysql_new.database', $database);
            var_dump(config('database.connections.mysql_new.database')); die;
            config('database.connections.mysql_new.username', 'root');
            config('database.connections.mysql_new.password', '');
            $sql_dump = File::get(public_path('files/biorev360.sql'));
            DB::connection('mysql_new')->getPdo()->exec($sql_dump);
            return ['status' => 'success'];
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function RevertEnvUpdate(Request $request){        
        //removing credentials form local env
        $content = file_get_contents($this->path);
        $contentD = strstr($content, 'SETUP_DB_DATABASE', false);
        $contentA = str_replace($contentD, '', $content);
        file_put_contents($this->path, $contentA);
        return ['status' => 'success'];
    }
    
}
