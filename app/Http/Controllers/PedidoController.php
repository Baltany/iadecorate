<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Mostrar todos los pedidos del usuario autenticado
     */
    public function index()
    {
        $pedidos = Pedido::where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pedidos', compact('pedidos'));
    }

    /**
     * Mostrar detalle de un pedido específico
     */
    public function show($id)
    {
        $pedido = Pedido::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->with('detalles.producto')
            ->firstOrFail();

        return view('pedido-detalle', compact('pedido'));
    }

    /**
     * Mostrar página de checkout
     */
    public function checkout()
    {
        $carritoItems = Carrito::where('usuario_id', Auth::id())
            ->with('producto')
            ->get();

        if ($carritoItems->isEmpty()) {
            return redirect()->route('carrito')->with('error', 'Tu carrito está vacío');
        }

        $subtotal = $carritoItems->sum(function($item) {
            return $item->producto->precio * $item->cantidad;
        });

        $envio = 5.99;
        $total = $subtotal + $envio;

        return view('checkout', compact('carritoItems', 'subtotal', 'envio', 'total'));
    }

    /**
     * Crear un nuevo pedido
     */
    public function crear(Request $request)
    {
        $validated = $request->validate([
            'direccion_envio' => 'required|string',
            'metodo_pago' => 'required|string|in:tarjeta,paypal,transferencia,contrareembolso',
        ]);

        DB::beginTransaction();

        try {
            // Obtener items del carrito
            $carritoItems = Carrito::where('usuario_id', Auth::id())
                ->with('producto')
                ->get();

            if ($carritoItems->isEmpty()) {
                return redirect()->route('carrito')->with('error', 'El carrito está vacío');
            }

            // Validar stock disponible para cada producto
            foreach ($carritoItems as $item) {
                if ($item->producto->stock < $item->cantidad) {
                    DB::rollBack();
                    return redirect()->route('carrito')->with('error',
                        "Stock insuficiente para {$item->producto->nombre}. Disponibles: {$item->producto->stock}"
                    );
                }
            }

            // Calcular total
            $subtotal = $carritoItems->sum(function($item) {
                return $item->producto->precio * $item->cantidad;
            });
            $envio = 5.99;
            $total = $subtotal + $envio;

            // Crear pedido
            $pedido = Pedido::create([
                'usuario_id' => Auth::id(),
                'total' => $total,
                'estado' => 'pendiente',
                'direccion_envio' => $validated['direccion_envio'],
                'metodo_pago' => $validated['metodo_pago'],
            ]);

            // Crear detalles del pedido y actualizar stock
            foreach ($carritoItems as $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->producto->precio,
                ]);

                // Reducir stock del producto
                $item->producto->decrement('stock', $item->cantidad);
            }

            // Vaciar el carrito
            Carrito::where('usuario_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('pedidos')->with('success', 'Pedido realizado exitosamente. ¡Gracias por tu compra!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear el pedido: ' . $e->getMessage());
        }
    }
}
