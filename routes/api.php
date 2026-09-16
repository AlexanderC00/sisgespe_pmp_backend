<?php

use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Sin Autenticación)
|--------------------------------------------------------------------------
*/
Route::prefix('user')->group(function () {
    Route::post('/register', [UserController::class, 'newUser']);
    Route::post('/login', [UserController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Token Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth Logout
    Route::post('/user/logout', [UserController::class, 'logout']);

    // Módulo: Producto
    Route::prefix('producto')->group(function () {
        Route::get('/', [ProductoController::class, 'index']); // Clientes y Admin

        // Acciones solo para Administrador
        Route::middleware('admin')->group(function () {
            Route::post('/', [ProductoController::class, 'store']);
            Route::delete('/{id}', [ProductoController::class, 'destroy']);
        });
    });

    // Módulo: Inventario (Gestión de stock exclusiva para Administrador)
    Route::prefix('inventario')->middleware('admin')->group(function () {
        Route::get('/', [InventarioController::class, 'index']);
        Route::put('/{id}', [InventarioController::class, 'update']);
        Route::patch('/{id}', [InventarioController::class, 'update']);
    });

    // Módulo: Pedido (Clientes y Admin con aislamiento de seguridad)
    Route::prefix('pedido')->group(function () {
        Route::get('/', [PedidoController::class, 'index']);
        Route::post('/', [PedidoController::class, 'store']);
        Route::delete('/{id}', [PedidoController::class, 'destroy']);
    });
});
