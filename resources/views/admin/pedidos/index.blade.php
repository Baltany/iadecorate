<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IA Decorate - CRUD Pedidos</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    /* ===========================
       VARIABLES
       =========================== */
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

    /* ===========================
       LAYOUT
       =========================== */
    .main-content {
      padding: 0 30px 40px;
    }

    /* ===========================
       CRUD HEADER
       =========================== */
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

    /* ===========================
       CRUD CONTAINER
       =========================== */
    .crud-container {
      background-color: var(--white);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      max-width: 1400px;
      margin: 0 auto;
    }

    .crud-title {
      margin-bottom: 20px;
      font-weight: 700;
      color: var(--text-dark);
    }

    /* ===========================
       TABLE
       =========================== */
    .crud-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
    }

    .crud-table th,
    .crud-table td {
      border: 1px solid #999;
      padding: 18px;
      text-align: center;
      font-size: 14px;
      vertical-align: middle;
    }

    .crud-table th {
      font-weight: 700;
      background-color: var(--primary-color);
    }

    /* ===========================
       ACTIONS
       =========================== */
    .actions {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 18px;
    }

    .actions i {
      cursor: pointer;
      font-size: 18px;
      transition: transform 0.2s ease;
    }

    .actions i:hover {
      transform: scale(1.2);
    }

    .badge-estado {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: 600;
    }

    .badge-pendiente { background-color: #ffc107; color: #000; }
    .badge-procesando { background-color: #17a2b8; color: #fff; }
    .badge-enviado { background-color: #007bff; color: #fff; }
    .badge-entregado { background-color: #28a745; color: #fff; }
    .badge-cancelado { background-color: #dc3545; color: #fff; }

    .productos-list {
      text-align: left;
      font-size: 12px;
      max-width: 300px;
      margin: 0 auto;
    }

    .producto-item {
      margin-bottom: 5px;
      padding: 5px;
      background-color: #f8f9fa;
      border-radius: 3px;
    }

    /* ===========================
       RESPONSIVE
       =========================== */
    @media (max-width: 768px) {
      .crud-container {
        padding: 20px;
      }

      .actions {
        gap: 14px;
      }
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
      <h5 class="crud-title">Gestión de Pedidos</h5>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="table-responsive">
        <table class="table crud-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Usuario</th>
              <th>Fecha</th>
              <th>Total</th>
              <th>Estado</th>
              <th>Método Pago</th>
              <th>Productos</th>
              <th>ACCIONES</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pedidos as $pedido)
            <tr>
              <td>#{{ $pedido->id }}</td>
              <td>
                {{ $pedido->usuario->name }}<br>
                <small style="color: var(--text-light);">{{ $pedido->usuario->email }}</small>
              </td>
              <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
              <td><strong>{{ number_format($pedido->total, 2) }}€</strong></td>
              <td>
                <span class="badge-estado badge-{{ $pedido->estado }}">
                  {{ ucfirst($pedido->estado) }}
                </span>
              </td>
              <td>{{ ucfirst($pedido->metodo_pago) }}</td>
              <td>
                <div class="productos-list">
                  @foreach($pedido->detalles as $detalle)
                  <div class="producto-item">
                    <strong>{{ $detalle->producto->nombre }}</strong><br>
                    Cantidad: {{ $detalle->cantidad }} x {{ number_format($detalle->precio_unitario, 2) }}€
                    = {{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}€
                  </div>
                  @endforeach
                </div>
              </td>
              <td>
                <div class="actions">
                  <a href="{{ route('admin.pedidos.show', $pedido->id) }}" title="Ver detalles">
                    <i class="fas fa-eye text-info"></i>
                  </a>
                  <form action="{{ route('admin.pedidos.cambiarEstado', $pedido->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <select name="estado" onchange="this.form.submit()" style="border: 1px solid #999; padding: 5px; border-radius: 3px;">
                      <option value="">Cambiar estado</option>
                      <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                      <option value="procesando" {{ $pedido->estado == 'procesando' ? 'selected' : '' }}>Procesando</option>
                      <option value="enviado" {{ $pedido->estado == 'enviado' ? 'selected' : '' }}>Enviado</option>
                      <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                      <option value="cancelado" {{ $pedido->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8">No hay pedidos registrados</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <div class="mt-4 d-flex justify-content-center">
        {{ $pedidos->links() }}
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
