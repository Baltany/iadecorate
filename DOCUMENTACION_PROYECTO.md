# 📚 DOCUMENTACIÓN COMPLETA DEL PROYECTO iADecorate

## 🎯 ÍNDICE
1. [Estructura General del Proyecto](#estructura-general)
2. [¿Qué es de Laravel y qué es personalizado?](#laravel-vs-personalizado)
3. [Rutas del Sistema](#rutas-del-sistema)
4. [Controladores](#controladores)
5. [Modelos](#modelos)
6. [Vistas Organizadas](#vistas-organizadas)
7. [Middleware y Seguridad](#middleware-y-seguridad)
8. [Diagrama de Flujo de Funcionalidades](#diagrama-de-flujo)

---

## 🏗️ ESTRUCTURA GENERAL

### Organización de Carpetas
```
php-iadecorate/
├── app/                        # Lógica de la aplicación (PERSONALIZADO)
│   ├── Http/
│   │   ├── Controllers/        # Controladores personalizados
│   │   └── Middleware/         # Middleware personalizado
│   ├── Models/                 # Modelos Eloquent personalizados
│   ├── Livewire/              # Componentes Livewire personalizados
│   └── Notifications/         # Notificaciones personalizadas
├── resources/views/           # Vistas REORGANIZADAS
│   ├── publico/              # ✅ Vistas públicas (sin autenticación)
│   ├── cliente/              # ✅ Vistas de clientes autenticados
│   ├── admin/                # ✅ Vistas de administrador
│   └── livewire/             # Vistas de componentes Livewire
├── routes/                    # Rutas personalizadas
└── database/                  # Migraciones y seeders personalizados
```

---

## 🔍 ¿QUÉ ES DE LARAVEL Y QUÉ ES PERSONALIZADO?

### ✅ CÓDIGO DE LARAVEL (Framework Original)
- **Estructura base**: `app/Http/Controllers/Controller.php`
- **Providers base**: `AppServiceProvider.php`, `FortifyServiceProvider.php`
- **Autenticación**: Laravel Fortify (login, registro, recuperación de contraseña)
- **Sistema de migraciones**: Estructura de `database/migrations/`
- **Blade**: Motor de plantillas
- **Eloquent ORM**: Sistema de base de datos

### 🎨 CÓDIGO PERSONALIZADO (Desarrollado por ti)

#### Controladores Personalizados (app/Http/Controllers/)
- ✅ `ProductoController.php` - Gestión de productos (catálogo y admin)
- ✅ `CarritoController.php` - Gestión del carrito de compras
- ✅ `PedidoController.php` - Gestión de pedidos
- ✅ `MensajeController.php` - Sistema de mensajería
- ✅ `IncidenciaController.php` - Sistema de incidencias/soporte
- ✅ `UsuarioController.php` - Gestión de perfil de usuario
- ✅ `AdminController.php` - Panel de administración
- ✅ `Api/` - Controladores API REST

#### Modelos Personalizados (app/Models/)
- ✅ `Producto.php` - Modelo de productos
- ✅ `Carrito.php` - Modelo del carrito
- ✅ `Pedido.php` - Modelo de pedidos
- ✅ `DetallePedido.php` - Detalles de pedidos
- ✅ `Mensaje.php` - Sistema de mensajería
- ✅ `Incidencia.php` - Sistema de incidencias
- ✅ `PreguntaFrecuente.php` - FAQs
- ✅ `Rol.php` - Sistema de roles
- ✅ `User.php` - Usuario extendido

#### Middleware Personalizado
- ✅ `CheckRole.php` - Verificación de roles de usuario

#### Vistas Personalizadas
- ✅ Todas las vistas en `resources/views/` (excepto las de `flux/` y algunas de `components/`)

---

## 🛣️ RUTAS DEL SISTEMA

### 📌 RUTAS PÚBLICAS (Sin autenticación)

| Ruta | Método | Vista | Descripción |
|------|--------|-------|-------------|
| `/` | GET | `publico.index` | Página de inicio |
| `/info` | GET | `publico.info` | Información del sitio |

### 🔐 RUTAS DE CLIENTE (Requieren autenticación)

#### Catálogo y Productos
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/catalogo` | GET | `ProductoController@index` | `cliente.catalogo` | Listado de productos con búsqueda |
| `/producto/{id}` | GET | `ProductoController@show` | `cliente.producto` | Detalle de un producto |

**Funcionalidades:**
- 🔍 Búsqueda de productos por nombre o descripción
- 📦 Muestra solo productos con stock disponible
- 🖼️ Visualización de imágenes de productos

---

#### Carrito de Compras
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/carrito` | GET | `CarritoController@index` | `cliente.carrito` | Ver carrito |
| `/carrito/agregar/{producto}` | POST | `CarritoController@agregar` | - | Agregar producto |
| `/carrito/{item}` | DELETE | `CarritoController@eliminar` | - | Eliminar producto |
| `/carrito/actualizar/{item}` | POST | `CarritoController@actualizar` | - | Actualizar cantidad |

**Funcionalidades:**
- 🛒 Gestión completa del carrito
- 💰 Cálculo automático de subtotales y costos de envío
- ➕➖ Actualización de cantidades
- 🗑️ Eliminación de productos

---

#### Checkout y Pedidos
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/checkout` | GET | `PedidoController@checkout` | `cliente.checkout` | Página de pago |
| `/pedido/crear` | POST | `PedidoController@crear` | - | Crear pedido |
| `/pedidos` | GET | `PedidoController@index` | `cliente.pedidos` | Historial de pedidos |
| `/pedido/{id}` | GET | `PedidoController@show` | `cliente.pedido-detalle` | Detalle de pedido |

**Flujo del proceso:**
1. Usuario agrega productos al carrito
2. Accede a `/checkout`
3. Confirma datos de envío
4. Crea el pedido con `/pedido/crear`
5. Se genera el pedido con estado "pendiente"
6. Se envían notificaciones

---

#### Perfil de Usuario
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/perfil` | GET | `UsuarioController@perfil` | `cliente.perfil` | Ver/editar perfil |
| `/perfil/actualizar` | PUT | `UsuarioController@actualizar` | - | Actualizar datos |

**Campos editables:**
- Nombre y apellidos
- Email
- Teléfono
- Dirección completa (calle, ciudad, código postal)
- Fecha de nacimiento

---

#### Sistema de Mensajería
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/mensajeria` | GET | `MensajeController@index` | `cliente.mensajeria` | Chat interno |
| `/mensajeria/enviar` | POST | `MensajeController@enviar` | - | Enviar mensaje |
| `/mensajeria/obtener-nuevos` | GET | `MensajeController@obtenerNuevos` | - | Obtener mensajes nuevos (AJAX) |
| `/mensajeria/conteo-no-leidos` | GET | `MensajeController@conteoNoLeidos` | - | Contador de no leídos |

**Funcionalidades:**
- 💬 Chat en tiempo real entre usuarios y administradores
- 🔔 Notificaciones de mensajes nuevos
- 📩 Sistema de mensajes leídos/no leídos

---

#### Sistema de Incidencias
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/incidencias` | GET | `IncidenciaController@index` | `cliente.incidencias` | Ver incidencias + FAQs |
| `/incidencias/crear` | POST | `IncidenciaController@crear` | - | Crear incidencia |

**Funcionalidades:**
- 🎫 Sistema de tickets de soporte
- ❓ Preguntas frecuentes (FAQs)
- 📝 Seguimiento de incidencias

---

#### Entorno 3D
| Ruta | Método | Vista | Descripción |
|------|--------|-------|-------------|
| `/entorno` | GET | `cliente.entorno` | Visualizador 3D de decoración |

**Funcionalidades:**
- 🏠 Visualización 3D de muebles y decoración
- 🎨 Personalización de espacios

---

### 👨‍💼 RUTAS DE ADMINISTRADOR (Requieren rol admin)

**Prefijo:** `/admin`  
**Middleware:** `auth`, `verified`, `role:admin`

#### Dashboard Admin
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/admin/main` | GET | `AdminController@main` | `admin.main` | Panel principal admin |

---

#### Gestión de Usuarios
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/admin/usuarios` | GET | `AdminController@usuarios` | `admin.usuarios.index` | Listado de usuarios |
| `/admin/usuarios/crear` | GET | `AdminController@crearUsuario` | `admin.usuarios.create` | Formulario crear usuario |
| `/admin/usuarios` | POST | `AdminController@guardarUsuario` | - | Guardar nuevo usuario |
| `/admin/usuarios/{id}/editar` | GET | `AdminController@editarUsuario` | `admin.usuarios.edit` | Formulario editar usuario |
| `/admin/usuarios/{id}` | PUT | `AdminController@actualizarUsuario` | - | Actualizar usuario |
| `/admin/usuarios/{id}` | DELETE | `AdminController@eliminarUsuario` | - | Eliminar usuario |

**Funcionalidades:**
- 👥 CRUD completo de usuarios
- 🎭 Asignación de roles
- 🔒 Gestión de contraseñas

---

#### Gestión de Pedidos (Admin)
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/admin/pedidos` | GET | `AdminController@pedidos` | `admin.pedidos.index` | Listado de todos los pedidos |
| `/admin/pedidos/{id}` | GET | `AdminController@mostrarPedido` | `admin.pedidos.show` | Detalle de pedido |
| `/admin/pedidos/{id}/estado` | PATCH | `AdminController@cambiarEstadoPedido` | - | Cambiar estado de pedido |

**Estados de pedido:**
- ⏳ `pendiente` - Recién creado
- 🔄 `procesando` - En preparación
- 📦 `enviado` - En camino
- ✅ `entregado` - Completado
- ❌ `cancelado` - Cancelado

---

#### Gestión de Productos (Admin)
| Ruta | Método | Controlador | Vista | Descripción |
|------|--------|-------------|-------|-------------|
| `/admin/productos` | GET | `ProductoController@adminIndex` | `admin.productos.index` | Listado de productos |
| `/admin/productos/crear` | GET | `ProductoController@create` | `admin.productos.create` | Formulario crear producto |
| `/admin/productos` | POST | `ProductoController@store` | - | Guardar nuevo producto |
| `/admin/productos/{id}/editar` | GET | `ProductoController@edit` | `admin.productos.edit` | Formulario editar producto |
| `/admin/productos/{id}` | PUT | `ProductoController@update` | - | Actualizar producto |
| `/admin/productos/{id}` | DELETE | `ProductoController@destroy` | - | Eliminar producto |

**Funcionalidades:**
- 📦 CRUD completo de productos
- 🖼️ Gestión de imágenes (subida, actualización, eliminación)
- 💰 Control de precios y stock
- 📝 Descripción y detalles del producto

---

### 🔌 RUTAS API REST

**Prefijo:** `/api`  
**Formato:** JSON

#### API Pública
| Ruta | Método | Controlador | Descripción |
|------|--------|-------------|-------------|
| `/api/productos` | GET | `Api\ProductoController@index` | Listar productos |
| `/api/productos/{id}` | GET | `Api\ProductoController@show` | Detalle de producto |

#### API Protegida (Requiere Token Sanctum)
| Ruta | Método | Controlador | Descripción |
|------|--------|-------------|-------------|
| `/api/productos` | POST | `Api\ProductoController@store` | Crear producto |
| `/api/productos/{id}` | PUT | `Api\ProductoController@update` | Actualizar producto |
| `/api/productos/{id}` | DELETE | `Api\ProductoController@destroy` | Eliminar producto |
| `/api/carrito` | GET/POST/PUT/DELETE | `Api\CarritoController` | Gestión de carrito |
| `/api/pedidos` | GET/POST/PUT/DELETE | `Api\PedidoController` | Gestión de pedidos |

---

## 🎮 CONTROLADORES

### ProductoController
**Ubicación:** `app/Http/Controllers/ProductoController.php`

**Métodos:**
- `index()` - Catálogo público (con búsqueda)
- `show($id)` - Detalle de producto
- `adminIndex()` - Listado admin con paginación
- `create()` - Formulario crear
- `store()` - Guardar producto (con subida de imagen)
- `edit($id)` - Formulario editar
- `update($id)` - Actualizar producto (con actualización de imagen)
- `destroy($id)` - Eliminar producto (elimina también la imagen)

**Validaciones:**
```php
'nombre' => 'required|string|max:255'
'descripcion' => 'nullable|string'
'precio' => 'required|numeric|min:0'
'stock' => 'required|integer|min:0'
'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
```

---

### CarritoController
**Ubicación:** `app/Http/Controllers/CarritoController.php`

**Métodos:**
- `index()` - Ver carrito con cálculo de totales
- `agregar($producto)` - Añadir producto al carrito
- `eliminar($item)` - Eliminar producto del carrito
- `actualizar($item)` - Actualizar cantidad

**Lógica:**
- Costo de envío: 5.99€
- Calcula subtotal automáticamente
- Verifica stock disponible antes de agregar

---

### PedidoController
**Ubicación:** `app/Http/Controllers/PedidoController.php`

**Métodos:**
- `index()` - Historial de pedidos del usuario
- `show($id)` - Detalle de un pedido específico
- `checkout()` - Página de checkout con resumen
- `crear()` - Crear pedido desde el carrito

**Flujo de creación de pedido:**
1. Validar que el carrito tenga productos
2. Crear registro de Pedido
3. Crear DetallePedido para cada producto
4. Restar stock de productos
5. Vaciar carrito
6. Enviar notificaciones

---

### MensajeController
**Ubicación:** `app/Http/Controllers/MensajeController.php`

**Métodos:**
- `index()` - Vista de mensajería con conversaciones
- `enviar()` - Enviar mensaje
- `obtenerNuevos()` - AJAX para obtener mensajes nuevos
- `conteoNoLeidos()` - Obtener cantidad de mensajes sin leer

**Características:**
- Sistema de chat bidireccional
- Marca mensajes como leídos automáticamente
- Notificaciones push

---

### IncidenciaController
**Ubicación:** `app/Http/Controllers/IncidenciaController.php`

**Métodos:**
- `index()` - Ver incidencias y FAQs
- `crear()` - Crear nueva incidencia

**Estados de incidencia:**
- Abierta
- En proceso
- Resuelta
- Cerrada

---

### AdminController
**Ubicación:** `app/Http/Controllers/AdminController.php`

**Métodos:**
- `main()` - Dashboard principal
- **Usuarios:**
  - `usuarios()` - Listado
  - `crearUsuario()` - Formulario
  - `guardarUsuario()` - Guardar
  - `editarUsuario()` - Formulario editar
  - `actualizarUsuario()` - Actualizar
  - `eliminarUsuario()` - Eliminar
- **Pedidos:**
  - `pedidos()` - Listado
  - `mostrarPedido()` - Detalle
  - `cambiarEstadoPedido()` - Actualizar estado

---

## 📊 MODELOS

### User
**Ubicación:** `app/Models/User.php`

**Campos:**
- `name`, `email`, `password`
- `apellidos`, `telefono`
- `direccion`, `ciudad`, `codigo_postal`
- `fecha_nacimiento`

**Relaciones:**
- `roles()` - belongsToMany(Rol)
- `mensajesEnviados()` - hasMany(Mensaje)
- `mensajesRecibidos()` - hasMany(Mensaje)
- `pedidos()` - hasMany(Pedido)
- `incidencias()` - hasMany(Incidencia)

**Métodos personalizados:**
- `hasRole($role)` - Verificar si tiene un rol
- `hasAnyRole($roles)` - Verificar si tiene alguno de los roles

---

### Producto
**Ubicación:** `app/Models/Producto.php`

**Campos:**
- `nombre` - Nombre del producto
- `descripcion` - Descripción detallada
- `precio` - Precio unitario (decimal)
- `stock` - Cantidad disponible
- `imagen` - Ruta de la imagen

**Relaciones:**
- `detallesPedido()` - hasMany(DetallePedido)
- `carritos()` - hasMany(Carrito)

---

### Carrito
**Ubicación:** `app/Models/Carrito.php`

**Campos:**
- `user_id` - Usuario propietario
- `producto_id` - Producto en el carrito
- `cantidad` - Cantidad de unidades

**Relaciones:**
- `usuario()` - belongsTo(User)
- `producto()` - belongsTo(Producto)

---

### Pedido
**Ubicación:** `app/Models/Pedido.php`

**Campos:**
- `user_id` - Usuario que realiza el pedido
- `total` - Total del pedido
- `estado` - Estado actual
- `direccion_envio` - Dirección completa de envío
- `ciudad`, `codigo_postal`

**Relaciones:**
- `usuario()` - belongsTo(User)
- `detalles()` - hasMany(DetallePedido)

---

### DetallePedido
**Ubicación:** `app/Models/DetallePedido.php`

**Campos:**
- `pedido_id` - ID del pedido
- `producto_id` - ID del producto
- `cantidad` - Cantidad comprada
- `precio_unitario` - Precio en el momento de la compra

**Relaciones:**
- `pedido()` - belongsTo(Pedido)
- `producto()` - belongsTo(Producto)

---

### Mensaje
**Ubicación:** `app/Models/Mensaje.php`

**Campos:**
- `remitente_id` - Usuario que envía
- `destinatario_id` - Usuario que recibe
- `contenido` - Texto del mensaje
- `leido` - Boolean (leído/no leído)

**Relaciones:**
- `remitente()` - belongsTo(User)
- `destinatario()` - belongsTo(User)

---

### Incidencia
**Ubicación:** `app/Models/Incidencia.php`

**Campos:**
- `user_id` - Usuario que crea la incidencia
- `asunto` - Título de la incidencia
- `descripcion` - Descripción detallada
- `estado` - Estado actual
- `prioridad` - Nivel de prioridad

**Relaciones:**
- `usuario()` - belongsTo(User)

---

### Rol
**Ubicación:** `app/Models/Rol.php`

**Campos:**
- `nombre` - Nombre del rol (admin, cliente)
- `descripcion` - Descripción del rol

**Relaciones:**
- `usuarios()` - belongsToMany(User)

---

### PreguntaFrecuente
**Ubicación:** `app/Models/PreguntaFrecuente.php`

**Campos:**
- `pregunta` - Texto de la pregunta
- `respuesta` - Texto de la respuesta

---

## 🗂️ VISTAS ORGANIZADAS

### 📁 Estructura Actual (REORGANIZADA)

```
resources/views/
├── publico/                    # ✅ Vistas públicas
│   ├── index.blade.php        # Página de inicio
│   └── info.blade.php         # Información del sitio
│
├── cliente/                   # ✅ Vistas de cliente autenticado
│   ├── catalogo.blade.php    # Catálogo de productos
│   ├── producto.blade.php    # Detalle de producto
│   ├── carrito.blade.php     # Carrito de compras
│   ├── checkout.blade.php    # Proceso de pago
│   ├── pedidos.blade.php     # Historial de pedidos
│   ├── pedido-detalle.blade.php  # Detalle de pedido
│   ├── perfil.blade.php      # Perfil de usuario
│   ├── mensajeria.blade.php  # Sistema de mensajes
│   ├── incidencias.blade.php # Sistema de incidencias
│   └── entorno.blade.php     # Vista 3D
│
├── admin/                     # ✅ Vistas de administrador
│   ├── main.blade.php        # Dashboard admin
│   ├── usuarios/
│   │   ├── index.blade.php   # Listado de usuarios
│   │   ├── create.blade.php  # Crear usuario
│   │   └── edit.blade.php    # Editar usuario
│   ├── pedidos/
│   │   ├── index.blade.php   # Listado de pedidos
│   │   └── show.blade.php    # Detalle de pedido
│   └── productos/
│       ├── index.blade.php   # Listado de productos
│       ├── create.blade.php  # Crear producto
│       └── edit.blade.php    # Editar producto
│
├── livewire/                  # Componentes Livewire
│   ├── auth/                 # Autenticación (Laravel)
│   ├── settings/             # Configuración de perfil
│   └── buscador/             # Buscador personalizado
│
├── components/               # Componentes Blade
│   ├── auth-header.blade.php
│   ├── desktop-user-menu.blade.php
│   └── settings/
│
├── layouts/                  # Layouts generales
│   ├── app.blade.php
│   └── guest.blade.php
│
├── partials/                 # Componentes parciales
│   ├── navbar.blade.php
│   └── footer.blade.php
│
├── dashboard.blade.php       # Dashboard genérico (Flux)
└── welcome.blade.php         # Página de bienvenida Laravel
```

---

## 🛡️ MIDDLEWARE Y SEGURIDAD

### Middleware Aplicado

#### 1. `auth` (Laravel)
- Verifica que el usuario esté autenticado
- Redirige a login si no lo está

#### 2. `verified` (Laravel Fortify)
- Verifica que el email esté verificado
- Redirige a página de verificación si no lo está

#### 3. `role:admin` (Personalizado)
**Ubicación:** `app/Http/Middleware/CheckRole.php`
- Verifica que el usuario tenga el rol de administrador
- Retorna error 403 si no tiene permisos

### Protección de Rutas

```php
// Rutas públicas (sin middleware)
Route::get('/', ...)
Route::get('/info', ...)

// Rutas de cliente (auth + verified)
Route::middleware(['auth', 'verified'])->group(...)

// Rutas de admin (auth + verified + role:admin)
Route::middleware(['auth', 'verified', 'role:admin'])->group(...)
```

---

## 📋 DIAGRAMA DE FLUJO DE FUNCIONALIDADES

### 🛒 FLUJO DE COMPRA

```
USUARIO NO AUTENTICADO
└─> Ve página inicio (/)
└─> Ve información (/info)
└─> Debe registrarse/login para comprar

USUARIO AUTENTICADO
└─> Accede al catálogo (/catalogo)
    └─> Busca productos
    └─> Ve detalle de producto (/producto/{id})
        └─> Agrega al carrito (POST /carrito/agregar)
└─> Ve su carrito (/carrito)
    └─> Actualiza cantidades
    └─> Elimina productos
    └─> Va a checkout (/checkout)
        └─> Confirma datos
        └─> Crea pedido (POST /pedido/crear)
            └─> Se genera el pedido
            └─> Se reduce el stock
            └─> Se vacía el carrito
            └─> Notificación enviada
└─> Ve historial de pedidos (/pedidos)
    └─> Ve detalle de cada pedido (/pedido/{id})
```

### 👨‍💼 FLUJO ADMINISTRADOR

```
ADMIN AUTENTICADO
└─> Accede al panel (/admin/main)
    ├─> Gestión de Usuarios (/admin/usuarios)
    │   └─> Crear, editar, eliminar usuarios
    │   └─> Asignar roles
    │
    ├─> Gestión de Productos (/admin/productos)
    │   └─> Crear productos con imágenes
    │   └─> Editar productos
    │   └─> Actualizar stock y precios
    │   └─> Eliminar productos
    │
    └─> Gestión de Pedidos (/admin/pedidos)
        └─> Ver todos los pedidos
        └─> Ver detalle de cada pedido
        └─> Cambiar estado (pendiente → procesando → enviado → entregado)
```

### 💬 FLUJO DE MENSAJERÍA

```
USUARIO AUTENTICADO
└─> Accede a mensajería (/mensajeria)
    └─> Ve lista de usuarios para chatear
    └─> Selecciona un destinatario
    └─> Envía mensaje (POST /mensajeria/enviar)
    └─> Recibe notificación de mensajes nuevos
    └─> AJAX actualiza mensajes cada X segundos
        └─> Marca mensajes como leídos automáticamente
```

### 🎫 FLUJO DE INCIDENCIAS

```
USUARIO AUTENTICADO
└─> Accede a incidencias (/incidencias)
    └─> Ve preguntas frecuentes (FAQs)
    └─> Si no encuentra solución:
        └─> Crea incidencia (POST /incidencias/crear)
            └─> Asunto + descripción
            └─> Se crea con estado "abierta"
            └─> Admin recibe notificación
```

---

## 🔧 CONFIGURACIÓN Y SERVICIOS

### Autenticación (Laravel Fortify)
- **Login**: `/login`
- **Registro**: `/register`
- **Recuperar contraseña**: `/forgot-password`
- **Verificación de email**: `/email/verify`

### Settings (Livewire)
**Rutas definidas en:** `routes/settings.php`
- `/settings/profile` - Editar perfil
- `/settings/password` - Cambiar contraseña
- `/settings/appearance` - Apariencia
- `/settings/two-factor` - Autenticación de dos factores

### Notificaciones
- `MensajeRecibidoNotification` - Al recibir un mensaje
- `PedidoCreadoNotification` - Al crear un pedido

### Observers
- `UserObserver` - Observa eventos del modelo User

---

## 📦 MIGRACIONES Y BASE DE DATOS

### Tablas Creadas (Personalizadas)

1. **productos**
   - id, nombre, descripcion, precio, stock, imagen, timestamps

2. **carritos**
   - id, user_id, producto_id, cantidad, timestamps

3. **pedidos**
   - id, user_id, total, estado, direccion_envio, ciudad, codigo_postal, timestamps

4. **detalle_pedidos**
   - id, pedido_id, producto_id, cantidad, precio_unitario, timestamps

5. **mensajes**
   - id, remitente_id, destinatario_id, contenido, leido, timestamps

6. **incidencias**
   - id, user_id, asunto, descripcion, estado, prioridad, timestamps

7. **roles**
   - id, nombre, descripcion, timestamps

8. **role_user** (tabla pivot)
   - user_id, role_id

9. **preguntas_frecuentes**
   - id, pregunta, respuesta, timestamps

---

## 🚀 CÓMO USAR ESTE PROYECTO

### 1. Usuario Cliente
```
1. Registrarse o hacer login
2. Verificar email
3. Navegar por el catálogo
4. Agregar productos al carrito
5. Realizar checkout y crear pedido
6. Ver historial de pedidos
7. Contactar con soporte vía mensajería o incidencias
```

### 2. Usuario Administrador
```
1. Login con credenciales de admin
2. Acceder a /admin/main
3. Gestionar productos (crear, editar, eliminar)
4. Gestionar usuarios y roles
5. Procesar pedidos (cambiar estados)
6. Responder mensajes e incidencias
```

---

## 📝 RESUMEN RÁPIDO

### ¿Qué hace cada parte?

| Componente | Descripción |
|------------|-------------|
| **Catálogo** | Muestra productos disponibles con búsqueda |
| **Carrito** | Gestiona productos antes de comprar |
| **Checkout** | Página para confirmar y crear pedido |
| **Pedidos** | Historial de compras del usuario |
| **Mensajería** | Chat entre usuarios y admins |
| **Incidencias** | Sistema de tickets de soporte |
| **Perfil** | Datos personales del usuario |
| **Admin** | Panel completo de gestión |
| **API** | Endpoints REST para integraciones |

---

## ✅ CAMBIOS REALIZADOS HOY

1. ✅ Reorganización de vistas en carpetas:
   - `publico/` para vistas públicas
   - `cliente/` para vistas de usuario autenticado
   - `admin/` ya estaba organizado

2. ✅ Actualización de rutas en `routes/web.php`

3. ✅ Actualización de todos los controladores para usar las nuevas rutas

4. ✅ Creación de esta documentación completa

---

## 🎯 PRÓXIMOS PASOS RECOMENDADOS

1. **Testing**: Prueba todas las rutas para verificar que funcionen correctamente
2. **Validación**: Revisa que todas las vistas se carguen sin errores
3. **Documentación adicional**: Añade comentarios en el código donde sea necesario
4. **Backup**: Haz un backup de la base de datos antes de continuar desarrollando
5. **Git**: Commitea estos cambios con un mensaje descriptivo

---

**Última actualización:** 20 de Febrero de 2026  
**Versión del proyecto:** Laravel 11.x con Livewire y Fortify
