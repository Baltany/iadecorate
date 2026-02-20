<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle a registration request.
     */
    public function store(Request $request, CreateNewUser $creator)
    {
        // Crear el usuario sin hacer login
        $user = $creator->create($request->all());

        // NO hacer login automático
        // Auth::login($user) <- ESTO NO

        // Redirigir al login con mensaje
        return redirect()->route('login')->with('status', 'registered');
    }
}