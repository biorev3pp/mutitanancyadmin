<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DomainsController;
use App\Http\Controllers\API\SetupController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/update-client-status', [ClientController::class, 'save']);

Route::apiResource('clients', App\Http\Controllers\API\ClientsController::class);
Route::get('/check-domain/{domain}', [DomainsController::class, 'checkDomain']);
// Route::post('/validate-project-data', [DomainsController::class, 'validateProjectData']);
Route::post('/save-project-data',  [DomainsController::class, 'saveProjectData']);
Route::post('/update-project-data',  [DomainsController::class, 'updateProjectData']);
Route::post('/validate-project-data', [SetupController::class, 'validateProjectData']);

Route::post('/save-client-info', [SetupController::class, 'SaveClientInfo']);
Route::post('/save-project-info', [SetupController::class, 'SaveProjectInfo']);
Route::post('/create-database', [SetupController::class, 'CreateDatabase']);
Route::post('/set-db-privileges', [SetupController::class, 'SetDbPrivileges']);
Route::post('/adding-sub-domain', [SetupController::class, 'AddingSubDomain']);
Route::post('/transfering-files', [SetupController::class, 'TranasferingFiles']);
Route::post('/updating-env', [SetupController::class, 'UpdatingEnv']);
Route::post('/update-database', [SetupController::class, 'UpdateDatabase']);


Route::post('/validate-client-data', [SetupController::class, 'ValidateClientData']);
