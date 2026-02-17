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
    public function index(Request $request)
    {
        // Obtener todos los usuarios excepto el actual y los administradores
        $usuarios = User::whereDoesntHave('roles', function ($query) {
            $query->where('nombre', 'administrador');
        })
        ->where('id', '!=', Auth::id())
        ->orderBy('name', 'asc')
        ->get();

        // Obtener el destinatario seleccionado (si hay)
        $destinatarioId = $request->get('destinatario_id', $usuarios->first()->id ?? null);

        // Obtener mensajes SOLO de la conversación entre estos dos usuarios
        $mensajes = collect();
        if ($destinatarioId) {
            $mensajes = Mensaje::where(function($query) use ($destinatarioId) {
                $query->where('usuario_id', Auth::id())
                      ->where('destinatario_id', $destinatarioId);
            })->orWhere(function($query) use ($destinatarioId) {
                $query->where('usuario_id', $destinatarioId)
                      ->where('destinatario_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
        }

        return view('mensajeria', compact('mensajes', 'usuarios', 'destinatarioId'));
    }

    /**
     * Enviar un mensaje
     */
    public function enviar(Request $request)
    {
        $validated = $request->validate([
            'mensaje' => 'required|string|max:1000',
            'destinatario_id' => 'required|exists:users,id',
        ]);

        Mensaje::create([
            'usuario_id' => Auth::id(),
            'destinatario_id' => $validated['destinatario_id'],
            'mensaje' => $validated['mensaje'],
        ]);

        return redirect()->route('mensajeria', ['destinatario_id' => $validated['destinatario_id']])
            ->with('success', 'Mensaje enviado');
    }
}
