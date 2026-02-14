<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource (carrito del usuario autenticado).
     */
    public function index(Request $request): JsonResponse
    {
        $items = Carrito::with('producto')
            ->where('usuario_id', $request->user()->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage (añadir producto al carrito).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::find($validated['producto_id']);

        if ($producto->stock < $validated['cantidad']) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuficiente'
            ], 400);
        }

        // Verificar si ya existe en el carrito
        $carritoItem = Carrito::where('usuario_id', $request->user()->id)
            ->where('producto_id', $validated['producto_id'])
            ->first();

        if ($carritoItem) {
            // Actualizar cantidad
            $carritoItem->cantidad += $validated['cantidad'];
            $carritoItem->save();
        } else {
            // Crear nuevo item
            $carritoItem = Carrito::create([
                'usuario_id' => $request->user()->id,
                'producto_id' => $validated['producto_id'],
                'cantidad' => $validated['cantidad']
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto añadido al carrito',
            'data' => $carritoItem->load('producto')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $carritoItem = Carrito::with('producto')->find($id);

        if (!$carritoItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $carritoItem
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $carritoItem = Carrito::find($id);

        if (!$carritoItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::find($carritoItem->producto_id);

        if ($producto->stock < $validated['cantidad']) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuficiente'
            ], 400);
        }

        $carritoItem->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cantidad actualizada',
            'data' => $carritoItem->load('producto')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $carritoItem = Carrito::find($id);

        if (!$carritoItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item no encontrado'
            ], 404);
        }

        $carritoItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito'
        ]);
    }
}
