<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Mostrar el catálogo de productos (PÚBLICO)
     */
    public function index(Request $request)
    {
        // Obtener todos los productos o filtrados por búsqueda
        $query = Producto::query();

        // Si hay un término de búsqueda
        if ($request->has('buscar') && !empty($request->buscar)) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('descripcion', 'LIKE', '%' . $buscar . '%');
            });
        }

        $productos = $query->get();

        return view('catalogo', compact('productos'));
    }

    /**
     * Mostrar detalle de un producto (PÚBLICO)
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);

        return view('producto', compact('producto'));
    }

    /**
     * Display a listing of products (ADMIN)
     */
    public function adminIndex()
    {
        $productos = Producto::orderBy('id', 'desc')->paginate(15);
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new product (ADMIN)
     */
    public function create()
    {
        return view('admin.productos.create');
    }

    /**
     * Show the form for editing the specified product (ADMIN)
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.edit', compact('producto'));
    }

    /**
     * Crear un nuevo producto (ADMIN)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        // Manejar la subida de imagen
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validated);

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Actualizar producto (ADMIN)
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        // Manejar la subida de nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($validated);

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Eliminar producto (ADMIN)
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Eliminar imagen asociada si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente');
    }
}
