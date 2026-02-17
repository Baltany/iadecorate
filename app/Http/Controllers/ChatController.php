<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMensaje;
use App\Models\User;
use App\Http\Requests\ChatMensajeRequest;
use App\Notifications\ChatMensajeRecibidoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Mostrar la lista de chats del usuario
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin ve todos los chats
            $chats = Chat::with(['usuario1', 'usuario2', 'ultimoMensaje.usuario'])
                ->orderBy('ultimo_mensaje_at', 'desc')
                ->paginate(20);
        } else {
            // Usuario regular ve solo su chat anónimo
            $chats = Chat::where(function ($query) use ($user) {
                    $query->where('usuario1_id', $user->id)
                        ->orWhere('usuario2_id', $user->id);
                })
                ->with(['usuario1', 'usuario2', 'ultimoMensaje.usuario'])
                ->orderBy('ultimo_mensaje_at', 'desc')
                ->get();
        }

        return view('chat.index', compact('chats'));
    }

    /**
     * Mostrar un chat específico
     */
    public function show($chatId)
    {
        $user = Auth::user();
        $chat = Chat::with(['usuario1', 'usuario2'])->findOrFail($chatId);

        // Verificar permisos
        if (!$user->hasRole('admin') && !$chat->perteneceAlUsuario($user->id)) {
            abort(403, 'No tienes permiso para ver este chat');
        }

        // Marcar mensajes como leídos
        ChatMensaje::where('chat_id', $chat->id)
            ->where('usuario_id', '!=', $user->id)
            ->where('leido', false)
            ->update(['leido' => true]);

        // Cargar mensajes del chat
        $mensajes = $chat->mensajes()
            ->with('usuario')
            ->orderBy('created_at', 'asc')
            ->get();

        // Determinar el otro usuario (para mostrar nombre o "Anónimo")
        $otroUsuario = $chat->otroUsuario($user->id);

        return view('chat.show', compact('chat', 'mensajes', 'otroUsuario'));
    }

    /**
     * Obtener o crear chat anónimo para un usuario
     */
    public function obtenerOCrearChatAnonimo()
    {
        $user = Auth::user();

        // Buscar si ya tiene un chat anónimo
        $chat = Chat::where(function ($query) use ($user) {
                $query->where('usuario1_id', $user->id)
                    ->orWhere('usuario2_id', $user->id);
            })
            ->where('is_anonymous', true)
            ->first();

        // Si no existe, crear uno nuevo con un usuario aleatorio
        if (!$chat) {
            $chat = $this->crearChatAnonimo($user->id);
        }

        return redirect()->route('chat.show', $chat->id);
    }

    /**
     * Crear un chat anónimo con un usuario aleatorio
     */
    protected function crearChatAnonimo($userId)
    {
        // Obtener usuarios que no sean el actual y que no tengan chat con él
        $usuariosDisponibles = User::where('id', '!=', $userId)
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('usuario2_id')
                    ->from('chats')
                    ->where('usuario1_id', $userId);
            })
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('usuario1_id')
                    ->from('chats')
                    ->where('usuario2_id', $userId);
            })
            ->get();

        // Si no hay usuarios disponibles, emparejarlo con cualquier usuario aleatorio
        if ($usuariosDisponibles->isEmpty()) {
            $usuarioAnonimo = User::where('id', '!=', $userId)->inRandomOrder()->first();
        } else {
            $usuarioAnonimo = $usuariosDisponibles->random();
        }

        // Crear el chat
        return Chat::create([
            'usuario1_id' => $userId,
            'usuario2_id' => $usuarioAnonimo->id,
            'is_anonymous' => true,
            'ultimo_mensaje_at' => now(),
        ]);
    }

    /**
     * Enviar un mensaje en un chat
     */
    public function enviarMensaje(ChatMensajeRequest $request, $chatId)
    {
        $user = Auth::user();
        $chat = Chat::findOrFail($chatId);

        // Verificar permisos
        if (!$user->hasRole('admin') && !$chat->perteneceAlUsuario($user->id)) {
            abort(403, 'No tienes permiso para enviar mensajes en este chat');
        }

        // Crear el mensaje
        $mensaje = ChatMensaje::create([
            'chat_id' => $chat->id,
            'usuario_id' => $user->id,
            'contenido' => $request->contenido,
            'leido' => false,
        ]);

        // Actualizar el timestamp del último mensaje
        $chat->update([
            'ultimo_mensaje_at' => now(),
        ]);

        // Enviar notificación al otro usuario
        $otroUsuario = $chat->otroUsuario($user->id);
        if ($otroUsuario) {
            $otroUsuario->notify(new ChatMensajeRecibidoNotification($mensaje, $chat));
        }

        return back()->with('success', 'Mensaje enviado exitosamente');
    }

    /**
     * Admin: Crear chat con un usuario específico
     */
    public function crearChatConUsuario(Request $request)
    {
        // Solo admin puede hacer esto
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'usuario_id' => 'required|exists:users,id'
        ]);

        $admin = Auth::user();
        $usuarioId = $request->usuario_id;

        // Verificar si ya existe un chat entre admin y este usuario
        $chat = Chat::where(function ($query) use ($admin, $usuarioId) {
                $query->where('usuario1_id', $admin->id)
                    ->where('usuario2_id', $usuarioId);
            })
            ->orWhere(function ($query) use ($admin, $usuarioId) {
                $query->where('usuario1_id', $usuarioId)
                    ->where('usuario2_id', $admin->id);
            })
            ->first();

        // Si no existe, crearlo
        if (!$chat) {
            $chat = Chat::create([
                'usuario1_id' => $admin->id,
                'usuario2_id' => $usuarioId,
                'is_anonymous' => false,
                'ultimo_mensaje_at' => now(),
            ]);
        }

        return redirect()->route('chat.show', $chat->id);
    }

    /**
     * Eliminar un chat (solo admin)
     */
    public function eliminar($chatId)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $chat = Chat::findOrFail($chatId);
        $chat->delete();

        return redirect()->route('chat.index')->with('success', 'Chat eliminado exitosamente');
    }
}
