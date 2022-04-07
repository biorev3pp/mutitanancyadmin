<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CpanelController;
use App\Models\Post;
use Inertia\Inertia;


class DatabaseController extends Controller
{
    
    public function __construct()
    {
        
    }

    public function index()
    {
        $cpanel = new CpanelController(env('CPANEL_USER'), env('CPANEL_KEY'),env('CPANEL_HOST'));
        $result = $cpanel->execute("api2", "MysqlFE", "listdbs");
        // dd($result);
        return Inertia::render('Database', ['databases' => $result]);
        // return Inertia::render('Products/Index', [
        //     "products" => Product::orderBy('id', 'DESC')->paginate(10)
        // ]);
    } 

}