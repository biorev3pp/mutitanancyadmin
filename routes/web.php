<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Controllers\DomainsController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\ClientsController;
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
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {
        return Redirect::route('dashboard');
    });

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard')->with('menu', 'dashboard');
    })->name('dashboard');

    Route::get('/setup-client', [SetupController::class, 'index'])->name('setup-client');

    Route::get('/clients', [ClientsController::class, 'index'])->name('clients');

    Route::get('/domains', [DomainsController::class, 'index'])->name('domains');
});
require __DIR__.'/auth.php';
