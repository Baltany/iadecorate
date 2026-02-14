<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pedido;

class PedidoCreadoNotification extends Notification
{
    use Queueable;

    protected $pedido;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
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
            ->subject('Pedido creado exitosamente - #' . $this->pedido->id)
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Tu pedido ha sido creado exitosamente.')
            ->line('Número de pedido: #' . $this->pedido->id)
            ->line('Total: €' . number_format($this->pedido->total, 2))
            ->line('Estado: ' . ucfirst($this->pedido->estado))
            ->action('Ver pedido', route('pedido.detalle', $this->pedido->id))
            ->line('Gracias por tu compra en IaDecorate!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pedido_id' => $this->pedido->id,
            'total' => $this->pedido->total,
            'estado' => $this->pedido->estado,
            'mensaje' => 'Tu pedido #' . $this->pedido->id . ' ha sido creado exitosamente'
        ];
    }
}
