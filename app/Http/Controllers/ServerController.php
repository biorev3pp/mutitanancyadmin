<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CpanelController;
use App\Models\Post;
use Inertia\Inertia;


class ServerController extends Controller
{
    
    public function __construct()
    {
        
    }

    public function index()
    {
        $cpanel = new CpanelController(env('CPANEL_USER'), env('CPANEL_KEY'),env('CPANEL_HOST'));
        $result = $cpanel->execute("uapi", "ServerInformation", "get_information");
        // dd($result);
        return Inertia::render('Server/Index', ['response' => $result, 'menu' => 'server']);
        // return Inertia::render('Products/Index', [
        //     "products" => Product::orderBy('id', 'DESC')->paginate(10)
        // ]);
    } 

}