<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ProjectController;

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

/*
    Rotas de login.
*/
Route::post('login', 'API\AuthController@login');
Route::post('signup', 'API\AuthController@signup');

/* 
    Rotas de autenticação.
*/
Route::middleware(['auth:api'])->group(function () {

    /*
        CRUD Anexos do Projetista
    */
    Route::apiResource('designerannex','API\DesignerAnnexController');

    /*
        Rotas do Inversor.
    */
    Route::apiResource('inverter','API\InverterController');

    /*
        CRUD Modulo
    */
    Route::apiResource('module','API\ModuleController');
  
    /*
        CRUD Projeto
    */
    Route::apiResource('project','API\ProjectController');

    /*
        CRUD Anexo
    */
    Route::apiResource('attachment','API\AttachmentController');

    /*
        CRUD Pre-Instalação
    */
    Route::apiResource('pre-installation','API\PreInstallationController');

    /*
        CRUD Pós Instalação
    */
    Route::apiResource('post-installation','API\PostInstallationController');
  
    /* ROTA ADICIONAL CONTAGEM */
    Route::get('projects/status-count', [ProjectController::class, 'projectStatusCount']);

    Route::middleware(['admin'])->group(function () {
      
        /*
            CRUD Usuario
        */
        Route::apiResource('users','API\UserController');
    });

    /*
        Rotas de login.
    */
    Route::get('logout', 'API\AuthController@logout');
    Route::get('user', 'API\AuthController@user');

});
