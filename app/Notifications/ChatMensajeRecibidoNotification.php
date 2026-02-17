<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ChatMensaje;
use App\Models\Chat;

class ChatMensajeRecibidoNotification extends Notification
{
    use Queueable;

    protected $mensaje;
    protected $chat;

    /**
     * Create a new notification instance.
     */
    public function __construct(ChatMensaje $mensaje, Chat $chat)
    {
        $this->mensaje = $mensaje;
        $this->chat = $chat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $remitente = $this->chat->is_anonymous ? 'Usuario Anónimo' : $this->mensaje->usuario->name;
        $preview = mb_substr($this->mensaje->contenido, 0, 50) . (mb_strlen($this->mensaje->contenido) > 50 ? '...' : '');

        return (new MailMessage)
            ->subject('Nuevo mensaje de chat - IaDecorate')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Has recibido un nuevo mensaje de ' . $remitente)
            ->line('Mensaje: "' . $preview . '"')
            ->action('Ver conversación', route('chat.show', $this->chat->id))
            ->line('Gracias por usar IaDecorate!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $remitente = $this->chat->is_anonymous ? 'Usuario Anónimo' : $this->mensaje->usuario->name;
        $preview = mb_substr($this->mensaje->contenido, 0, 100) . (mb_strlen($this->mensaje->contenido) > 100 ? '...' : '');

        return [
            'chat_id' => $this->chat->id,
            'mensaje_id' => $this->mensaje->id,
            'remitente' => $remitente,
            'preview' => $preview,
            'mensaje' => 'Nuevo mensaje de ' . $remitente
        ];
    }
}
