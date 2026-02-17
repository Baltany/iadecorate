<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'usuario1_id',
        'usuario2_id',
        'is_anonymous',
        'ultimo_mensaje_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'ultimo_mensaje_at' => 'datetime',
    ];

    /**
     * Usuario 1 de la conversación
     */
    public function usuario1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario1_id');
    }

    /**
     * Usuario 2 de la conversación
     */
    public function usuario2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario2_id');
    }

    /**
     * Mensajes del chat
     */
    public function mensajes(): HasMany
    {
        return $this->hasMany(ChatMensaje::class, 'chat_id');
    }

    /**
     * Obtener el otro usuario del chat
     */
    public function otroUsuario($userId)
    {
        return $this->usuario1_id === $userId ? $this->usuario2 : $this->usuario1;
    }

    /**
     * Verificar si el usuario pertenece a este chat
     */
    public function perteneceAlUsuario($userId): bool
    {
        return $this->usuario1_id === $userId || $this->usuario2_id === $userId;
    }

    /**
     * Obtener el último mensaje del chat
     */
    public function ultimoMensaje()
    {
        return $this->hasOne(ChatMensaje::class, 'chat_id')->latest();
    }

    /**
     * Contar mensajes no leídos para un usuario
     */
    public function mensajesNoLeidosPara($userId): int
    {
        return $this->mensajes()
            ->where('usuario_id', '!=', $userId)
            ->where('leido', false)
            ->count();
    }
}
