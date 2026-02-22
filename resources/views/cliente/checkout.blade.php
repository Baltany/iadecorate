@extends('layouts.customer')

@section('title', 'Checkout - IA Decorate')

@section('content')
<main class="main-content">
    <div class="container py-5">
        <h1 class="text-center mb-5" style="font-weight: 900;">Finalizar Compra</h1>

        <div class="row">
            <!-- Formulario de checkout -->
            <div class="col-lg-7">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Información de envío</h4>

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('pedido.crear') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="direccion_envio" class="form-label">Dirección de envío completa</label>
                                <textarea
                                    class="form-control @error('direccion_envio') is-invalid @enderror"
                                    id="direccion_envio"
                                    name="direccion_envio"
                                    rows="3"
                                    required
                                    placeholder="Calle, número, piso, ciudad, código postal">{{ old('direccion_envio') }}</textarea>
                                @error('direccion_envio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Método de pago</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" {{ old('metodo_pago', 'tarjeta') == 'tarjeta' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tarjeta">
                                        💳 Tarjeta de crédito/débito
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal" {{ old('metodo_pago') == 'paypal' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="paypal">
                                        🔵 PayPal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="transferencia">
                                        🏦 Transferencia bancaria
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metodo_pago" id="contrareembolso" value="contrareembolso" {{ old('metodo_pago') == 'contrareembolso' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="contrareembolso">
                                        💰 Contrareembolso
                                    </label>
                                </div>
                                @error('metodo_pago')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-dark w-100" style="border-radius: 25px; padding: 12px;">
                                Confirmar y pagar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Resumen del pedido -->
            <div class="col-lg-5">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Resumen del pedido</h4>

                        @foreach($carritoItems as $item)
                        <div class="d-flex mb-3">
                            <img src="{{ asset($item->producto->imagen ?? 'img/image.png') }}"
                                 alt="{{ $item->producto->nombre }}"
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-1">{{ $item->producto->nombre }}</h6>
                                <small class="text-muted">Cantidad: {{ $item->cantidad }}</small>
                            </div>
                            <div class="text-end">
                                <strong>{{ number_format($item->producto->precio * $item->cantidad, 2) }}€</strong>
                            </div>
                        </div>
                        @endforeach

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>{{ number_format($subtotal, 2) }}€</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Envío:</span>
                            <span>{{ number_format($envio, 2) }}€</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <h5>Total:</h5>
                            <h5><strong>{{ number_format($total, 2) }}€</strong></h5>
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <small>📦 Entrega estimada: 3-5 días laborables</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
