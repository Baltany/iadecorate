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
        // Obtener todos los productos o filtrados por búsqueda/categoría
        $query = Producto::query();

        // Si hay un término de búsqueda
        if ($request->has('buscar') && !empty($request->buscar)) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                ->orWhere('descripcion', 'LIKE', '%' . $buscar . '%');
            });
        }

        $productos = $query->where('stock', '>', 0)->get();

        return view('cliente.catalogo', compact('productos'));
    }


    public function show($id)
    {
        $producto = Producto::findOrFail($id);

        return view('cliente.producto', compact('producto'));
    }


    public function adminIndex()
    {
        $productos = Producto::orderBy('id', 'desc')->paginate(15);
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

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
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = 'storage/' . $path;
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
            if ($producto->imagen) {
                // Remover 'storage/' del path para buscar en disco 'public'
                $oldPath = str_replace('storage/', '', $producto->imagen);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = 'storage/' . $path;
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
        if ($producto->imagen) {
            // Remover 'storage/' del path para buscar en disco 'public'
            $imagePath = str_replace('storage/', '', $producto->imagen);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente');
    }
}
