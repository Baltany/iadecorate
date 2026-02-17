<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Display admin main page
     */
    public function main()
    {
        return view('admin.main');
    }

    /**
     * Display a listing of orders
     */
    public function pedidos()
    {
        $pedidos = Pedido::with(['usuario', 'detalles.producto'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    /**
     * Display the specified order
     */
    public function mostrarPedido($id)
    {
        $pedido = Pedido::with(['usuario', 'detalles.producto'])->findOrFail($id);

        return view('admin.pedidos.show', compact('pedido'));
    }

    /**
     * Update order status
     */
    public function cambiarEstadoPedido(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:pendiente,procesando,enviado,entregado,cancelado'
        ]);

        $pedido->update([
            'estado' => $request->estado
        ]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado exitosamente');
    }

    /**
     * Display a listing of users.
     */
    public function usuarios()
    {
        $usuarios = User::with('roles')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function crearUsuario()
    {
        $roles = Rol::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function guardarUsuario(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'apellidos' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'ciudad' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:10',
            'fecha_nacimiento' => 'nullable|date',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'apellidos' => $validated['apellidos'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'ciudad' => $validated['ciudad'] ?? null,
            'codigo_postal' => $validated['codigo_postal'] ?? null,
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
        ]);

        if (isset($validated['roles'])) {
            $user->roles()->attach($validated['roles']);
        }

        return redirect()->route('admin.usuarios')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function editarUsuario(User $usuario)
    {
        $roles = Rol::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function actualizarUsuario(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'apellidos' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'ciudad' => 'nullable|string|max:100',
            'codigo_postal' => 'nullable|string|max:10',
            'fecha_nacimiento' => 'nullable|date',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $usuario->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'apellidos' => $validated['apellidos'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'ciudad' => $validated['ciudad'] ?? null,
            'codigo_postal' => $validated['codigo_postal'] ?? null,
            'fecha_nacimiento' => $validated['fecha_nacimiento'] ?? null,
        ]);

        if ($request->filled('password')) {
            $usuario->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        if (isset($validated['roles'])) {
            $usuario->roles()->sync($validated['roles']);
        }

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified user from storage.
     */
    public function eliminarUsuario(User $usuario)
    {
        // Evitar que el admin se elimine a sí mismo
        if ($usuario->id === Auth::user()->id) {
            return redirect()->route('admin.usuarios')->with('error', 'No puedes eliminarte a ti mismo');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado exitosamente');
    }
}
