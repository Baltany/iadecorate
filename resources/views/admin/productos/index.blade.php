<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IA Decorate - CRUD Productos</title>

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
      display: flex;
      justify-content: space-between;
      align-items: center;
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

    .producto-imagen {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 5px;
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

    .btn-agregar {
      background-color: var(--text-dark);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: opacity 0.2s;
    }

    .btn-agregar:hover {
      opacity: 0.8;
      color: white;
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
      <a href="{{ route('admin.pedidos.index') }}" title="Pedidos" style="color: var(--text-dark); text-decoration: none;">
        <i class="fas fa-shopping-cart"></i>
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
      <div class="crud-title">
        <h5>Gestión de Productos</h5>
        <a href="{{ route('admin.productos.create') }}" class="btn-agregar">
          <i class="fas fa-plus"></i> Agregar Producto
        </a>
      </div>

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
              <th>Imagen</th>
              <th>Nombre</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>Descripción</th>
              <th>ACCIONES</th>
            </tr>
          </thead>
          <tbody>
            @forelse($productos as $producto)
            <tr>
              <td>{{ $producto->id }}</td>
              <td>
                @if($producto->imagen)
                  <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="producto-imagen">
                @else
                  <i class="fas fa-image fa-3x" style="color: #ccc;"></i>
                @endif
              </td>
              <td><strong>{{ $producto->nombre }}</strong></td>
              <td>{{ number_format($producto->precio, 2) }}€</td>
              <td>
                <span style="
                  padding: 5px 10px;
                  border-radius: 5px;
                  background-color: {{ $producto->stock > 10 ? '#28a745' : ($producto->stock > 0 ? '#ffc107' : '#dc3545') }};
                  color: {{ $producto->stock > 10 ? '#fff' : ($producto->stock > 0 ? '#000' : '#fff') }};
                ">
                  {{ $producto->stock }} unid.
                </span>
              </td>
              <td style="max-width: 300px; text-align: left;">
                {{ Str::limit($producto->descripcion, 100) }}
              </td>
              <td>
                <div class="actions">
                  <a href="{{ route('admin.productos.edit', $producto->id) }}" title="Editar">
                    <i class="fas fa-pen text-warning"></i>
                  </a>
                  <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: none; border: none; cursor: pointer;" title="Eliminar">
                      <i class="fas fa-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7">No hay productos registrados</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <div class="mt-4 d-flex justify-content-center">
        {{ $productos->links() }}
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
