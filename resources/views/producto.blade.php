@extends('layouts.customer')

@section('title', $producto->nombre . ' - IA Decorate')

@push('styles')
<style>
    .product-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      width: 100%;
      flex: 1;
      align-items: center;
      padding: 40px;
    }

    .product-image-section {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .product-image {
      width: 100%;
      max-width: 500px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .product-image img {
      width: 100%;
      height: auto;
      display: block;
    }

    .product-details {
      display: flex;
      flex-direction: column;
      gap: 30px;
      height: 100%;
      justify-content: center;
    }

    .product-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 20px;
    }

    .product-title {
      font-size: 42px;
      font-weight: 900;
      color: var(--text-dark);
      line-height: 1.2;
    }

    .product-price {
      font-size: 42px;
      font-weight: 900;
      color: var(--text-dark);
      white-space: nowrap;
    }

    .measurements-section {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .measurements-title {
      font-size: 20px;
      font-weight: 900;
      color: var(--text-dark);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .measurement-item {
      font-size: 16px;
      color: var(--text-dark);
      font-weight: 600;
    }

    .measurement-label {
      display: inline;
      font-weight: 900;
    }

    .measurement-value {
      display: inline;
      font-weight: 600;
    }

    .product-stock {
      font-size: 16px;
      color: var(--text-dark);
      font-weight: 600;
    }

    .stock-available {
      color: #28a745;
    }

    .stock-low {
      color: #ffc107;
    }

    .stock-out {
      color: #dc3545;
    }

    /* DESCRIPCIÓN Y DETALLES ADICIONALES */
    .product-description {
      display: flex;
      flex-direction: column;
      gap: 15px;
      padding-top: 20px;
      border-top: 2px solid rgba(0, 0, 0, 0.2);
    }

    .description-title {
      font-size: 18px;
      font-weight: 900;
      color: var(--text-dark);
      text-transform: uppercase;
    }

    .description-text {
      font-size: 14px;
      color: var(--text-dark);
      line-height: 1.6;
      text-align: justify;
    }

    /* BOTONES DE ACCIÓN */
    .product-actions {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .btn-add-cart {
      flex: 1;
      padding: 14px 20px;
      background-color: var(--white);
      color: var(--text-dark);
      border: none;
      border-radius: var(--input-radius);
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
      background-color: #f9f9f9;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-add-cart:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    .btn-wishlist {
      padding: 14px 20px;
      background-color: transparent;
      color: var(--text-dark);
      border: 2px solid var(--text-dark);
      border-radius: var(--input-radius);
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-wishlist:hover {
      background-color: rgba(0, 0, 0, 0.05);
    }

    .quantity-selector {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .quantity-label {
      font-size: 16px;
      font-weight: 700;
      color: var(--text-dark);
    }

    .quantity-input {
      width: 80px;
      padding: 8px;
      border: 2px solid var(--text-dark);
      border-radius: var(--input-radius);
      font-size: 16px;
      font-weight: 600;
      text-align: center;
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
      .product-container {
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 30px;
      }

      .product-header {
        flex-direction: column;
      }

      .product-title {
        font-size: 36px;
      }

      .product-price {
        font-size: 36px;
      }
    }

    @media (max-width: 768px) {
      .product-container {
        gap: 25px;
        padding: 20px;
      }

      .product-title {
        font-size: 28px;
      }

      .product-price {
        font-size: 28px;
      }

      .measurements-title {
        font-size: 18px;
      }

      .measurement-item {
        font-size: 14px;
      }

      .description-title {
        font-size: 16px;
      }

      .description-text {
        font-size: 13px;
      }
    }

    @media (max-width: 576px) {
      .product-container {
        gap: 20px;
        padding: 15px;
      }

      .product-title {
        font-size: 24px;
      }

      .product-price {
        font-size: 24px;
      }

      .measurements-title {
        font-size: 16px;
      }

      .measurement-item {
        font-size: 13px;
      }

      .description-title {
        font-size: 14px;
      }

      .description-text {
        font-size: 12px;
      }

      .product-actions {
        flex-direction: column;
      }

      .btn-add-cart,
      .btn-wishlist {
        font-size: 13px;
        padding: 12px 16px;
      }
    }
</style>
@endpush

@section('content')
<main class="main-content">
    <div class="product-container">
      <!-- COLUMNA IZQUIERDA: IMAGEN -->
      <div class="product-image-section">
        <div class="product-image">
          <img src="{{ asset($producto->imagen ?? 'img/image.png') }}" alt="{{ $producto->nombre }}">
        </div>
      </div>

      <!-- COLUMNA DERECHA: DETALLES -->
      <div class="product-details">
        <!-- NOMBRE Y PRECIO -->
        <div class="product-header">
          <h1 class="product-title">{{ $producto->nombre }}</h1>
          <span class="product-price">{{ number_format($producto->precio, 2) }}€</span>
        </div>

        <!-- STOCK -->
        <div class="product-stock">
          <span class="measurement-label">Stock:</span>
          @if($producto->stock > 10)
            <span class="stock-available">{{ $producto->stock }} unidades disponibles</span>
          @elseif($producto->stock > 0)
            <span class="stock-low">Solo {{ $producto->stock }} unidades disponibles</span>
          @else
            <span class="stock-out">Agotado</span>
          @endif
        </div>

        <!-- DESCRIPCIÓN -->
        @if($producto->descripcion)
        <div class="product-description">
          <h3 class="description-title">Descripción</h3>
          <p class="description-text">
            {{ $producto->descripcion }}
          </p>
        </div>
        @endif

        <!-- SELECTOR DE CANTIDAD -->
        @auth
        <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}" id="addToCartForm">
          @csrf
          <div class="quantity-selector">
            <label class="quantity-label" for="cantidad">Cantidad:</label>
            <input
              type="number"
              name="cantidad"
              id="cantidad"
              class="quantity-input"
              value="1"
              min="1"
              max="{{ $producto->stock }}"
              {{ $producto->stock == 0 ? 'disabled' : '' }}
            >
          </div>

          <!-- BOTONES DE ACCIÓN -->
          <div class="product-actions">
            <button
              type="submit"
              class="btn-add-cart"
              {{ $producto->stock == 0 ? 'disabled' : '' }}
            >
              <i class="fas fa-shopping-cart"></i>
              {{ $producto->stock == 0 ? 'Agotado' : 'Añadir al carrito' }}
            </button>
            <button type="button" class="btn-wishlist" title="Agregar a favoritos">
              <i class="fas fa-heart"></i>
            </button>
          </div>
        </form>
        @else
        <div class="product-actions">
          <a href="{{ route('login') }}" class="btn-add-cart" style="text-decoration: none; text-align: center; display: block;">
            <i class="fas fa-user"></i> Inicia sesión para comprar
          </a>
        </div>
        @endauth
      </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // ADD TO WISHLIST BUTTON
    const addToWishlistBtn = document.querySelector('.btn-wishlist');
    if (addToWishlistBtn) {
      addToWishlistBtn.addEventListener('click', function() {
        this.style.color = '#e63946';
        this.style.borderColor = '#e63946';
        // Aquí iría la lógica para agregar a favoritos
        alert('Funcionalidad de favoritos próximamente');
      });
    }
</script>
@endpush
