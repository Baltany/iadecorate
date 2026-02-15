<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaFrecuente extends Model
{
    use HasFactory;

    protected $table = 'preguntas_frecuentes';

    protected $fillable = [
        'pregunta',
        'respuesta',
        'activa',
        'orden',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];
}
