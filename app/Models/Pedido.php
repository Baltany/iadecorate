<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'usuario_id',
        'total',
        'estado',
        'direccion_envio',
        'metodo_pago',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    /**
     * Relación con usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con detalles del pedido
     */
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
