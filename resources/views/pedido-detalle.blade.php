@extends('layouts.customer')

@section('title', 'Detalle del Pedido - IA Decorate')

@section('content')
<main class="main-content">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="font-weight: 900;">Pedido #{{ $pedido->id }}</h1>
            <a href="{{ route('pedidos') }}" class="btn btn-outline-dark">← Volver a mis pedidos</a>
        </div>

        <div class="row">
            <!-- Información del pedido -->
            <div class="col-lg-8">
                <div class="card mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Información del pedido</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Estado:</strong>
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
                            <div class="col-md-6">
                                <p><strong>Método de pago:</strong> {{ ucfirst($pedido->metodo_pago) }}</p>
                                <p><strong>Total:</strong> <span class="text-success fs-5">{{ number_format($pedido->total, 2) }}€</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Dirección de envío</h5>
                        <p>{{ $pedido->direccion_envio }}</p>
                    </div>
                </div>

                <!-- Productos del pedido -->
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Productos</h5>

                        @foreach($pedido->detalles as $detalle)
                        <div class="row mb-3 pb-3 border-bottom">
                            <div class="col-md-2">
                                <img src="{{ asset($detalle->producto->imagen ?? 'img/image.png') }}"
                                     alt="{{ $detalle->producto->nombre }}"
                                     class="img-fluid rounded"
                                     style="max-height: 80px; object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <h6>{{ $detalle->producto->nombre }}</h6>
                                <p class="text-muted mb-0">Precio unitario: {{ number_format($detalle->precio_unitario, 2) }}€</p>
                            </div>
                            <div class="col-md-2 text-center">
                                <p class="mb-0">Cantidad:</p>
                                <strong>{{ $detalle->cantidad }}</strong>
                            </div>
                            <div class="col-md-2 text-end">
                                <p class="mb-0">Subtotal:</p>
                                <strong>{{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}€</strong>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Resumen lateral -->
            <div class="col-lg-4">
                <div class="card" style="border-radius: 15px; position: sticky; top: 20px;">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Resumen</h5>

                        @php
                            $subtotal = $pedido->detalles->sum(function($detalle) {
                                return $detalle->precio_unitario * $detalle->cantidad;
                            });
                            $envio = $pedido->total - $subtotal;
                        @endphp

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>{{ number_format($subtotal, 2) }}€</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span>Envío:</span>
                            <span>{{ number_format($envio, 2) }}€</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5>Total:</h5>
                            <h5><strong>{{ number_format($pedido->total, 2) }}€</strong></h5>
                        </div>

                        @if($pedido->estado == 'pendiente')
                            <div class="alert alert-warning mb-0">
                                <small>⏳ Tu pedido está siendo procesado</small>
                            </div>
                        @elseif($pedido->estado == 'procesando')
                            <div class="alert alert-info mb-0">
                                <small>📦 Tu pedido está siendo preparado</small>
                            </div>
                        @elseif($pedido->estado == 'enviado')
                            <div class="alert alert-primary mb-0">
                                <small>🚚 Tu pedido está en camino</small>
                            </div>
                        @elseif($pedido->estado == 'entregado')
                            <div class="alert alert-success mb-0">
                                <small>✅ Tu pedido ha sido entregado</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
