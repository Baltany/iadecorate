<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    /**
     * Mostrar mensajeria del usuario
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

        // Obtener mensajes SOLO de la conversacion entre estos dos usuarios
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

        return view('cliente.mensajeria', compact('mensajes', 'usuarios', 'destinatarioId'));
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

        $mensaje = Mensaje::create([
            'usuario_id' => Auth::id(),
            'destinatario_id' => $validated['destinatario_id'],
            'mensaje' => $validated['mensaje'],
        ]);

        // Si es una peticion AJAX, devolver JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'mensaje_id' => $mensaje->id,
                'mensaje' => $mensaje->mensaje,
                'usuario_id' => $mensaje->usuario_id,
            ]);
        }

        // Si es peticion normal, redirigir
        return redirect()->route('mensajeria', ['destinatario_id' => $validated['destinatario_id']])
            ->with('success', 'Mensaje enviado');
    }

    /**
     * Obtener nuevos mensajes para polling (AJAX)
     */
    public function obtenerNuevos(Request $request)
    {
        $destinatarioId = $request->get('destinatario_id');
        $ultimoMensajeId = $request->get('ultimo_mensaje_id', 0);

        if (!$destinatarioId) {
            return response()->json(['mensajes' => []]);
        }

        // Obtener mensajes nuevos de la conversacion
        $mensajes = Mensaje::where('id', '>', $ultimoMensajeId)
            ->where(function($query) use ($destinatarioId) {
                $query->where(function($q) use ($destinatarioId) {
                    $q->where('usuario_id', Auth::id())
                      ->where('destinatario_id', $destinatarioId);
                })->orWhere(function($q) use ($destinatarioId) {
                    $q->where('usuario_id', $destinatarioId)
                      ->where('destinatario_id', Auth::id());
                });
            })
            ->with('usuario.roles')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'mensajes' => $mensajes->map(function($mensaje) {
                return [
                    'id' => $mensaje->id,
                    'mensaje' => $mensaje->mensaje,
                    'usuario_id' => $mensaje->usuario_id,
                    'usuario_nombre' => $mensaje->usuario->name,
                    'usuario_inicial' => strtoupper(substr($mensaje->usuario->name, 0, 1)),
                    'es_usuario_actual' => $mensaje->usuario_id == Auth::id(),
                    'es_admin' => $mensaje->usuario->roles->contains('nombre', 'admin'),
                    'created_at' => $mensaje->created_at->format('H:i'),
                ];
            }),
            'hay_nuevos' => $mensajes->where('usuario_id', '!=', Auth::id())->count() > 0
        ]);
    }

    /**
     * Obtener conteo de mensajes no leidos (notificaciones globales)
     */
    public function conteoNoLeidos()
    {
        // Obtener mensajes donde el usuario actual es el destinatario
        // y fueron enviados en el último minuto (mensajes "muy nuevos")
        $mensajes = Mensaje::where('destinatario_id', Auth::id())
            ->where('created_at', '>', now()->subMinute())
            ->with('usuario.roles')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'conteo' => $mensajes->count(),
            'mensajes' => $mensajes->map(function($mensaje) {
                return [
                    'id' => $mensaje->id,
                    'mensaje' => $mensaje->mensaje,
                    'usuario_id' => $mensaje->usuario_id,
                    'usuario_nombre' => $mensaje->usuario->name,
                    'usuario_inicial' => strtoupper(substr($mensaje->usuario->name, 0, 1)),
                    'es_admin' => $mensaje->usuario->roles->contains('nombre', 'admin'),
                    'created_at' => $mensaje->created_at->format('H:i'),
                ];
            })
        ]);
    }
}
