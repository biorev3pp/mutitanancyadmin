<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Cpanel\cPanelController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Request;
use App\Models\Post;
use Inertia\Inertia;


class DomainsController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $domains = [];

    public function __construct()
    {
          
    }

    public function index(Request $request)
    {
        $cpanel = new cPanelController(env('cpanel_user'), env('cpanel_key'), env('cpanel_host'));
        $domains = $cpanel->execute('api2', 'DomainLookup', 'getdocroots');
        // dd($domains);
        return Inertia::render('Domains/Index', [
            'domains' => $domains,
            'menu' => 'domains'
        ]);

    }

}
