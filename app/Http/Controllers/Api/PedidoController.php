<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource (pedidos del usuario autenticado).
     */
    public function index(Request $request): JsonResponse
    {
        $pedidos = Pedido::with('detalles.producto')
            ->where('usuario_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pedidos
        ]);
    }

    /**
     * Store a newly created resource in storage (crear pedido desde carrito).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'metodo_pago' => 'nullable|string',
            'direccion_envio' => 'nullable|string'
        ]);

        // Obtener items del carrito
        $carritoItems = Carrito::with('producto')
            ->where('usuario_id', $request->user()->id)
            ->get();

        if ($carritoItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'El carrito está vacío'
            ], 400);
        }

        // Verificar stock
        foreach ($carritoItems as $item) {
            if ($item->producto->stock < $item->cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => "Stock insuficiente para {$item->producto->nombre}"
                ], 400);
            }
        }

        // Crear pedido con transacción
        DB::beginTransaction();
        try {
            $total = $carritoItems->sum(function ($item) {
                return $item->cantidad * $item->producto->precio;
            });

            $pedido = Pedido::create([
                'usuario_id' => $request->user()->id,
                'total' => $total,
                'estado' => 'pendiente'
            ]);

            // Crear detalles del pedido y actualizar stock
            foreach ($carritoItems as $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->producto->precio
                ]);

                // Reducir stock
                $producto = Producto::find($item->producto_id);
                $producto->stock -= $item->cantidad;
                $producto->save();
            }

            // Vaciar carrito
            Carrito::where('usuario_id', $request->user()->id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido creado exitosamente',
                'data' => $pedido->load('detalles.producto')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $pedido = Pedido::with('detalles.producto')->find($id);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pedido
        ]);
    }

    /**
     * Update the specified resource in storage (actualizar estado del pedido).
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'estado' => 'required|string|in:pendiente,procesando,enviado,entregado,cancelado'
        ]);

        $pedido->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Estado del pedido actualizado',
            'data' => $pedido
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        // Solo permitir cancelar pedidos pendientes
        if ($pedido->estado !== 'pendiente') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden cancelar pedidos pendientes'
            ], 400);
        }

        $pedido->update(['estado' => 'cancelado']);

        return response()->json([
            'success' => true,
            'message' => 'Pedido cancelado'
        ]);
    }
}
