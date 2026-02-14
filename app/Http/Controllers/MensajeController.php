<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    /**
     * Mostrar mensajería del usuario
     */
    public function index()
    {
        // Obtener mensajes del usuario (conversaciones con admin o soporte)
        $mensajes = Mensaje::where('usuario_id', Auth::id())
            ->orWhere('destinatario_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('mensajeria', compact('mensajes'));
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
