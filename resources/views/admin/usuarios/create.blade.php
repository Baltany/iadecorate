<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IA Decorate - Crear Usuario</title>

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
      max-width: 900px;
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

    .checkbox-roles {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-top: 10px;
    }

    .checkbox-item {
      display: flex;
      align-items: center;
      padding: 10px;
      background-color: #f8f9fa;
      border-radius: 5px;
    }

    .checkbox-item input {
      margin-right: 10px;
      width: 18px;
      height: 18px;
      cursor: pointer;
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
      <a href="{{ route('admin.productos.index') }}" title="Productos" style="color: var(--text-dark); text-decoration: none;">
        <i class="fas fa-box"></i>
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
      <h5 class="crud-title">Crear Nuevo Usuario</h5>

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
          </div>

          <div class="col-md-6 mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos') }}">
          </div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <div class="col-md-6 mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
          </div>

          <div class="col-md-6 mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
          </div>
        </div>

        <div class="mb-3">
          <label for="direccion" class="form-label">Dirección</label>
          <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}">
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="ciudad" class="form-label">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ old('ciudad') }}">
          </div>

          <div class="col-md-6 mb-3">
            <label for="codigo_postal" class="form-label">Código Postal</label>
            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Roles</label>
          <div class="checkbox-roles">
            @foreach($roles as $rol)
            <div class="checkbox-item">
              <input type="checkbox" id="rol_{{ $rol->id }}" name="roles[]" value="{{ $rol->id }}"
                {{ in_array($rol->id, old('roles', [])) ? 'checked' : '' }}>
              <label for="rol_{{ $rol->id }}" style="margin: 0; cursor: pointer;">{{ ucfirst($rol->nombre) }}</label>
            </div>
            @endforeach
          </div>
        </div>

        <div class="d-flex gap-3 mt-4">
          <button type="submit" class="btn-guardar">
            <i class="fas fa-save"></i> Crear Usuario
          </button>
          <a href="{{ route('admin.usuarios') }}" class="btn-cancelar">
            <i class="fas fa-times"></i> Cancelar
          </a>
        </div>
      </form>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
