@extends('layouts.customer')

@section('title', 'Catálogo - IA Decorate')

@push('styles')
<style>
    .catalog-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        flex: 1;
    }

    .banner-section {
        position: relative;
        width: 100%;
        height: 250px;
        background-image: url('{{ asset("img/imageDecorate.png") }}');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .banner-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.3);
        z-index: 1;
    }

    .banner-title {
        position: relative;
        z-index: 2;
        font-size: 48px;
        font-weight: 900;
        color: var(--text-dark);
    }

    .products-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        padding: 40px 30px;
        background-color: #f5f5f5;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .product-image {
        width: 100%;
        aspect-ratio: 1 / 1;
        border-radius: 12px;
        overflow: hidden;
        background-color: #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .product-image:hover img {
        transform: scale(1.05);
    }

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .product-price {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    /* RESPONSIVE */
    @media (max-width: 1400px) {
        .products-container {
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            padding: 35px 25px;
        }
    }

    @media (max-width: 1024px) {
        .banner-title {
            font-size: 40px;
        }
        .products-container {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 30px 20px;
        }
        .banner-section {
            height: 220px;
        }
    }

    @media (max-width: 768px) {
        .banner-title {
            font-size: 32px;
        }
        .banner-section {
            height: 200px;
        }
        .products-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 25px 15px;
        }
        .product-name, .product-price {
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .banner-title {
            font-size: 28px;
        }
        .banner-section {
            height: 180px;
        }
        .products-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 20px 10px;
        }
        .product-name, .product-price {
            font-size: 12px;
        }
    }
</style>
@endpush

@section('content')
<main class="main-content">
    <div class="catalog-container">
        <!-- BANNER -->
        <div class="banner-section">
            <!-- <h1 class="banner-title">Decorate</h1> -->
        </div>

        <!-- GRID DE PRODUCTOS -->
        <div class="products-container">
            @forelse($productos ?? [] as $producto)
                <div class="product-card">
                    <a href="{{ route('producto.detalle', $producto->id) }}" class="product-image">
                        <img src="{{ asset($producto->imagen ?? 'img/image.png') }}" alt="{{ $producto->nombre }}">
                    </a>
                    <div class="product-info">
                        <h3 class="product-name">{{ $producto->nombre }}</h3>
                        <p class="product-price">{{ number_format($producto->precio, 2) }}€</p>
                    </div>
                </div>
            @empty
                <!-- Mensaje cuando no hay productos -->
                <div style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px 20px; text-align: center;">
                    <div style="font-size: 80px; margin-bottom: 20px; opacity: 0.3;">🔍</div>
                    <h2 style="color: #1a1a1a; font-size: 24px; margin-bottom: 10px;">No se encontraron productos</h2>
                    <p style="color: #666; margin-bottom: 30px;">
                        @if(request('buscar') || request('categoria'))
                            No hay productos disponibles que coincidan con tu búsqueda.
                        @else
                            Actualmente no hay productos en stock.
                        @endif
                    </p>
                    <a href="{{ route('catalogo') }}" style="background: var(--primary-color); color: #1a1a1a; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                        Ver todos los productos
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</main>
@endsection
