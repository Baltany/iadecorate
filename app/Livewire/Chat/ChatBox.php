<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\ChatMensaje;
use App\Notifications\ChatMensajeRecibidoNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{
    public $chatId;
    public $mensaje = '';
    public $mensajes = [];
    public $chat;
    public $otroUsuario;

    protected $rules = [
        'mensaje' => 'required|string|max:2000'
    ];

    protected $messages = [
        'mensaje.required' => 'El mensaje no puede estar vacío',
        'mensaje.max' => 'El mensaje no puede exceder 2000 caracteres'
    ];

    public function mount($chatId)
    {
        $this->chatId = $chatId;
        $this->cargarChat();
        $this->cargarMensajes();
    }

    public function cargarChat()
    {
        $this->chat = Chat::with(['usuario1', 'usuario2'])->findOrFail($this->chatId);

        // Verificar permisos
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$this->chat->perteneceAlUsuario($user->id)) {
            abort(403, 'No tienes permiso para ver este chat');
        }

        $this->otroUsuario = $this->chat->otroUsuario($user->id);
    }

    public function cargarMensajes()
    {
        $user = Auth::user();

        // Marcar mensajes como leídos
        ChatMensaje::where('chat_id', $this->chatId)
            ->where('usuario_id', '!=', $user->id)
            ->where('leido', false)
            ->update(['leido' => true]);

        // Cargar mensajes
        $this->mensajes = ChatMensaje::where('chat_id', $this->chatId)
            ->with('usuario')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
    }

    public function enviarMensaje()
    {
        $this->validate();

        $user = Auth::user();

        // Crear el mensaje
        $nuevoMensaje = ChatMensaje::create([
            'chat_id' => $this->chatId,
            'usuario_id' => $user->id,
            'contenido' => $this->mensaje,
            'leido' => false,
        ]);

        // Actualizar timestamp del chat
        $this->chat->update([
            'ultimo_mensaje_at' => now(),
        ]);

        // Enviar notificación al otro usuario
        if ($this->otroUsuario) {
            $this->otroUsuario->notify(new ChatMensajeRecibidoNotification($nuevoMensaje, $this->chat));
        }

        // Limpiar input y recargar mensajes
        $this->mensaje = '';
        $this->cargarMensajes();

        // Emitir evento para scroll
        $this->dispatch('mensajeEnviado');
    }

    public function actualizarMensajes()
    {
        $this->cargarMensajes();
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
