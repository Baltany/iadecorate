<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IA Decorate - Inicio admin</title>

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
    ADMIN
   =========================== */

    .parrafo-admin{
    align-items: center;
    text-align: center;
    margin-top: 350px;
    font-size: 2em;
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
            <a href="{{ route('admin.usuarios') }}" title="Usuarios" style="color: var(--text-dark); text-decoration: none;">
                <i class="fas fa-user"></i>
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


    <p class="parrafo-admin">¡Bienvenido Admin {{ auth()->user()->name }}!</p>


</main>

</body>
</html>
