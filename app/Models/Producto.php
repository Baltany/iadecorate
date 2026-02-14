<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen',
        'categoria_id',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Relación con carrito
     */
    public function carritos()
    {
        return $this->hasMany(Carrito::class);
    }

    /**
     * Relación con detalles de pedidos
     */
    public function detallesPedidos()
    {
        return $this->hasMany(DetallePedido::class);
    }
}
