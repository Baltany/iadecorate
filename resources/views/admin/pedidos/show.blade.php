<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IA Decorate - Detalle Pedido #{{ $pedido->id }}</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary-color: #EED09D;
      --text-dark: #1a1a1a;
      --text-light: #666;
      --white: #ffffff;
    }

    body {
      margin: 0;
      background-color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-content {
      padding: 0 30px 40px;
    }

    .crud-header {
      width: 100%;
      background-color: var(--primary-color);
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .crud-header-left,
    .crud-header-right {
      display: flex;
      gap: 20px;
      font-size: 20px;
      color: var(--text-dark);
    }

    .crud-header i {
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    .crud-header i:hover {
      transform: scale(1.15);
    }

    .crud-container {
      background-color: var(--white);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      max-width: 1000px;
      margin: 0 auto;
    }

    .crud-title {
      margin-bottom: 20px;
      font-weight: 700;
      color: var(--text-dark);
    }

    .info-section {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #ddd;
    }

    .info-row:last-child {
      border-bottom: none;
    }

    .info-label {
      font-weight: 600;
      color: var(--text-dark);
    }

    .badge-estado {
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 14px;
      font-weight: 600;
    }

    .badge-pendiente { background-color: #ffc107; color: #000; }
    .badge-procesando { background-color: #17a2b8; color: #fff; }
    .badge-enviado { background-color: #007bff; color: #fff; }
    .badge-entregado { background-color: #28a745; color: #fff; }
    .badge-cancelado { background-color: #dc3545; color: #fff; }

    .producto-detalle {
      display: flex;
      align-items: center;
      padding: 15px;
      border-bottom: 1px solid #ddd;
    }

    .producto-detalle:last-child {
      border-bottom: none;
    }

    .producto-imagen {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 5px;
      margin-right: 20px;
    }

    .btn-volver {
      background-color: var(--text-dark);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: opacity 0.2s;
    }

    .btn-volver:hover {
      opacity: 0.8;
      color: white;
    }
  </style>
</head>

<body>

  <!-- SUB HEADER CRUD -->
  <div class="crud-header">
    <div class="crud-header-left">
      <a href="{{ route('admin.main') }}" title="Inicio" style="color: var(--text-dark); text-decoration: none;">
        <i class="fas fa-home"></i>
      </a>
      <a href="{{ route('admin.usuarios') }}" title="Usuarios" style="color: var(--text-dark); text-decoration: none;">
        <i class="fas fa-user"></i>
      </a>
      <a href="{{ route('admin.productos.index') }}" title="Productos" style="color: var(--text-dark); text-decoration: none;">
        <i class="fas fa-box"></i>
      </a>
    </div>

    <div class="crud-header-right">
      <a href="{{ route('catalogo') }}" target="_blank" title="Ver Tienda" style="color: var(--text-dark); text-decoration: none;">
        <i class="fas fa-store"></i>
      </a>
      <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; color: var(--text-dark); cursor: pointer; font-size: 20px;" title="Cerrar Sesión">
          <i class="fas fa-arrow-right-from-bracket"></i>
        </button>
      </form>
    </div>
  </div>

  <!-- CONTENIDO -->
  <main class="main-content">

    <div class="crud-container">
      <div class="crud-title d-flex justify-content-between align-items-center">
        <h5>Detalles del Pedido #{{ $pedido->id }}</h5>
        <a href="{{ route('admin.pedidos.index') }}" class="btn-volver">
          <i class="fas fa-arrow-left"></i> Volver
        </a>
      </div>

      <!-- Información del Cliente -->
      <div class="info-section">
        <h6 class="mb-3"><i class="fas fa-user me-2"></i> Información del Cliente</h6>
        <div class="info-row">
          <span class="info-label">Nombre:</span>
          <span>{{ $pedido->usuario->name }} {{ $pedido->usuario->apellidos }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Email:</span>
          <span>{{ $pedido->usuario->email }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Teléfono:</span>
          <span>{{ $pedido->usuario->telefono ?? 'No especificado' }}</span>
        </div>
      </div>

      <!-- Información del Pedido -->
      <div class="info-section">
        <h6 class="mb-3"><i class="fas fa-shopping-cart me-2"></i> Información del Pedido</h6>
        <div class="info-row">
          <span class="info-label">Fecha:</span>
          <span>{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Estado:</span>
          <span class="badge-estado badge-{{ $pedido->estado }}">
            {{ ucfirst($pedido->estado) }}
          </span>
        </div>
        <div class="info-row">
          <span class="info-label">Método de Pago:</span>
          <span>{{ ucfirst($pedido->metodo_pago) }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Dirección de Envío:</span>
          <span>{{ $pedido->direccion_envio }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Total:</span>
          <span><strong style="font-size: 18px;">{{ number_format($pedido->total, 2) }}€</strong></span>
        </div>
      </div>

      <!-- Productos -->
      <div class="info-section">
        <h6 class="mb-3"><i class="fas fa-box me-2"></i> Productos</h6>
        @foreach($pedido->detalles as $detalle)
        <div class="producto-detalle">
          @if($detalle->producto->imagen)
            <img src="{{ asset($detalle->producto->imagen) }}" alt="{{ $detalle->producto->nombre }}" class="producto-imagen">
          @else
            <div style="width: 80px; height: 80px; background-color: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin-right: 20px;">
              <i class="fas fa-image fa-2x" style="color: #ccc;"></i>
            </div>
          @endif
          <div style="flex: 1;">
            <h6 class="mb-1">{{ $detalle->producto->nombre }}</h6>
            <p class="mb-1 text-muted" style="font-size: 14px;">
              Cantidad: <strong>{{ $detalle->cantidad }}</strong> unidades
            </p>
            <p class="mb-0">
              Precio unitario: {{ number_format($detalle->precio_unitario, 2) }}€
              <span style="margin-left: 20px;">
                Subtotal: <strong>{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}€</strong>
              </span>
            </p>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Cambiar Estado -->
      <div class="info-section">
        <h6 class="mb-3"><i class="fas fa-edit me-2"></i> Cambiar Estado del Pedido</h6>
        <form action="{{ route('admin.pedidos.cambiarEstado', $pedido->id) }}" method="POST">
          @csrf
          @method('PATCH')
          <div class="d-flex gap-3 align-items-center">
            <select name="estado" class="form-select" style="max-width: 300px;">
              <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
              <option value="procesando" {{ $pedido->estado == 'procesando' ? 'selected' : '' }}>Procesando</option>
              <option value="enviado" {{ $pedido->estado == 'enviado' ? 'selected' : '' }}>Enviado</option>
              <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
              <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            <button type="submit" class="btn-volver" style="background-color: #28a745;">
              <i class="fas fa-save"></i> Actualizar Estado
            </button>
          </div>
        </form>
      </div>

    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
