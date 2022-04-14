<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\DomainsController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServerController;
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
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {
        return Redirect::route('dashboard');
    });

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard')->with('menu', 'dashboard');
    })->name('dashboard');

    Route::get('/server', function () {
        return Inertia::render('Server/Index')->with('menu', 'server');
    })->name('server');

    Route::get('/setup-client', [SetupController::class, 'index'])->name('setup-client');

    Route::get('/clients', [ClientsController::class, 'index'])->name('clients');

    Route::get('/domains', [DomainsController::class, 'index'])->name('domains');
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
    Route::get('/client-projects/{client_code}', [ProjectsController::class, 'clientProject'])->name('client-projects');
    Route::get(
        '/users',
        function () {
            return Inertia::render(
                'Users', ['title' => 'Users',]
            );
        }
    )->name( 'users' );
    Route::get('/database', [DatabaseController::class, 'index'])->name( 'database' );
    // Route::post('/save-project-data', [DomainsController::class, 'saveProjectData']);
    //Route::get('/create-db', [App\Http\Controllers\API\SetupController::class, 'UpdateDatabase']);
});
require __DIR__.'/auth.php';
