<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Cpanel\cPanelController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Subdomains;
use App\Models\Packages;
use App\Models\Projects;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DomainsController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $domains = [];


    public function index(Request $request)
    {
        $cpanel = new cPanelController(env('cpanel_user'), env('cpanel_key'), env('cpanel_host'));
        $domains = $cpanel->execute('api2', 'SubDomain', 'listsubdomains', ['return_https_redirect_status'=>1]);
        
        foreach(get_object_vars(get_object_vars($domains)['cpanelresult'])['data'] as $domain){
            $domain = get_object_vars($domain);
            $c = Subdomains::where('domain', '=', $domain['domain'])->count();
            if($c == 0){
                Subdomains::create([
                    'rootdomain' => $domain['rootdomain'],
                    'all_aliases_valid' => $domain['all_aliases_valid'],
                    'subdomain' => $domain['subdomain'],
                    'can_https_redirect' => $domain['can_https_redirect'],
                    'web_subdomain_aliases' => $domain['web_subdomain_aliases'][0],
                    'basedir' => $domain['basedir'],
                    'dir' => $domain['dir'],
                    'reldir' => $domain['reldir'],
                    'domainkey' => $domain['domainkey'],
                    'status' => $domain['status'],
                    'domain' => $domain['domain'],
                    'is_https_redirecting' => $domain['is_https_redirecting'],
                ]);
            }
        }
        return Inertia::render('Domains/Index', [
            'domains' => $domains,
            'menu' => 'domains'
        ]);

    }
    public function validateProjectData(Request $request){
        
        $this->validate($request, [
            [
                'module_name' => 'required'
            ],
            [
                'required' => ':attribute is required',
            ],
            [
                'module_name' => 'Project name'
            ]
            // 'email' => 'required|email|unique:clients',
            // 'client_code' => 'required|unique:clients' 
        ]);
        return ['success'];
    }
    public function checkDomain($domain = null){
        
        if(Subdomains::where('domain', '=', $domain)->count() == 0){
            return ['status' => 'success'];
        }else{
            return ['status' => 'fail'];
        }
    }
    public function saveProjectData(Request $request){
        $cpanel = new cPanelController(env('cpanel_user'), env('cpanel_key'), env('cpanel_host'));
        $path = 'ENV/.env';
        // dd(file_exists($path));
        $source = '/public_html/anand.biorev360.com/';
        $destination = '/public_html/anand.xdesign360.com';
        
        // Retrieve content from file.
        $get_file_content = $cpanel->uapi(
            'Fileman', 'get_file_content',
                array(
                'dir'                           => '/public_html/anand.xdesign360.com/',
                'file'                          => '.env',
                'from_charset'                  => '_DETECT_',
                'to_charset'                    => '_LOCALE_',
                'update_html_document_encoding' => '1',
            )
        );
        echo '<pre>'; print_r($get_file_content); echo '</pre>';
        $get_file_content = get_object_vars(get_object_vars($get_file_content)['data'])['content'];
        $get_file_content = str_replace('DB_DATABASE=laravel', 'DB_DATABASE=MY_DB_DATABASE_CUSTOM', $get_file_content);
        $get_file_content = str_replace('DB_USERNAME=root', 'DB_USERNAME=MY_DB_USERNAME_CUSTOM', $get_file_content);
        $get_file_content = str_replace('DB_PASSWORD=', 'DB_PASSWORD=MY_DB_PASSWORD_CUSTOM', $get_file_content);
        
        // Save example.html's content.
        $save_file_content = $cpanel->uapi(
            'Fileman', 'save_file_content',
            array(
                'dir'           => '/public_html/anand.xdesign360.com/',
                'file'          => '.env',
                'from_charset'      => 'UTF-8',
                'to_charset'        => 'ASCII',
                'content'       => $get_file_content,
                'fallback'      => '0',
            )
        );
        dd($save_file_content);
        

        $client_code = base64_encode($request->client_code);
        $request->validate([
            "project_name" => 'required',
            "package" => 'required',
            "status" => Rule::in([0, 1]),
            // "setup_date" => 'required|date',
            "subdomain" => 'required|unique:projects',
        ]);
        $result = Projects::create([
            "client_id" => $request->input('client_id'),
            "module_name" => $request->input('project_name'),
            "subdomain" => $request->input('subdomain'),
            "package_id" => $request->input('package'),
            "notes" => $request->input('notes'),
            "setup_date" => date("Y-m-d H:i:s", strtotime("now")),
            "status" => $request->input("status"),
            "user_id" => \Auth::user()->id
        ]);
        if($result->id){
            
            // if (file_exists($path)) {
            //     file_put_contents($path, str_replace(
            //         'DB_DATABASE=MY_DB_DATABASE_CUSTOM', 'DB_DATABASE=laravel', file_get_contents($path)
            //     ));
            //     file_put_contents($path, str_replace(
            //         'DB_USERNAME=MY_DB_USERNAME_CUSTOM', 'DB_USERNAME=root', file_get_contents($path)
            //     ));
            //     file_put_contents($path, str_replace(
            //         'DB_PASSWORD=MY_DB_PASSWORD_CUSTOM', 'DB_PASSWORD=', file_get_contents($path)
            //     ));
            // }
            
            
            
            //move files from one folder to another
            
            $list_files = $cpanel->uapi(
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
                $fileop = $cpanel->api2(
                    'Fileman', 'fileop',
                        array(
                        'op'                => 'copy',
                        'sourcefiles'       =>  $file[1],
                        'destfiles'         => $destination,
                        'doubledecode'      => '0'
                    )
                );
                echo '<pre>'; print_r($fileop); echo '</pre>';
            }
            
            //CREATE DATABASE
            $dbuser = 'xdesign_b360';
            $dbuserpassword = 'Xq8gg}BL1GqA';
            $expSubdomain = explode('.', $request->subdomain);
            $cpanel = new cPanelController(env('cpanel_user'), env('cpanel_key'), env('cpanel_host'));
            if($request->package_id == 'xdesign360.com'){
                $dbName = strtolower('xdesign_'.$expSubdomain[0]);
                $rootdomain = 'xdesign360.com';
                
            }else{
                $dbName = strtolower('xdesign_'.$expSubdomain[0]).'vt';
                $rootdomain = 'biorev360.com';
            }
            $create_db = $cpanel->uapi(
                'Mysql', 'create_database',
                array(
                    'name'    => $dbName,
                )
            );
            echo '<pre>'; print_r($create_db); echo '</pre>';
            //export cdemo database to created database
            // Restore the database's backup files.
            $Backup_restore_database = $cpanel->uapi(
                'Backup', 'restore_databases',
                array(
                    'backup'                 => '/home/xdesign/db-backup/cdemo.sql',
                    'verbose'                => '1',
                    'timeout'                => '3600',
                )
            );
            dd($Backup_restore_database);
            // Set the dbuser user's privileges for the mydb database.
            $set_dbuser_privs = $cpanel->uapi(
                'Mysql', 'set_privileges_on_database',
                array(
                    'user'       => 'xdesign_b360',
                    'database'   => $dbName,
                    'privileges' => 'ALL PRIVILEGES',
                )
            );
            echo '<pre>'; print_r($set_dbuser_privs); echo '</pre>';
            $get_dbuser_privs = $cpanel->uapi(
                'Mysql', 'get_privileges_on_database',
                array(
                    'user'       => $dbuser,
                    'database'   => $dbName,
                )
            );
            echo '<pre>'; print_r($get_dbuser_privs); echo '</pre>';
            //adding sub-domain           

            $parameters = [
                'domain' => $expSubdomain[0],
                'rootdomain' => $rootdomain,
                'dir' => $request->subdomain,
                'disallowdot' => 1,
            ];
            $addSubDomain = $cpanel->execute('api2',"SubDomain", "addsubdomain" , $parameters);
            dd($addSubDomain);
            return ['status' => 'success'];
        }else{
            return ['status' => 'fail'];
        }
    }
    public function updateProjectData(Request $request){
        // dd($request->all());
        $request->validate([
            "project_name" => 'required',
            "package" => 'required',
            "status" => Rule::in([0, 1]),

            "subdomain" => 'required|unique:projects', //'required|unique:projects'
        ]);
        $id = $request->id;
        $project = Projects::where('id', $id)->first();
        $project->module_name = $request->input('project_name');
        $project->subdomain = $request->input('subdomain');
        $project->package_id = $request->input('package');
        $project->notes = $request->input('notes');
        $project->status = $request->input("status");
        if($project->save()){
            return ['status' => 'success'];
        }else{
            return ['status' => 'fail'];
        }
    }
}
