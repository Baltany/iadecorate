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
     * Crear una nueva incidencia desde pregunta frecuente
     */
    public function crear(Request $request)
    {
        $validated = $request->validate([
            'pregunta_id' => 'required|exists:preguntas_frecuentes,id',
        ]);

        $pregunta = PreguntaFrecuente::findOrFail($validated['pregunta_id']);

        Incidencia::create([
            'usuario_id' => Auth::id(),
            'asunto' => $pregunta->pregunta,
            'descripcion' => $pregunta->pregunta,
            'respuesta' => $pregunta->respuesta,
            'prioridad' => 'baja',
            'estado' => 'resuelta',
        ]);

        return redirect()->route('incidencias')->with('success', 'Consulta registrada');
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
