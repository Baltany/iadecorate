@extends('layouts.customer')

@section('title', 'Carrito - IA Decorate')

@section('content')
<main class="main-content">
    <div class="container py-5">
        <h1 class="text-center mb-5" style="font-weight: 900;">Mi Carrito</h1>

        <div class="row">
            <div class="col-lg-8">
                @if(isset($carritoItems) && count($carritoItems) > 0)
                    @foreach($carritoItems as $item)
                    <div class="card mb-3" style="border-radius: 15px;">
                        <div class="row g-0 p-3">
                            <div class="col-md-3">
                                <img src="{{ asset($item->producto->imagen ?? 'img/image.png') }}" class="img-fluid rounded" alt="{{ $item->producto->nombre }}">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->producto->nombre }}</h5>
                                    <p class="card-text">Precio: {{ number_format($item->producto->precio, 2) }}€</p>
                                    <p class="card-text">Cantidad: {{ $item->cantidad }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-center justify-content-center">
                                <form method="POST" action="{{ route('carrito.eliminar', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="alert alert-info text-center">
                        Tu carrito está vacío.
                        <a href="{{ route('catalogo') }}">¡Empieza a comprar!</a>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card" style="border-radius: 15px; background: var(--primary-color); padding: 20px;">
                    <h4>Resumen del pedido</h4>
                    <hr>
                    <p>Subtotal: {{ number_format($subtotal ?? 0, 2) }}€</p>
                    <p>Envío: {{ number_format($envio ?? 5.99, 2) }}€</p>
                    <hr>
                    <h5>Total: {{ number_format(($subtotal ?? 0) + ($envio ?? 5.99), 2) }}€</h5>

                    @if(isset($carritoItems) && count($carritoItems) > 0)
                    <a href="{{ route('checkout') }}" class="btn btn-dark w-100 mt-3" style="border-radius: 25px;">
                        Proceder al pago
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
