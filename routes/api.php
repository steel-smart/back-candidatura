<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PlacaController;
use App\Http\Controllers\UsuarioController;

Route::group(['prefix' => 'v1'], function () {
    // rotas para login
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });






 
    //rotas para controle de empresas
    Route::group([
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'namespace' => 'empresa',
        'prefix' => 'empresa',
    ], function () {
        Route::get('/', [EmpresaController::class, 'index'])->middleware('permission:ra_Empresa');
        Route::post('criar', [EmpresaController::class, 'store'])->middleware('permission:c_Empresa');
        Route::get('bloquear/{id}', [EmpresaController::class, 'block'])->middleware('permission:lock_Empresa');
        Route::get('desbloquear/{id}', [EmpresaController::class, 'unlock'])->middleware('permission:unlock_Empresa');
        Route::put('atualizar/{id}', [EmpresaController::class, 'update'])->middleware('permission:u_Empresa');
        Route::get('{id}', [EmpresaController::class, 'show'])->middleware('permission:r_Empresa');
    });

    



  


    //rotas para controle de contas usuario
    Route::group([
        'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
        'namespace' => 'usuario',
        'prefix' => 'usuario',
    ], function () {
        Route::post('/', [UsuarioController::class, 'store']);
        Route::put('/{id}', [UsuarioController::class, 'update']);
        Route::get('/', [UsuarioController::class, 'index']);
        Route::delete('/{id}', [UsuarioController::class, 'destroy']);
        Route::get('/git', [UsuarioController::class, 'index_usuarios_git']);


        
    });

        //rotas para controle de contas usuario
        Route::group([
            'middleware' => 'apiJwt', //Criado em Middleware/apiProtected
            'namespace' => 'placa',
            'prefix' => 'placa',
        ], function () {
            Route::post('/', [PlacaController::class, 'store']);
            Route::put('/{id}', [PlacaController::class, 'update']);
            Route::get('/', [PlacaController::class, 'index']);
            Route::delete('/{id}', [PlacaController::class, 'destroy']);
    
     
        });

    



 
});
