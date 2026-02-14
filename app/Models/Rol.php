<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación N:M con usuarios
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
