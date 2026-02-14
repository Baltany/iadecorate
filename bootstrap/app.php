<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Manejo de excepciones de base de datos
        $exceptions->render(function (\Illuminate\Database\QueryException $e, $request) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de base de datos',
                    'error' => config('app.debug') ? $e->getMessage() : 'Ha ocurrido un error al procesar los datos'
                ], 500);
            }

            return response()->view('errors.500', [
                'exception' => $e
            ], 500);
        });
    })->create();
