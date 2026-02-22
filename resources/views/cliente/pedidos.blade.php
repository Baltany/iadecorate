@extends('layouts.customer')

@section('title', 'Mis Pedidos - IA Decorate')

@section('content')
<main class="main-content">
    <div class="container py-5">
        <h1 class="text-center mb-5" style="font-weight: 900;">Mis Pedidos</h1>

        @if(isset($pedidos) && count($pedidos) > 0)
            @foreach($pedidos as $pedido)
            <div class="card mb-3" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Pedido #{{ $pedido->id }}</h5>
                            <p class="text-muted">Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            <p>Estado:
                                <span class="badge
                                    @if($pedido->estado == 'pendiente') bg-warning
                                    @elseif($pedido->estado == 'procesando') bg-info
                                    @elseif($pedido->estado == 'enviado') bg-primary
                                    @elseif($pedido->estado == 'entregado') bg-success
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <h4>{{ number_format($pedido->total, 2) }}€</h4>
                            <a href="{{ route('pedido.detalle', $pedido->id) }}" class="btn btn-outline-dark">Ver detalles</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="alert alert-info text-center">
                No tienes pedidos aún.
                <a href="{{ route('catalogo') }}">¡Haz tu primera compra!</a>
            </div>
        @endif
    </div>
</main>
@endsection
