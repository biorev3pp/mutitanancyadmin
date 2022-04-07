<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function __construct()
    {
        
    }
    public function index(){
        $clients = Client::orderBy('name', 'desc')->paginate(10);
        // dd($clients);
        return Inertia::render('Clients/Index', [
            'clients' => $clients
        ]);
    }
    public function save(Request $request){
        dd($request->all());
    }
}
