<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\ModuloController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\OpcionController;

use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolopcionController;
use App\Http\Controllers\Api\RolusuarioController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    
    Route::apiResource('empresas', EmpresaController::class);
    Route::apiResource('modulos', ModuloController::class);
    Route::apiResource('menus', MenuController::class);
    Route::get('menus/modulo/{id}',[MenuController::class, 'getByModulo']);
    Route::apiResource('opciones', OpcionController::class);
    Route::get('opciones/menu/{id}',[OpcionController::class, 'getByMenu']);
    Route::apiResource('roles', RolController::class);
    Route::get('roles/empresa/{id}',[RolController::class, 'getByEmpresa']);
    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('rol-opcion', OpcionController::class);
    Route::get('rol-opcion/empresa/{id}',[RolopcionController::class, 'getByEmpresa']);
    Route::get('rol-opcion/rol/{id}',[RolopcionController::class, 'getByRol']);
    Route::apiResource('rol-usuario', RolopcionController::class);
    Route::get('rol-usuario/empresa/{id}',[RolusuarioController::class, 'getByEmpresa']);
    Route::get('rol-usuario/rol/{id}',[RolusuarioController::class, 'getByRol']);
});
