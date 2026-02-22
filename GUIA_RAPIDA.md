# 🚀 GUÍA RÁPIDA DE REFERENCIA - iADecorate

## 📂 ESTRUCTURA DE CARPETAS CLAVE

```
php-iadecorate/
│
├── 🎨 VISTAS (resources/views/)
│   ├── publico/          → Páginas sin login (/, /info)
│   ├── cliente/          → Área de cliente logueado
│   └── admin/            → Panel de administración
│
├── 🎮 CONTROLADORES (app/Http/Controllers/)
│   ├── ProductoController.php       → Catálogo + Gestión productos
│   ├── CarritoController.php        → Carrito de compras
│   ├── PedidoController.php         → Pedidos + Checkout
│   ├── MensajeController.php        → Chat/Mensajería
│   ├── IncidenciaController.php     → Tickets de soporte
│   ├── UsuarioController.php        → Perfil de usuario
│   ├── AdminController.php          → Panel admin
│   └── Api/                         → Controladores API REST
│
├── 🗃️ MODELOS (app/Models/)
│   ├── User.php                     → Usuario (Laravel extendido)
│   ├── Producto.php                 → Productos del catálogo
│   ├── Carrito.php                  → Items del carrito
│   ├── Pedido.php                   → Pedidos realizados
│   ├── DetallePedido.php            → Items de cada pedido
│   ├── Mensaje.php                  → Sistema de chat
│   ├── Incidencia.php               → Tickets de soporte
│   ├── Rol.php                      → Roles (admin, cliente)
│   └── PreguntaFrecuente.php        → FAQs
│
└── 🛣️ RUTAS (routes/)
    ├── web.php           → Rutas web principales
    ├── api.php           → Rutas API REST
    └── settings.php      → Configuración de perfil (Livewire)
```

---

## 🗺️ MAPA DE RUTAS PRINCIPALES

### 🌐 PÚBLICAS (Sin login)
```
/              → Inicio (publico.index)
/info          → Información (publico.info)
/login         → Login (Laravel Fortify)
/register      → Registro (Laravel Fortify)
```

### 👤 CLIENTE (Requiere login + email verificado)
```
📦 PRODUCTOS
├── /catalogo                    → Ver todos los productos
└── /producto/{id}               → Ver detalle de producto

🛒 CARRITO Y COMPRAS
├── /carrito                     → Ver carrito
├── POST /carrito/agregar/{id}   → Agregar producto
├── DELETE /carrito/{id}         → Eliminar producto
├── POST /carrito/actualizar/{id}→ Actualizar cantidad
└── /checkout                    → Página de pago

📋 PEDIDOS
├── /pedidos                     → Historial de pedidos
├── /pedido/{id}                 → Detalle de pedido
└── POST /pedido/crear           → Crear nuevo pedido

👤 PERFIL
├── /perfil                      → Ver/editar perfil
└── PUT /perfil/actualizar       → Guardar cambios

💬 MENSAJERÍA
├── /mensajeria                  → Chat interno
├── POST /mensajeria/enviar      → Enviar mensaje
├── GET /mensajeria/obtener-nuevos    → AJAX nuevos mensajes
└── GET /mensajeria/conteo-no-leidos  → Contador mensajes

🎫 SOPORTE
├── /incidencias                 → Ver incidencias + FAQs
└── POST /incidencias/crear      → Crear ticket

🏠 ENTORNO 3D
└── /entorno                     → Visualizador 3D
```

### 👨‍💼 ADMIN (Requiere rol admin)
```
🏢 PANEL ADMIN (Prefijo: /admin)
├── /admin/main                  → Dashboard

👥 USUARIOS
├── /admin/usuarios              → Listar usuarios
├── /admin/usuarios/crear        → Crear usuario
├── GET /admin/usuarios/{id}/editar  → Editar usuario
├── POST /admin/usuarios         → Guardar usuario
├── PUT /admin/usuarios/{id}     → Actualizar usuario
└── DELETE /admin/usuarios/{id}  → Eliminar usuario

📦 PRODUCTOS ADMIN
├── /admin/productos             → Listar productos
├── /admin/productos/crear       → Crear producto
├── GET /admin/productos/{id}/editar → Editar producto
├── POST /admin/productos        → Guardar producto
├── PUT /admin/productos/{id}    → Actualizar producto
└── DELETE /admin/productos/{id} → Eliminar producto

📋 PEDIDOS ADMIN
├── /admin/pedidos               → Listar todos pedidos
├── /admin/pedidos/{id}          → Ver detalle
└── PATCH /admin/pedidos/{id}/estado → Cambiar estado
```

### 🔌 API REST (Prefijo: /api)
```
PÚBLICA
├── GET /api/productos           → Listar productos
└── GET /api/productos/{id}      → Ver producto

PROTEGIDA (Token Sanctum)
├── POST /api/productos          → Crear producto
├── PUT /api/productos/{id}      → Actualizar
├── DELETE /api/productos/{id}   → Eliminar
├── /api/carrito                 → CRUD carrito
└── /api/pedidos                 → CRUD pedidos
```

