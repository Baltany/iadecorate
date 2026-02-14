<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IA Decorate - Editar Producto</title>

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
      max-width: 800px;
      margin: 0 auto;
    }

    .crud-title {
      margin-bottom: 20px;
      font-weight: 700;
      color: var(--text-dark);
    }

    .form-label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 8px;
    }

    .form-control, .form-select {
      border: 1px solid #999;
      padding: 10px;
      border-radius: 5px;
    }

    .btn-guardar {
      background-color: var(--text-dark);
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 5px;
      cursor: pointer;
      transition: opacity 0.2s;
    }

    .btn-guardar:hover {
      opacity: 0.8;
    }

    .btn-cancelar {
      background-color: #6c757d;
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: opacity 0.2s;
    }

    .btn-cancelar:hover {
      opacity: 0.8;
      color: white;
    }

    .imagen-preview {
      max-width: 200px;
      border-radius: 5px;
      margin-top: 10px;
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
      <h5 class="crud-title">Editar Producto</h5>

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea class="form-control" id="descripcion" name="descripcion" rows="4">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="precio" class="form-label">Precio (€) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" required>
          </div>

          <div class="col-md-6 mb-3">
            <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen del Producto</label>
          @if($producto->imagen)
            <div>
              <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="imagen-preview">
              <p class="text-muted mt-2"><small>Imagen actual. Sube una nueva para reemplazarla.</small></p>
            </div>
          @endif
          <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
          <small class="text-muted">Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
        </div>

        <div class="d-flex gap-3 mt-4">
          <button type="submit" class="btn-guardar">
            <i class="fas fa-save"></i> Actualizar Producto
          </button>
          <a href="{{ route('admin.productos.index') }}" class="btn-cancelar">
            <i class="fas fa-times"></i> Cancelar
          </a>
        </div>
      </form>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
