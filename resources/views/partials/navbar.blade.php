<header class="navbar-custom">
    <div class="d-flex align-items-center justify-content-between w-100">
        <!-- Botón Hamburguesa -->
        <button class="navbar-brand-icon" id="menuToggle" title="Menú">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Barra de Búsqueda -->
        <div class="search-container d-none d-sm-block">
            <input
                type="text"
                class="search-input"
                placeholder="Busque aquí"
                id="searchInput"
            >
        </div>

        <!-- Iconos de la derecha -->
        <div class="navbar-icons">
            <!-- Búsqueda móvil -->
            <button class="icon-btn d-sm-none" title="Buscar">
                <i class="fas fa-search"></i>
            </button>

            <!-- Icono Búsqueda (desktop) -->
            <button class="icon-btn d-none d-sm-block" title="Buscar">
                <i class="fas fa-search"></i>
            </button>

            @auth
                <!-- Perfil con Dropdown (solo usuarios logueados) -->
                <div class="profile-dropdown">
                    <button class="icon-btn" id="profileBtn" title="Perfil">
                        <i class="fas fa-user"></i>
                    </button>
                    <div class="profile-menu" id="profileMenu">
                        <a href="{{ route('perfil') }}"><i class="fas fa-edit"></i> Editar Perfil</a>
                        <a href="{{ route('pedidos') }}"><i class="fas fa-box"></i> Ver mis Pedidos</a>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.main') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600;">
                                <i class="fas fa-shield-alt"></i> Panel Admin
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 15px; cursor: pointer;">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Carrito -->
                <button class="icon-btn" title="Carrito">
                    <a class="carro" href="{{ route('carrito') }}">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </button>
            @else
                <!-- Botón Login para invitados -->
                <a href="{{ route('login') }}" class="icon-btn" title="Iniciar Sesión">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            @endauth
        </div>
    </div>

    <!-- Barra de búsqueda móvil -->
    <div class="search-container d-sm-none mt-2">
        <input
            type="text"
            class="search-input"
            placeholder="Busque aquí"
        >
    </div>
</header>
