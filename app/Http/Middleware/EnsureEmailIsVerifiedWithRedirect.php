<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerifiedWithRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está autenticado pero no ha verificado su email
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            // Permitir acceso a rutas de verificación y logout
            $allowedRoutes = ['verification.notice', 'verification.send', 'verification.verify', 'logout'];

            if (!$request->routeIs($allowedRoutes)) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
