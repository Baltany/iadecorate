@extends('layouts.customer')

@section('title', 'Incidencias - IA Decorate')

@section('content')
<main class="main-content">
    <div class="container py-5">
        <h1 class="text-center mb-5" style="font-weight: 900;">Mis Incidencias</h1>

        <!-- Formulario para crear nueva incidencia -->
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <div class="card" style="border-radius: 20px; padding: 30px; background: var(--primary-color);">
                    <h4>Reportar Nueva Incidencia</h4>
                    <form method="POST" action="{{ route('incidencias.crear') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 700;">Asunto</label>
                            <input type="text" class="form-control" name="asunto" required style="border-radius: 25px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 700;">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="4" required style="border-radius: 20px;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 700;">Prioridad</label>
                            <select class="form-control" name="prioridad" style="border-radius: 25px;">
                                <option value="baja">Baja</option>
                                <option value="media" selected>Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100" style="border-radius: 25px;">Enviar Incidencia</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de incidencias -->
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h4 class="mb-3">Mis Incidencias Anteriores</h4>
                @if(isset($incidencias) && count($incidencias) > 0)
                    @foreach($incidencias as $incidencia)
                    <div class="card mb-3" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5>{{ $incidencia->asunto }}</h5>
                                    <p class="text-muted mb-2">{{ $incidencia->descripcion }}</p>
                                    <small class="text-muted">
                                        Creada: {{ $incidencia->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-3 text-end">
                                    <span class="badge
                                        @if($incidencia->prioridad == 'baja') bg-secondary
                                        @elseif($incidencia->prioridad == 'media') bg-warning
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($incidencia->prioridad) }}
                                    </span>
                                    <br>
                                    <span class="badge mt-2
                                        @if($incidencia->estado == 'abierta') bg-primary
                                        @elseif($incidencia->estado == 'en_proceso') bg-info
                                        @elseif($incidencia->estado == 'resuelta') bg-success
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $incidencia->estado)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-info text-center">
                        No tienes incidencias reportadas.
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
