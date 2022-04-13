<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Cpanel\CpanelController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Subdomains;
use App\Models\Packages;
use App\Models\Projects;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SetupController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $data = [];

    public function __construct()
    {
          //$this->data['packages'] = ['XDesign360', 'Biroev360'];
          $this->data['menu'] = 'setup';
    }
    public function index()
    {
        $this->data['packages'] = DB::table('packages')->orderBy('package_name', 'asc')->get();
        return Inertia::render('Wizard/Index', $this->data);
    }
    
    
}
