<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMensaje extends Model
{
    protected $table = 'chat_mensajes';

    protected $fillable = [
        'chat_id',
        'usuario_id',
        'contenido',
        'leido',
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    /**
     * Chat al que pertenece el mensaje
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Usuario que envió el mensaje
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Marcar mensaje como leído
     */
    public function marcarComoLeido(): void
    {
        if (!$this->leido) {
            $this->update(['leido' => true]);
        }
    }
}
