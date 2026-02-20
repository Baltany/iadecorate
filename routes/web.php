<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\AdminController;

// ==========================================
// RUTAS PÚBLICAS (Sin autenticación)
// ==========================================

// Página principal - Inicio (index)
Route::get('/', function () {
    return view('index');
})->name('home');

// Información - Público
Route::get('/info', function () {
    return view('info');
})->name('info');

// ==========================================
// RUTAS PROTEGIDAS (Requieren autenticación Y email verificado)
// ==========================================

Route::middleware(['auth', 'verified'])->group(function () {

    // Catálogo - Requiere autenticación y email verificado
    Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');

    // Detalle de producto - Requiere autenticación y email verificado
    Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('producto.detalle');

    // Carrito - Solo usuarios logueados pueden ver y gestionar su carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('/carrito/{item}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/actualizar/{item}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');

    // Checkout y pago
    Route::get('/checkout', [PedidoController::class, 'checkout'])->name('checkout');
    Route::post('/pedido/crear', [PedidoController::class, 'crear'])->name('pedido.crear');

    // Pedidos - Solo usuarios logueados pueden ver sus pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos');
    Route::get('/pedido/{id}', [PedidoController::class, 'show'])->name('pedido.detalle');

    // Perfil - Solo usuarios logueados
    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');
    Route::put('/perfil/actualizar', [UsuarioController::class, 'actualizar'])->name('perfil.actualizar');

    // Mensajería - Solo usuarios logueados
    Route::get('/mensajeria', [MensajeController::class, 'index'])->name('mensajeria');
    Route::post('/mensajeria/enviar', [MensajeController::class, 'enviar'])->name('mensajeria.enviar');
    Route::get('/mensajeria/obtener-nuevos', [MensajeController::class, 'obtenerNuevos'])->name('mensajeria.obtener-nuevos');
    Route::get('/mensajeria/conteo-no-leidos', [MensajeController::class, 'conteoNoLeidos'])->name('mensajeria.conteo-no-leidos');

    // Incidencias - Solo usuarios logueados
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias');
    Route::post('/incidencias/crear', [IncidenciaController::class, 'crear'])->name('incidencias.crear');

    // Entorno 3D - Solo usuarios logueados
    Route::get('/entorno', function () {
        return view('entorno'); // Vista del entorno 3D
    })->name('entorno');

});

// ==========================================
// RUTAS ADMINISTRADOR (Requieren autenticación y rol admin)
// ==========================================

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Main / Dashboard
    Route::get('/main', [AdminController::class, 'main'])->name('main');

    // Gestión de usuarios
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/usuarios/crear', [AdminController::class, 'crearUsuario'])->name('usuarios.create');
    Route::post('/usuarios', [AdminController::class, 'guardarUsuario'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}/editar', [AdminController::class, 'editarUsuario'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [AdminController::class, 'actualizarUsuario'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [AdminController::class, 'eliminarUsuario'])->name('usuarios.destroy');

    // Gestión de pedidos
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [AdminController::class, 'mostrarPedido'])->name('pedidos.show');
    Route::patch('/pedidos/{id}/estado', [AdminController::class, 'cambiarEstadoPedido'])->name('pedidos.cambiarEstado');

    // Gestión de productos
    Route::get('/productos', [ProductoController::class, 'adminIndex'])->name('productos.index');
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

// Ruta del dashboard (Flux - para compatibilidad)

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
