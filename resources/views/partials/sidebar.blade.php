<aside class="sidebar" id="sidebar">
    <button class="sidebar-close" id="sidebarClose">
        <i class="fas fa-times"></i>
    </button>
    <ul class="sidebar-menu">
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li><a href="{{ route('catalogo') }}">Catálogo</a></li>
        <li><a href="{{ route('info') }}">INFO</a></li>

        @auth
            <!-- Opciones solo para usuarios logueados -->
            <li><a href="{{ route('entorno') }}">3D</a></li>
            <li><a href="{{ route('mensajeria') }}">Mensajería</a></li>
            <li><a href="{{ route('incidencias') }}">Incidencias</a></li>
            <li><a href="{{ route('pedidos') }}">Mis Pedidos</a></li>
            <li><a href="{{ route('perfil') }}">Mi Perfil</a></li>

            @if(auth()->user()->hasRole('admin'))
                <!-- Opción especial para administradores -->
                <li style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 15px;">
                    <a href="{{ route('admin.main') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; padding: 12px 15px; display: block; font-weight: 600;">
                        <i class="fas fa-shield-alt"></i> Panel Admin
                    </a>
                </li>
            @endif
        @else
            <!-- Si no está logueado, mostrar opción de login -->
            <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
            <li><a href="{{ route('register') }}">Registrarse</a></li>
        @endauth
    </ul>
</aside>