---

## 🔄 FLUJOS DE TRABAJO PRINCIPALES

### 1️⃣ FLUJO DE COMPRA (Cliente)
```
1. Cliente hace login → /login
2. Navega catálogo → /catalogo
3. Ve producto → /producto/{id}
4. Agrega al carrito → POST /carrito/agregar/{id}
5. Revisa carrito → /carrito
6. Va a checkout → /checkout
7. Crea pedido → POST /pedido/crear
   ├─ Se genera Pedido (estado: pendiente)
   ├─ Se crean DetallePedido
   ├─ Se reduce stock de productos
   └─ Se vacía el carrito
8. Ve confirmación → /pedido/{id}
```

### 2️⃣ FLUJO DE GESTIÓN (Admin)
```
1. Admin hace login → /login
2. Accede panel → /admin/main
3. Gestiona productos:
   ├─ Crear → /admin/productos/crear
   ├─ Editar → /admin/productos/{id}/editar
   └─ Eliminar → DELETE /admin/productos/{id}
4. Gestiona pedidos:
   ├─ Ver todos → /admin/pedidos
   ├─ Ver detalle → /admin/pedidos/{id}
   └─ Cambiar estado → PATCH /admin/pedidos/{id}/estado
       (pendiente → procesando → enviado → entregado)
5. Gestiona usuarios:
   ├─ Listar → /admin/usuarios
   ├─ Crear → /admin/usuarios/crear
   ├─ Editar → /admin/usuarios/{id}/editar
   └─ Asignar roles
```

### 3️⃣ FLUJO DE MENSAJERÍA
```
1. Usuario entra → /mensajeria
2. Ve lista de conversaciones
3. Selecciona destinatario
4. Envía mensaje → POST /mensajeria/enviar
5. AJAX actualiza mensajes → GET /mensajeria/obtener-nuevos
6. Contador actualiza → GET /mensajeria/conteo-no-leidos
7. Notificación al destinatario
```

### 4️⃣ FLUJO DE INCIDENCIAS
```
1. Usuario entra → /incidencias
2. Ve FAQs (preguntas frecuentes)
3. Si no resuelve, crea ticket → POST /incidencias/crear
4. Admin recibe notificación
5. Admin responde/resuelve
```

---

## 🎯 CHECKLIST DE FUNCIONALIDADES

### ✅ Autenticación y Usuarios
- [x] Registro de usuarios
- [x] Login/Logout
- [x] Verificación de email
- [x] Recuperación de contraseña
- [x] Sistema de roles (admin/cliente)
- [x] Perfil editable
- [x] Cambio de contraseña

### ✅ Catálogo y Productos
- [x] Listado de productos
- [x] Búsqueda de productos
- [x] Detalle de producto
- [x] Gestión de stock
- [x] Subida de imágenes
- [x] CRUD completo (admin)

### ✅ Carrito y Compras
- [x] Agregar al carrito
- [x] Actualizar cantidades
- [x] Eliminar del carrito
- [x] Cálculo de totales
- [x] Costo de envío
- [x] Página de checkout

### ✅ Pedidos
- [x] Creación de pedidos
- [x] Historial de pedidos
- [x] Detalle de pedidos
- [x] Estados de pedido
- [x] Reducción de stock automática
- [x] Notificaciones

### ✅ Comunicación
- [x] Sistema de mensajería
- [x] Chat en tiempo real
- [x] Notificaciones de mensajes
- [x] Contador de no leídos
- [x] Sistema de incidencias
- [x] FAQs

### ✅ Administración
- [x] Panel de administración
- [x] Gestión de usuarios
- [x] Gestión de productos
- [x] Gestión de pedidos
- [x] Cambio de estados

### ✅ API REST
- [x] Endpoints de productos
- [x] Endpoints de carrito
- [x] Endpoints de pedidos
- [x] Autenticación con Sanctum

---

## 🔐 SEGURIDAD Y MIDDLEWARE

### Middleware Aplicado
```php
// Sin protección
Route::get('/')                           // Público

// Solo autenticados
Route::middleware(['auth', 'verified'])   // Cliente

// Solo administradores
Route::middleware(['auth', 'verified', 'role:admin'])  // Admin
```

### Verificaciones
- ✅ `auth` → Usuario logueado
- ✅ `verified` → Email verificado
- ✅ `role:admin` → Tiene rol de administrador
- ✅ CSRF protection → En todos los formularios
- ✅ Validación de datos → En todos los controladores

---

## 📊 MODELOS Y RELACIONES

```
User (Usuario)
├── hasMany → Pedido
├── hasMany → Mensaje (enviados)
├── hasMany → Mensaje (recibidos)
├── hasMany → Incidencia
├── hasMany → Carrito
└── belongsToMany → Rol

Producto
├── hasMany → Carrito
└── hasMany → DetallePedido

Pedido
├── belongsTo → User
└── hasMany → DetallePedido

DetallePedido
├── belongsTo → Pedido
└── belongsTo → Producto

Carrito
├── belongsTo → User
└── belongsTo → Producto

Mensaje
├── belongsTo → User (remitente)
└── belongsTo → User (destinatario)

Incidencia
└── belongsTo → User

Rol
└── belongsToMany → User
```

