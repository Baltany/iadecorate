<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = [
        'usuario_id',
        'destinatario_id',
        'mensaje',
    ];

    /**
     * Relación con usuario emisor
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con usuario destinatario
     */
    public function destinatario()
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }
}
