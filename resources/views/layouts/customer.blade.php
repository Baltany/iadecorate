<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IA Decorate')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos (Font Awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body>
    <!-- OVERLAY SIDEBAR -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR MENU -->
    @include('partials.sidebar')

    <!-- HEADER / NAVBAR -->
    @include('partials.navbar')

    <!-- CONTENIDO PRINCIPAL -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    @include('partials.footer')

    <!-- Bootstrap 5 JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts personalizados -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Sistema de notificaciones global para mensajes -->
    @auth
    <script>
        // Sistema de notificaciones global de mensajes
        let ultimoMensajeIdGlobal = 0;
        let notificationTimeoutGlobal;

        // Función para mostrar notificacion visual global
        function mostrarNotificacionGlobal(mensaje) {
            // Limpiar notificacion anterior si existe
            if (notificationTimeoutGlobal) {
                clearTimeout(notificationTimeoutGlobal);
            }

            const existingNotif = document.getElementById('mensajeNotificacionGlobal');
            if (existingNotif) {
                existingNotif.remove();
            }

            const notificacion = document.createElement('div');
            notificacion.id = 'mensajeNotificacionGlobal';
            notificacion.style.cssText = `
                position: fixed;
                top: 80px;
                right: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 16px 20px;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.3);
                z-index: 10000;
                max-width: 350px;
                animation: slideInRight 0.3s ease-out;
                cursor: pointer;
            `;

            const esAdmin = mensaje.es_admin;
            const badgeAdmin = esAdmin ? '<span style="background: #7c3aed; color: white; font-size: 9px; padding: 2px 6px; border-radius: 4px; font-weight: 600; margin-left: 6px;">ADMIN</span>' : '';

            notificacion.innerHTML = `
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: ${esAdmin ? '#7c3aed' : 'rgba(255,255,255,0.3)'}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 16px;">
                        ${mensaje.usuario_inicial}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; margin-bottom: 4px; display: flex; align-items: center;">
                            ${mensaje.usuario_nombre}${badgeAdmin}
                        </div>
                        <div style="font-size: 14px; opacity: 0.95;">${mensaje.mensaje.substring(0, 50)}${mensaje.mensaje.length > 50 ? '...' : ''}</div>
                    </div>
                </div>
            `;

            document.body.appendChild(notificacion);

            // Agregar animacion si no existe
            if (!document.getElementById('notificationStylesGlobal')) {
                const style = document.createElement('style');
                style.id = 'notificationStylesGlobal';
                style.innerHTML = `
                    @keyframes slideInRight {
                        from {
                            transform: translateX(400px);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                    @keyframes slideOutRight {
                        from {
                            transform: translateX(0);
                            opacity: 1;
                        }
                        to {
                            transform: translateX(400px);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            }

            // Remover despues de 5 segundos
            notificationTimeoutGlobal = setTimeout(() => {
                notificacion.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => notificacion.remove(), 300);
            }, 5000);

            // Click para ir a mensajeria
            notificacion.onclick = () => {
                window.location.href = '/mensajeria';
            };
        }

        // Función para mostrar notificacion del navegador
        function mostrarNotificacionNavegador(mensaje) {
            if (!("Notification" in window)) {
                return;
            }

            if (Notification.permission === "granted") {
                const esAdmin = mensaje.es_admin;
                const titulo = esAdmin ? `Nuevo mensaje de ${mensaje.usuario_nombre} (ADMIN)` : `Nuevo mensaje de ${mensaje.usuario_nombre}`;

                const notification = new Notification(titulo, {
                    body: mensaje.mensaje,
                    icon: "{{ asset('img/logo.png') }}",
                    badge: "{{ asset('img/logo.png') }}"
                });

                notification.onclick = function() {
                    window.focus();
                    window.location.href = '/mensajeria';
                    notification.close();
                };
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission();
            }
        }

        // Polling global para verificar nuevos mensajes
        function verificarNuevosMensajesGlobal() {
            fetch('/mensajeria/conteo-no-leidos', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.mensajes && data.mensajes.length > 0) {
                    // Mostrar notificacion para cada mensaje nuevo
                    data.mensajes.forEach(mensaje => {
                        if (mensaje.id > ultimoMensajeIdGlobal) {
                            mostrarNotificacionGlobal(mensaje);
                            mostrarNotificacionNavegador(mensaje);
                            ultimoMensajeIdGlobal = mensaje.id;
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error al verificar nuevos mensajes:', error);
            });
        }

        // Iniciar polling solo si NO estamos en la pagina de mensajeria
        if (!window.location.pathname.includes('/mensajeria')) {
            // Solicitar permiso para notificaciones
            if ("Notification" in window && Notification.permission === "default") {
                Notification.requestPermission();
            }

            // Iniciar polling cada 5 segundos
            setInterval(verificarNuevosMensajesGlobal, 5000);

            // Verificar inmediatamente al cargar
            setTimeout(verificarNuevosMensajesGlobal, 2000);
        }
    </script>
    @endauth

    @stack('scripts')
</body>
</html>
