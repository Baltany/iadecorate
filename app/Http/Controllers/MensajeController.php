<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    /**
     * Mostrar mensajería del usuario
     */
    public function index()
    {
        // Obtener todos los usuarios excepto el actual y los administradores
        $usuarios = User::whereDoesntHave('roles', function ($query) {
            $query->where('nombre', 'administrador');
        })
        ->where('id', '!=', Auth::id())
        ->orderBy('name', 'asc')
        ->get();

        // Obtener mensajes del usuario (conversaciones con admin o soporte)
        $mensajes = Mensaje::where('usuario_id', Auth::id())
            ->orWhere('destinatario_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('mensajeria', compact('mensajes', 'usuarios'));
    }

    /**
     * Enviar un mensaje
     */
    public function enviar(Request $request)
    {
        $validated = $request->validate([
            'mensaje' => 'required|string|max:1000',
            'destinatario_id' => 'nullable|exists:users,id',
        ]);

        Mensaje::create([
            'usuario_id' => Auth::id(),
            'destinatario_id' => $validated['destinatario_id'] ?? 1, // 1 = Admin por defecto
            'mensaje' => $validated['mensaje'],
        ]);

        return redirect()->route('mensajeria')->with('success', 'Mensaje enviado');
    }
}
