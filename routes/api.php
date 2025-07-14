<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\api\MetodosExternosController;

use App\Http\Controllers\api\EmpresaController;
use App\Http\Controllers\api\ModuloController;
use App\Http\Controllers\api\MenuController;
use App\Http\Controllers\api\OpcionController;

use App\Http\Controllers\api\RolController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\RolopcionController;
use App\Http\Controllers\api\RolusuarioController;
use App\Http\Controllers\api\PeriodoController;
use App\Http\Controllers\api\ProcesoController;
use App\Http\Controllers\api\TipoProcesoController;
use App\Http\Controllers\api\AreaController;
use App\Http\Controllers\api\PeriodoAreaProcesoController;
use App\Http\Controllers\api\DocumentoController;


Route::get('empresas-externo', [MetodosExternosController::class, 'empresas']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', function() {
    return response()->json([
        'message' => 'Unauthenticated.',
        'error' => 'Please login using POST method with credentials'
    ], 401);
});


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
    Route::put('usuarios/{id}/password',[UserController::class, 'updatePassword']);
    Route::apiResource('rol-opcion', RolopcionController::class);
    Route::get('rol-opcion/empresa/{id}',[RolopcionController::class, 'getByEmpresa']);
    Route::get('rol-opcion/rol/{id}',[RolopcionController::class, 'getByRol']);
    Route::apiResource('rol-usuario', RolusuarioController::class);
    Route::get('rol-usuario/empresa/{id}',[RolusuarioController::class, 'getByEmpresa']);
    Route::get('rol-usuario/rol/{id}',[RolusuarioController::class, 'getByRol']);
    Route::apiResource('periodos', PeriodoController::class);
    Route::get('periodos/empresa/{id_empresa}',[PeriodoController::class, 'getByEmpresa']);
    Route::apiResource('tipo-procesos', TipoProcesoController::class);
    Route::get('tipo-procesos/empresa/{id_empresa}',[TipoProcesoController::class, 'getByEmpresa']);
    Route::apiResource('areas', AreaController::class);
    Route::get('areas/empresa/{id_empresa}',[AreaController::class, 'getByEmpresa']);
    Route::apiResource('procesos', ProcesoController::class);
    Route::get('procesos/empresa/{id_empresa}',[ProcesoController::class, 'getByEmpresa']);
    
    // Periodo Area Proceso routes
    Route::apiResource('periodo-area-proceso', PeriodoAreaProcesoController::class);
    Route::get('periodo-area-proceso/periodo/{id_periodo}', [PeriodoAreaProcesoController::class, 'getByPeriodo']);
    Route::get('periodo-area-proceso/area/{id_area}', [PeriodoAreaProcesoController::class, 'getByArea']);
    Route::get('periodo-area-proceso/proceso/{id_proceso}', [PeriodoAreaProcesoController::class, 'getByProceso']);
    Route::get('periodo-area-proceso/empresa/{id_empresa}', [PeriodoAreaProcesoController::class, 'getByEmpresa']);
    
    // Documentos routes
    Route::apiResource('documentos', DocumentoController::class);
    Route::get('documentos/configuracion/{id_configuracion}', [DocumentoController::class, 'getByConfiguracion']);
    Route::get('documentos/empresa/{id_empresa}', [DocumentoController::class, 'getByEmpresa']);
    Route::get('documentos/estado/{estado}', [DocumentoController::class, 'getByEstado']);
    Route::get('documentos/usuario-grabo/{id_usuario}', [DocumentoController::class, 'getByUsuarioGrabo']);
    Route::get('documentos/usuario-editor/{id_usuario}', [DocumentoController::class, 'getByUsuarioEditor']);
    Route::get('documentos/usuario-responsable/{id_usuario}', [DocumentoController::class, 'getByUsuarioResponsable']);
    Route::post('documentos/search', [DocumentoController::class, 'searchByDescription']);
    Route::post('documentos/date-range', [DocumentoController::class, 'getByDateRange']);
    Route::get('documentos/periodo-area-proceso/{id_periodo}/{id_area}/{id_proceso}', [DocumentoController::class, 'getByPeriodoAreaProceso']);
    Route::get('documentos-details', [DocumentoController::class, 'getDocumentosWithDetails']);
    
    // Image handling routes
    Route::post('documentos/save-image', [DocumentoController::class, 'saveImage']);
    Route::get('documentos/{id_documento}/load-image', [DocumentoController::class, 'loadImage']);
    Route::delete('documentos/{id_documento}/delete-image', [DocumentoController::class, 'deleteImage']);
});
