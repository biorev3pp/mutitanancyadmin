<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\DomainsController;
use App\Http\Controllers\ClientController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('products', ProductsController::class);

Route::get(
    '/users',
    function () {
        return Inertia::render(
            'Users',
            [
                'title' => 'Users',
            ]
        );
    }
)->name( 'users' );

Route::get(
    '/clients',
    [ClientController::class, 'index']
)->name( 'clients' );
Route::post(
    '/clientsave',
    [ClientController::class, 'save']
)->name( 'clientsave' );
Route::get(
    '/database',
    [DatabaseController::class, 'index']
    // function () {
    //     return Inertia::render(
    //         'Database',
    //         [
    //             'title' => 'Database',
    //         ]
    //     );
    // }
)->name( 'database' );
Route::get(
    '/domains',
    [DomainsController::class, 'index']
    // function () {
    //     return Inertia::render(
    //         'Domains',
    //         [
    //             'title' => 'Domains',
    //         ]
    //     );
    // }
)->name( 'domains' );
// Route::get('/products', [ProductsController::class, 'index'])->middleware(['auth', 'verified'])->name( 'products' );
// Route::get(
//     '/about',
//     function () {
//         return Inertia::render(
//             'About',
//             [
//                 'title' => 'About',
//             ]
//         );
//     }
// )->name( 'about' );

require __DIR__.'/auth.php';
