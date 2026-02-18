<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Rol;

class UserObserver
{
    /**
     * Handle the User "created" event.
     * Asigna automáticamente el rol "usuario" a nuevos usuarios
     */
    public function created(User $user): void
    {
        // Buscar el rol de usuario (el seeder lo crea como 'usuario')
        $rolUser = Rol::where('nombre', 'usuario')->first();

        if ($rolUser) {
            // Asignar el rol si existe
            $user->roles()->attach($rolUser->id);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
