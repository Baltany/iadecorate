<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\PreguntaFrecuente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidenciaController extends Controller
{
    /**
     * Mostrar incidencias del usuario
     */
    public function index()
    {
        $incidencias = Incidencia::where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $preguntasFrecuentes = PreguntaFrecuente::where('activa', true)
            ->orderBy('orden')
            ->get();

        return view('incidencias', compact('incidencias', 'preguntasFrecuentes'));
    }

    /**
     * Crear una nueva incidencia
     */
    public function crear(Request $request)
    {
        $validated = $request->validate([
            'asunto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'prioridad' => 'nullable|in:baja,media,alta',
        ]);

        Incidencia::create([
            'usuario_id' => Auth::id(),
            'asunto' => $validated['asunto'],
            'descripcion' => $validated['descripcion'],
            'prioridad' => $validated['prioridad'] ?? 'media',
            'estado' => 'abierta',
        ]);

        return redirect()->route('incidencias')->with('success', 'Incidencia creada exitosamente');
    }

    /**
     * Actualizar estado de una incidencia
     */
    public function actualizar(Request $request, $id)
    {
        $incidencia = Incidencia::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'estado' => 'required|in:abierta,en_proceso,resuelta,cerrada',
        ]);

        $incidencia->estado = $validated['estado'];
        $incidencia->save();

        return redirect()->route('incidencias')->with('success', 'Incidencia actualizada');
    }
}
