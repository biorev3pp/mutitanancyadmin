<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Inertia\Inertia;

class ClientsController extends Controller
{
    public function __construct()
    {
        
    }
    public function index(){
        $clients = Clients::where('status', 1)->get();
        return Inertia::render('Clients/Index', [
            'clients' => $clients,
            'menu' => 'clients'
        ]);
    }
}
