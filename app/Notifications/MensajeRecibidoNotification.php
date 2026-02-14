<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Mensaje;

class MensajeRecibidoNotification extends Notification
{
    use Queueable;

    protected $mensaje;

    /**
     * Create a new notification instance.
     */
    public function __construct(Mensaje $mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo mensaje recibido: ' . $this->mensaje->asunto)
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Has recibido un nuevo mensaje.')
            ->line('De: ' . $this->mensaje->remitente->name)
            ->line('Asunto: ' . $this->mensaje->asunto)
            ->line(substr($this->mensaje->contenido, 0, 100) . '...')
            ->action('Ver mensaje', route('mensajeria'))
            ->line('Gracias por usar IaDecorate!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'mensaje_id' => $this->mensaje->id,
            'remitente_id' => $this->mensaje->usuario_id,
            'remitente_nombre' => $this->mensaje->remitente->name,
            'asunto' => $this->mensaje->asunto,
            'mensaje' => 'Has recibido un nuevo mensaje de ' . $this->mensaje->remitente->name
        ];
    }
}
