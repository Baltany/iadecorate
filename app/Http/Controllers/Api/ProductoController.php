<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $productos = Producto::all()->map(function($producto) {
            return $this->transformProducto($producto);
        });

        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|string',
            'categoria_id' => 'nullable|exists:categorias,id'
        ]);

        $producto = Producto::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente',
            'data' => $this->transformProducto($producto)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        /** @var Producto|null $producto */
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->transformProducto($producto)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        /** @var Producto|null $producto */
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'imagen' => 'nullable|string',
            'categoria_id' => 'nullable|exists:categorias,id'
        ]);

        $producto->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente',
            'data' => $this->transformProducto($producto)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        /** @var Producto|null $producto */
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente'
        ]);
    }

    /**
     * Transform producto para incluir URL completa de imagen
     */
    private function transformProducto(Producto $producto): array
    {
        return [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'imagen' => $producto->imagen ? url($producto->imagen) : null,
            'imagen_url' => $producto->imagen ? asset($producto->imagen) : asset('img/imageDecorate.png'),
            'categoria_id' => $producto->categoria_id,
            'created_at' => $producto->created_at,
            'updated_at' => $producto->updated_at,
        ];
    }
}