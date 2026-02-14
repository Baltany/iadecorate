<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles básicos
        $adminRole = Rol::create([
            'nombre' => 'admin',
            'descripcion' => 'Administrador del sistema con acceso completo'
        ]);

        $userRole = Rol::create([
            'nombre' => 'usuario',
            'descripcion' => 'Usuario estándar de la plataforma'
        ]);

        $moderadorRole = Rol::create([
            'nombre' => 'moderador',
            'descripcion' => 'Moderador con permisos intermedios'
        ]);

        // Asignar rol admin al usuario admin existente
        $adminUser = User::where('email', 'admin@admin.com')->first();
        if ($adminUser) {
            $adminUser->roles()->attach($adminRole->id);
        }

        // Asignar rol usuario a otros usuarios
        $otrosUsuarios = User::where('email', '!=', 'admin@admin.com')->get();
        foreach ($otrosUsuarios as $usuario) {
            $usuario->roles()->attach($userRole->id);
        }
    }
}
