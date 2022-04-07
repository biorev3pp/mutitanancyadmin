<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Product;

class ProductsController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        return Inertia::render('Products/Index', [
            "products" => Product::orderBy('id', 'DESC')->paginate(10)
        ]);
    } 

}