@extends('layouts.customer')

@section('title', 'Mensajería - IA Decorate')

@section('content')
<main class="main-content">
    <div class="container py-5">
        <h1 class="text-center mb-5" style="font-weight: 900;">Mensajería</h1>

        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card" style="border-radius: 20px; background: white; min-height: 500px;">
                    <div class="card-body">
                        <!-- Área de mensajes -->
                        <div class="messages-area mb-3" style="height: 400px; overflow-y: auto; padding: 20px; background: #f8f9fa; border-radius: 15px;">
                            @if(isset($mensajes) && count($mensajes) > 0)
                                @foreach($mensajes as $mensaje)
                                <div class="message mb-3 @if($mensaje->usuario_id == auth()->id()) text-end @endif">
                                    <div class="d-inline-block p-3" style="
                                        background: @if($mensaje->usuario_id == auth()->id()) var(--primary-color) @else white @endif;
                                        border-radius: 15px;
                                        max-width: 70%;
                                        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                                    ">
                                        <p class="mb-1">{{ $mensaje->mensaje }}</p>
                                        <small class="text-muted">{{ $mensaje->created_at->format('H:i') }}</small>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-center text-muted mt-5">No hay mensajes aún. ¡Inicia una conversación!</p>
                            @endif
                        </div>

                        <!-- Formulario de envío -->
                        <form method="POST" action="{{ route('mensajeria.enviar') }}" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="mensaje" class="form-control" placeholder="Escribe tu mensaje..." style="border-radius: 25px;" required>
                            <button type="submit" class="btn btn-dark" style="border-radius: 50%; width: 50px; height: 50px;">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
