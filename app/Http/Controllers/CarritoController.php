<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    /**
     * Mostrar el carrito del usuario autenticado
     */
    public function index()
    {
        $carritoItems = Carrito::where('usuario_id', Auth::id())
            ->with('producto')
            ->get();

        $subtotal = $carritoItems->sum(function($item) {
            return $item->producto->precio * $item->cantidad;
        });

        $envio = 5.99;

        return view('cliente.carrito', compact('carritoItems', 'subtotal', 'envio'));
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        // Buscar si ya existe en el carrito
        $carritoItem = Carrito::where('usuario_id', Auth::id())
            ->where('producto_id', $producto->id)
            ->first();

        if ($carritoItem) {
            // Si ya existe, actualizar cantidad
            $carritoItem->cantidad += $validated['cantidad'];
            $carritoItem->save();
        } else {
            // Si no existe, crear nuevo item
            Carrito::create([
                'usuario_id' => Auth::id(),
                'producto_id' => $producto->id,
                'cantidad' => $validated['cantidad']
            ]);
        }

        return redirect()->route('carrito')->with('success', 'Producto agregado al carrito');
    }

    /**
     * Actualizar cantidad de un item del carrito
     */
    public function actualizar(Request $request, $item)
    {
        $carritoItem = Carrito::where('id', $item)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $carritoItem->cantidad = $validated['cantidad'];
        $carritoItem->save();

        return redirect()->route('carrito')->with('success', 'Carrito actualizado');
    }

    /**
     * Eliminar item del carrito
     */
    public function eliminar($item)
    {
        $carritoItem = Carrito::where('id', $item)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $carritoItem->delete();

        return redirect()->route('carrito')->with('success', 'Producto eliminado del carrito');
    }
}
