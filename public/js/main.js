// ===========================
// SIDEBAR MENU
// ===========================
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarLinks = document.querySelectorAll('.sidebar-menu a');

    // Abrir sidebar
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
        });
    }

    // Cerrar sidebar
    const closeSidebar = () => {
        if (sidebar) sidebar.classList.remove('active');
        if (sidebarOverlay) sidebarOverlay.classList.remove('active');
    };

    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    // Cerrar sidebar al hacer click en un link
    sidebarLinks.forEach(link => {
        link.addEventListener('click', closeSidebar);
    });

    // ===========================
    // PROFILE DROPDOWN
    // ===========================
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('active');
        });

        // Cerrar dropdown cuando se hace click fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.profile-dropdown')) {
                profileMenu.classList.remove('active');
            }
        });

        // Cerrar dropdown cuando se hace click en un enlace
        const profileLinks = profileMenu.querySelectorAll('a');
        profileLinks.forEach(link => {
            link.addEventListener('click', function() {
                profileMenu.classList.remove('active');
            });
        });
    }

    // ===========================
    // BÚSQUEDA
    // ===========================
    const searchInputs = document.querySelectorAll('.search-input');
    searchInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                console.log('Búsqueda:', this.value);
                // Aquí iría la lógica de búsqueda
                // Puedes hacer una petición AJAX o redirigir a una ruta de búsqueda
            }
        });
    });

    // ===========================
    // RESPONSIVE SIDEBAR
    // ===========================
    // Cerrar sidebar automáticamente en pantallas grandes
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
});
