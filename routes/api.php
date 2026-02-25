<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\PedidoController;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json(['token' => $token]);
});


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

