<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\PedidoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas públicas
Route::apiResource('productos', ProductoController::class)->only(['index', 'show']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Productos (admin)
    Route::apiResource('productos', ProductoController::class)->except(['index', 'show']);

    // Carrito
    Route::apiResource('carrito', CarritoController::class);

    // Pedidos
    Route::apiResource('pedidos', PedidoController::class);
});