---

## 🛠️ COMANDOS ÚTILES

### Desarrollo
```bash
# Levantar servidor
php artisan serve

# Ver rutas
php artisan route:list

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Crear symlink para storage
php artisan storage:link
```

### Base de datos
```bash
# Migrar base de datos
php artisan migrate

# Refrescar base de datos (cuidado: borra datos)
php artisan migrate:fresh

# Ejecutar seeders
php artisan db:seed
```

### Crear nuevos elementos
```bash
# Crear controlador
php artisan make:controller NombreController

# Crear modelo
php artisan make:model NombreModelo -m  # Con migración

# Crear migración
php artisan make:migration create_tabla_table

# Crear middleware
php artisan make:middleware NombreMiddleware
```

---

## 📱 COMPONENTES ADICIONALES

### Livewire Components
```
app/Livewire/
├── Actions/
└── Settings/
    ├── Appearance.php     → Configuración de apariencia
    ├── Password.php       → Cambiar contraseña
    ├── Profile.php        → Editar perfil
    └── TwoFactor.php      → 2FA
```

### Notificaciones
```
app/Notifications/
├── MensajeRecibidoNotification.php   → Al recibir mensaje
└── PedidoCreadoNotification.php      → Al crear pedido
```

### Observers
```
app/Observers/
└── UserObserver.php                   → Eventos del usuario
```

---

## 🎨 TECNOLOGÍAS USADAS

### Backend
- ✅ **Laravel 11.x** - Framework PHP
- ✅ **Laravel Fortify** - Autenticación
- ✅ **Livewire** - Componentes reactivos
- ✅ **Eloquent ORM** - Base de datos
- ✅ **Laravel Sanctum** - API authentication

### Frontend
- ✅ **Blade** - Motor de plantillas
- ✅ **Vite** - Build tool
- ✅ **JavaScript/AJAX** - Interactividad
- ✅ **CSS** - Estilos

### Base de Datos
- ✅ **MySQL/MariaDB** - Base de datos relacional

---

## 🐛 TROUBLESHOOTING COMÚN

### Problemas de permisos
```bash
# Dar permisos a storage y cache
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Imágenes no se muestran
```bash
# Crear enlace simbólico de storage
php artisan storage:link
```

### Error 404 en rutas
```bash
# Limpiar cache de rutas y config
php artisan route:clear
php artisan config:clear
```

### Cambios no se reflejan
```bash
# Limpiar todas las cachés
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 📞 RESUMEN DE CONTACTOS ENTRE PARTES

### Cliente → Admin
- 💬 Mensajería (/mensajeria)
- 🎫 Incidencias (/incidencias)

### Admin → Cliente
- 💬 Mensajería (respuesta)
- 📋 Gestión de pedidos (cambiar estado)
- 🎫 Resolución de incidencias

### Sistema → Usuario
- 📧 Notificaciones por email
- 🔔 Notificaciones en la app
- 📨 Confirmaciones de pedido

---

## 🎯 ARCHIVOS CLAVE A REVISAR

```
RUTAS:
├── routes/web.php              → Rutas principales
├── routes/api.php              → Rutas API
└── routes/settings.php         → Configuración

CONTROLADORES:
├── app/Http/Controllers/ProductoController.php
├── app/Http/Controllers/CarritoController.php
├── app/Http/Controllers/PedidoController.php
├── app/Http/Controllers/AdminController.php
└── app/Http/Controllers/MensajeController.php

MODELOS:
├── app/Models/User.php
├── app/Models/Producto.php
├── app/Models/Pedido.php
└── app/Models/Carrito.php

VISTAS:
├── resources/views/publico/
├── resources/views/cliente/
└── resources/views/admin/

CONFIGURACIÓN:
├── config/auth.php
├── config/fortify.php
└── .env
```

---

## ✅ ESTADO ACTUAL DEL PROYECTO

### Completado ✅
- [x] Sistema de autenticación completo
- [x] Catálogo de productos funcional
- [x] Carrito de compras operativo
- [x] Sistema de pedidos completo
- [x] Panel de administración funcional
- [x] Sistema de mensajería
- [x] Sistema de incidencias
- [x] API REST básica
- [x] Sistema de roles
- [x] Vistas organizadas
- [x] Documentación completa

### Por mejorar 🔧
- [ ] Tests automatizados
- [ ] Más validaciones frontend
- [ ] Mejoras en el UI/UX
- [ ] Más filtros en catálogo
- [ ] Estadísticas en panel admin
- [ ] Sistema de reviews de productos
- [ ] Integración de pagos real

---

**Creado:** 20 de Febrero de 2026  
**Para:** Proyecto iADecorate - Laravel 11.x
