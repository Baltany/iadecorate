# 📚 DOCUMENTACIÓN COMPLETA DEL PROYECTO - IADECORATE

## 🎯 ÍNDICE
1. [Introducción](#introducción)
2. [Requisitos del Profesor - Cumplimiento](#requisitos-cumplimiento)
3. [Estructura del Proyecto](#estructura)
4. [Base de Datos y Modelos](#base-de-datos)
5. [Controladores y Métodos](#controladores)
6. [Vistas Explicadas](#vistas)
7. [Rutas y Middleware](#rutas)
8. [Validaciones y Form Requests](#validaciones)
9. [API REST](#api)
10. [Autenticación y Roles](#autenticacion)
11. [Notificaciones](#notificaciones)
12. [Factories y Seeders](#factories)
13. [Instalación y Configuración](#instalacion)

---

## 📖 INTRODUCCIÓN

**IADECORATE** es una aplicación web completa de **decoración de interiores** desarrollada con **Laravel 11**. Es una tienda online donde los usuarios pueden:
- 🛍️ Comprar productos de decoración
- 🛒 Gestionar su carrito de compras
- 📦 Realizar y hacer seguimiento de pedidos
- 💬 Comunicarse con otros usuarios (mensajería)
- ❓ Consultar preguntas frecuentes (incidencias)
- 👤 Gestionar su perfil
- 🎨 Visualizar productos en un entorno 3D

Los **administradores** pueden gestionar usuarios, productos y pedidos.

---

## ✅ REQUISITOS DEL PROFESOR - CUMPLIMIENTO

### **1. Relaciones 1:N y N:M en la Base de Datos** ✅

#### **Relación 1:N (Uno a Muchos):**
- **User → Pedido**: Un usuario puede tener muchos pedidos
  ```php
  // En User.php
  public function pedidos() {
      return $this->hasMany(Pedido::class, 'usuario_id');
  }
  ```

- **User → Carrito**: Un usuario puede tener muchos items en su carrito
  ```php
  public function carrito() {
      return $this->hasMany(Carrito::class, 'usuario_id');
  }
  ```

- **Pedido → DetallePedido**: Un pedido tiene muchos detalles (productos)
  ```php
  // En Pedido.php
  public function detalles() {
      return $this->hasMany(DetallePedido::class, 'pedido_id');
  }
  ```

#### **Relación N:M (Muchos a Muchos):**
- **User ↔ Rol**: Muchos usuarios pueden tener muchos roles
  - Tabla pivot: `role_user`
  ```php
  // En User.php
  public function roles() {
      return $this->belongsToMany(Rol::class, 'role_user', 'user_id', 'rol_id');
  }
  
  // En Rol.php
  public function users() {
      return $this->belongsToMany(User::class, 'role_user', 'rol_id', 'user_id');
  }
  ```

**✅ USO DE ELOQUENT:** Se usa en TODO el proyecto. Ejemplo:
```php
// Obtener pedidos con sus detalles y productos
$pedido = Pedido::with('detalles.producto')->find($id);
```

---

### **2. Middleware Personalizado** ✅

**Archivo:** `app/Http/Middleware/CheckRole.php`

**¿Qué hace?**
Verifica que el usuario autenticado tenga un rol específico antes de permitir el acceso.

```php
public function handle(Request $request, Closure $next, string $role): Response
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (!Auth::user()->hasRole($role)) {
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    return $next($request);
}
```

**¿Dónde se usa?**
- Protege las rutas de administrador
- En `routes/web.php`:
  ```php
  Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
      // Rutas de administración
  });
  ```

---

### **3. Factory para Carga Automática de Datos** ✅

**Archivos:**
- `database/factories/UserFactory.php`
- `database/factories/ProductoFactory.php`

**¿Qué hacen?**
Generan datos falsos automáticamente para testing.

**ProductoFactory.php:**
```php
public function definition(): array
{
    return [
        'nombre' => fake()->words(3, true),
        'descripcion' => fake()->paragraph(),
        'precio' => fake()->randomFloat(2, 10, 500),
        'stock' => fake()->numberBetween(0, 100),
        'imagen' => 'productos/default.jpg',
        'categoria' => fake()->randomElement(['Muebles', 'Decoración', 'Iluminación']),
    ];
}
```

**¿Cómo se usa?**
En seeders o tinker:
```bash
php artisan tinker
>>> Producto::factory()->count(10)->create()
```

---

### **4. Control de Acceso + Información Extra de Usuarios** ✅

**Autenticación:** Laravel Fortify
**Información extra guardada:**
- `telefono`
- `direccion`
- `ciudad`
- `codigo_postal`
- `pais`

**Migración:** `2026_02_14_174555_add_extra_fields_to_users_table.php`

```php
$table->string('telefono', 20)->nullable();
$table->string('direccion')->nullable();
$table->string('ciudad', 100)->nullable();
$table->string('codigo_postal', 10)->nullable();
$table->string('pais', 100)->nullable()->default('España');
```

**¿Dónde se usa?**
- Formulario de perfil (`/perfil`)
- Checkout de pedidos

---

### **5. Componentes en Vistas** ✅

**IMPORTANTE:** Este proyecto **NO usa Livewire**. Los componentes son **Blade Components**.

**Componente creado:** `resources/views/components/product-card.blade.php`

```blade
<!-- Ejemplo de componente de tarjeta de producto -->
<div class="product-card">
    <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}">
    <h3>{{ $producto->nombre }}</h3>
    <p>{{ $producto->precio }}€</p>
    <a href="{{ route('producto.detalle', $producto->id) }}">Ver más</a>
</div>
```

**¿Cómo se usa?**
```blade
<!-- En catalogo.blade.php -->
@foreach($productos as $producto)
    <x-product-card :producto="$producto" />
@endforeach
```

---

### **6. Vistas Personalizadas de Laravel** ✅

**Vistas publicadas:**
```bash
php artisan vendor:publish --tag=fortify-views
```

**Personalizadas:**
- `resources/views/auth/login.blade.php` - Login customizado
- `resources/views/auth/register.blade.php` - Registro customizado
- `resources/views/auth/forgot-password.blade.php` - Recuperar contraseña
- `resources/views/layouts/app.blade.php` - Layout principal personalizado

**Estilo:** Tailwind CSS + CSS personalizado

---

### **7. Validación de Formularios + Form Requests** ✅

**Form Requests creados:**
1. `ProductoRequest.php` - Validación de productos
2. `CarritoRequest.php` - Validación de carrito
3. `PedidoRequest.php` - Validación de pedidos
4. `IncidenciaRequest.php` - Validación de incidencias
5. `MensajeRequest.php` - Validación de mensajes
6. `LoginRequest.php` - Login
7. `RegisterRequest.php` - Registro

**Ejemplo - ProductoRequest.php:**
```php
public function rules(): array
{
    return [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'precio' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'categoria' => 'required|string|max:100',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];
}

public function messages(): array
{
    return [
        'nombre.required' => 'El nombre del producto es obligatorio',
        'precio.numeric' => 'El precio debe ser un número válido',
        // ...
    ];
}
```

**¿Dónde se usa?**
```php
// En ProductoController.php
public function store(ProductoRequest $request)
{
    // Los datos ya están validados automáticamente
    $validated = $request->validated();
    Producto::create($validated);
}
```

**Errores HTTP personalizados:**
- `403.blade.php` - Acceso prohibido
- `404.blade.php` - No encontrado
- `500.blade.php` - Error del servidor

**Control de errores SQL:**
```php
try {
    Pedido::create($data);
} catch (\Exception $e) {
    return back()->withErrors(['error' => 'Error al crear el pedido']);
}
```

---

### **8. Subida de Archivos + CRUD** ✅

**CRUD de Productos (admin):**
- **Create:** Subir imagen de producto
- **Read:** Ver productos
- **Update:** Actualizar producto y su imagen
- **Delete:** Eliminar producto

**Controlador:** `ProductoController.php`

**Método de subida:**
```php
public function store(ProductoRequest $request)
{
    $data = $request->validated();
    
    // Subir imagen
    if ($request->hasFile('imagen')) {
        $path = $request->file('imagen')->store('productos', 'public');
        $data['imagen'] = $path;
    }
    
    Producto::create($data);
    return redirect()->route('admin.productos.index')
        ->with('success', 'Producto creado');
}
```

**Almacenamiento:** `storage/app/public/productos/`

**Simbolic link:**
```bash
php artisan storage:link
```

---

### **9. Web Service (API REST)** ✅

**Archivo:** `routes/api.php`

**Endpoints disponibles:**

#### **Productos:**
- `GET /api/productos` - Lista todos los productos
- `POST /api/productos` - Crear producto
- `GET /api/productos/{id}` - Ver un producto
- `PUT /api/productos/{id}` - Actualizar producto
- `DELETE /api/productos/{id}` - Eliminar producto

#### **Carrito:**
- `GET /api/carrito` - Ver carrito del usuario
- `POST /api/carrito` - Agregar al carrito
- `PUT /api/carrito/{id}` - Actualizar cantidad
- `DELETE /api/carrito/{id}` - Eliminar del carrito

#### **Pedidos:**
- `GET /api/pedidos` - Lista pedidos del usuario
- `POST /api/pedidos` - Crear pedido
- `GET /api/pedidos/{id}` - Ver detalle de pedido

**Controladores API:** `app/Http/Controllers/Api/`

**Autenticación:** Laravel Sanctum

**Ejemplo de uso:**
```bash
# Login para obtener token
POST /api/login
{
    "email": "usuario@example.com",
    "password": "password"
}

# Usar API con token
GET /api/productos
Headers: Authorization: Bearer {token}
```

**Respuestas JSON:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nombre": "Sofá Moderno",
            "precio": 599.99,
            "stock": 10
        }
    ]
}
```

---

### **10. Roles de Usuarios + CRUD de Usuarios** ✅

**Roles definidos:**
- **admin** - Administrador (acceso total)
- **user** - Usuario normal (cliente)

**Tabla:** `roles` y tabla pivot `role_user`

**CRUD de Usuarios (solo admin):**
- `GET /admin/usuarios` - Lista usuarios
- `POST /admin/usuarios` - Crear usuario
- `PUT /admin/usuarios/{id}` - Editar usuario
- `DELETE /admin/usuarios/{id}` - Eliminar usuario

**Controlador:** `AdminController.php`

**Métodos para verificar roles:**
```php
// En User.php
public function hasRole($role)
{
    return $this->roles()->where('nombre', $role)->exists();
}

public function hasAnyRole($roles)
{
    return $this->roles()->whereIn('nombre', $roles)->exists();
}
```

**Uso en vistas:**
```blade
@if(auth()->user()->hasRole('admin'))
    <a href="/admin/main">Panel Admin</a>
@endif
```

---

### **11. Recuperar Clave + Verificación de Email** ✅

**Implementado con Laravel Fortify**

**Verificación de Email:**
- Activada en `User.php`:
  ```php
  class User extends Authenticatable implements MustVerifyEmail
  ```
- Middleware: `verified` en rutas protegidas
- Email de verificación se envía automáticamente al registrarse

**Recuperar Contraseña:**
- Ruta: `/forgot-password`
- Vista: `resources/views/auth/forgot-password.blade.php`
- Proceso:
  1. Usuario introduce su email
  2. Recibe link por correo
  3. Accede y cambia su contraseña

**Configuración email:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_password
```

---

### **12. Notificaciones** ✅

**Notificaciones creadas:**
1. `MensajeRecibidoNotification.php` - Notifica cuando recibes un mensaje
2. `PedidoCreadoNotification.php` - Notifica cuando se crea un pedido

**Archivo:** `app/Notifications/`

**Ejemplo - PedidoCreadoNotification.php:**
```php
public function via($notifiable): array
{
    return ['mail', 'database'];
}

public function toMail($notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Pedido Creado - #' . $this->pedido->id)
        ->line('Tu pedido ha sido creado exitosamente.')
        ->line('Total: €' . $this->pedido->total)
        ->action('Ver Pedido', url('/pedidos/' . $this->pedido->id))
        ->line('Gracias por tu compra!');
}
```

**¿Cómo se envía?**
```php
// En PedidoController.php
$pedido = Pedido::create($data);
$user->notify(new PedidoCreadoNotification($pedido));
```

**Ver notificaciones:**
```php
// Notificaciones no leídas
$user->unreadNotifications

// Marcar como leída
$notification->markAsRead();
```

---

### **13. Uso de Livewire** ⚠️

**RESPUESTA:** En este proyecto **NO se usa Livewire**. 

Todas las vistas son **Blade tradicionales** con JavaScript vanilla para interactividad.

**Razón:** Se priorizó:
- Simplicidad en el código
- Carga más rápida
- Uso de AJAX estándar donde se necesita

**Si quisieras agregar Livewire:**
```bash
composer require livewire/livewire
php artisan make:livewire ProductList
```

---

## 🏗️ ESTRUCTURA DEL PROYECTO

```
php-iadecorate/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php          # Gestión admin
│   │   │   ├── CarritoController.php        # Carrito de compras
│   │   │   ├── IncidenciaController.php     # Preguntas frecuentes
│   │   │   ├── MensajeController.php        # Mensajería usuario-usuario
│   │   │   ├── PedidoController.php         # Pedidos
│   │   │   ├── ProductoController.php       # Productos
│   │   │   ├── UsuarioController.php        # Perfil de usuario
│   │   │   └── Api/                         # Controladores de API
│   │   │       ├── CarritoController.php
│   │   │       ├── PedidoController.php
│   │   │       └── ProductoController.php
│   │   ├── Middleware/
│   │   │   └── CheckRole.php                # Middleware personalizado roles
│   │   └── Requests/
│   │       ├── Auth/
│   │       │   ├── LoginRequest.php
│   │       │   └── RegisterRequest.php
│   │       ├── CarritoRequest.php
│   │       ├── IncidenciaRequest.php
│   │       ├── MensajeRequest.php
│   │       ├── PedidoRequest.php
│   │       └── ProductoRequest.php
│   ├── Models/
│   │   ├── User.php                         # Usuario
│   │   ├── Rol.php                          # Roles
│   │   ├── Producto.php                     # Productos
│   │   ├── Carrito.php                      # Items del carrito
│   │   ├── Pedido.php                       # Pedidos
│   │   ├── DetallePedido.php               # Detalles de pedidos
│   │   ├── Mensaje.php                      # Mensajes
│   │   ├── Incidencia.php                   # Incidencias
│   │   └── PreguntaFrecuente.php           # FAQs
│   ├── Notifications/
│   │   ├── MensajeRecibidoNotification.php
│   │   └── PedidoCreadoNotification.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── FortifyServiceProvider.php       # Config autenticación
├── database/
│   ├── factories/
│   │   ├── ProductoFactory.php
│   │   └── UserFactory.php
│   ├── migrations/                          # Todas las migraciones
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolSeeder.php
│       ├── UserSeeder.php
│       ├── ProductoSeeder.php
│       └── PreguntaFrecuenteSeeder.php
├── resources/
│   └── views/
│       ├── auth/                            # Vistas de autenticación
│       ├── admin/                           # Panel administrador
│       ├── layouts/                         # Layouts
│       ├── carrito.blade.php
│       ├── catalogo.blade.php
│       ├── checkout.blade.php
│       ├── entorno.blade.php
│       ├── incidencias.blade.php
│       ├── index.blade.php
│       ├── info.blade.php
│       ├── mensajeria.blade.php
│       ├── pedidos.blade.php
│       ├── perfil.blade.php
│       └── producto.blade.php
├── routes/
│   ├── api.php                              # Rutas API
│   └── web.php                              # Rutas web
└── public/
    ├── css/
    │   └── style.css                        # Estilos personalizados
    ├── js/
    └── img/
```

---

## 🗄️ BASE DE DATOS Y MODELOS

### **Modelo: User** (`app/Models/User.php`)

**Propósito:** Representa a los usuarios del sistema.

**Campos:**
- `id` - ID único
- `name` - Nombre completo
- `email` - Correo electrónico (único)
- `password` - Contraseña encriptada
- `telefono` - Teléfono
- `direccion` - Dirección
- `ciudad` - Ciudad
- `codigo_postal` - Código postal
- `pais` - País
- `email_verified_at` - Fecha de verificación de email
- `two_factor_secret` - Para autenticación 2FA
- `two_factor_recovery_codes` - Códigos de recuperación 2FA

**Relaciones:**
```php
// Un usuario tiene muchos roles (N:M)
public function roles() {
    return $this->belongsToMany(Rol::class, 'role_user', 'user_id', 'rol_id');
}

// Un usuario tiene muchos items en el carrito (1:N)
public function carrito() {
    return $this->hasMany(Carrito::class, 'usuario_id');
}

// Un usuario tiene muchos pedidos (1:N)
public function pedidos() {
    return $this->hasMany(Pedido::class, 'usuario_id');
}

// Un usuario envía muchos mensajes (1:N)
public function mensajesEnviados() {
    return $this->hasMany(Mensaje::class, 'usuario_id');
}

// Un usuario recibe muchos mensajes (1:N)
public function mensajesRecibidos() {
    return $this->hasMany(Mensaje::class, 'destinatario_id');
}

// Un usuario crea muchas incidencias (1:N)
public function incidencias() {
    return $this->hasMany(Incidencia::class, 'usuario_id');
}
```

**Métodos personalizados:**
```php
// Verificar si tiene un rol específico
public function hasRole($role) {
    return $this->roles()->where('nombre', $role)->exists();
}

// Verificar si tiene alguno de varios roles
public function hasAnyRole($roles) {
    return $this->roles()->whereIn('nombre', $roles)->exists();
}
```

---

### **Modelo: Rol** (`app/Models/Rol.php`)

**Propósito:** Define los roles del sistema (admin, user).

**Campos:**
- `id`
- `nombre` - Nombre del rol
- `descripcion` - Descripción del rol

**Relaciones:**
```php
public function users() {
    return $this->belongsToMany(User::class, 'role_user', 'rol_id', 'user_id');
}
```

---

### **Modelo: Producto** (`app/Models/Producto.php`)

**Propósito:** Productos de la tienda.

**Campos:**
- `id`
- `nombre` - Nombre del producto
- `descripcion` - Descripción detallada
- `precio` - Precio (decimal)
- `stock` - Cantidad en stock
- `imagen` - Ruta de la imagen
- `categoria` - Categoría del producto

**Relaciones:**
```php
// Un producto puede estar en muchos carritos (1:N)
public function carritos() {
    return $this->hasMany(Carrito::class, 'producto_id');
}

// Un producto puede estar en muchos detalles de pedido (1:N)
public function detallesPedido() {
    return $this->hasMany(DetallePedido::class, 'producto_id');
}
```

**Scopes (consultas reutilizables):**
```php
// Solo productos en stock
public function scopeEnStock($query) {
    return $query->where('stock', '>', 0);
}

// Productos por categoría
public function scopeCategoria($query, $categoria) {
    return $query->where('categoria', $categoria);
}
```

**Uso:**
```php
$productos = Producto::enStock()->get();
$muebles = Producto::categoria('Muebles')->get();
```

---

### **Modelo: Carrito** (`app/Models/Carrito.php`)

**Propósito:** Items en el carrito de compras del usuario.

**Campos:**
- `id`
- `usuario_id` - FK a users
- `producto_id` - FK a productos
- `cantidad` - Cantidad del producto
- `precio_unitario` - Precio en el momento de agregarlo

**Relaciones:**
```php
public function usuario() {
    return $this->belongsTo(User::class, 'usuario_id');
}

public function producto() {
    return $this->belongsTo(Producto::class, 'producto_id');
}
```

**Accessor (atributo calculado):**
```php
// Calcula el subtotal automáticamente
public function getSubtotalAttribute() {
    return $this->cantidad * $this->precio_unitario;
}

// Uso:
$item->subtotal; // Devuelve cantidad * precio
```

---

### **Modelo: Pedido** (`app/Models/Pedido.php`)

**Propósito:** Pedidos realizados por usuarios.

**Campos:**
- `id`
- `usuario_id` - FK a users
- `total` - Monto total del pedido
- `estado` - Estado del pedido (pendiente, procesando, enviado, entregado, cancelado)
- `direccion_envio` - Dirección de envío
- `metodo_pago` - Método de pago usado
- `notas` - Notas adicionales

**Relaciones:**
```php
public function usuario() {
    return $this->belongsTo(User::class, 'usuario_id');
}

// Un pedido tiene muchos detalles (1:N)
public function detalles() {
    return $this->hasMany(DetallePedido::class, 'pedido_id');
}
```

**Scopes:**
```php
public function scopeEstado($query, $estado) {
    return $query->where('estado', $estado);
}

// Uso:
$pedidosPendientes = Pedido::estado('pendiente')->get();
```

---

### **Modelo: DetallePedido** (`app/Models/DetallePedido.php`)

**Propósito:** Líneas individuales de un pedido (cada producto comprado).

**Campos:**
- `id`
- `pedido_id` - FK a pedidos
- `producto_id` - FK a productos
- `cantidad` - Cantidad comprada
- `precio_unitario` - Precio en el momento de la compra
- `subtotal` - Total de esta línea

**Relaciones:**
```php
public function pedido() {
    return $this->belongsTo(Pedido::class, 'pedido_id');
}

public function producto() {
    return $this->belongsTo(Producto::class, 'producto_id');
}
```

---

### **Modelo: Mensaje** (`app/Models/Mensaje.php`)

**Propósito:** Mensajes entre usuarios.

**Campos:**
- `id`
- `usuario_id` - FK al usuario que envía
- `destinatario_id` - FK al usuario que recibe
- `mensaje` - Contenido del mensaje

**Relaciones:**
```php
public function usuario() {
    return $this->belongsTo(User::class, 'usuario_id');
}

public function destinatario() {
    return $this->belongsTo(User::class, 'destinatario_id');
}
```

---

### **Modelo: Incidencia** (`app/Models/Incidencia.php`)

**Propósito:** Incidencias/soporte para usuarios.

**Campos:**
- `id`
- `usuario_id` - FK a users
- `asunto` - Asunto de la incidencia
- `descripcion` - Descripción
- `respuesta` - Respuesta del administrador
- `estado` - Estado (abierta, en_proceso, resuelta, cerrada)
- `prioridad` - Prioridad (baja, media, alta)

**Relaciones:**
```php
public function usuario() {
    return $this->belongsTo(User::class, 'usuario_id');
}
```

---

### **Modelo: PreguntaFrecuente** (`app/Models/PreguntaFrecuente.php`)

**Propósito:** Preguntas frecuentes predefinidas.

**Campos:**
- `id`
- `pregunta` - La pregunta
- `respuesta` - La respuesta
- `activa` - Si está activa o no

**Scopes:**
```php
public function scopeActivas($query) {
    return $query->where('activa', true);
}
```

---

## 🎮 CONTROLADORES Y MÉTODOS

### **ProductoController** (`app/Http/Controllers/ProductoController.php`)

**Propósito:** Gestión de productos (CRUD + visualización).

#### **Método: index()**
```php
public function index()
{
    $productos = Producto::enStock()->get();
    return view('catalogo', compact('productos'));
}
```
**¿Qué hace?** Muestra el catálogo completo de productos en stock.
**Ruta:** `GET /catalogo`
**Vista:** `catalogo.blade.php`

#### **Método: show($id)**
```php
public function show($id)
{
    $producto = Producto::findOrFail($id);
    $relacionados = Producto::where('categoria', $producto->categoria)
        ->where('id', '!=', $id)
        ->limit(4)
        ->get();
    return view('producto', compact('producto', 'relacionados'));
}
```
**¿Qué hace?** Muestra el detalle de un producto específico con productos relacionados.
**Ruta:** `GET /producto/{id}`
**Vista:** `producto.blade.php`

#### **Método: adminIndex()** (Solo Admin)
```php
public function adminIndex()
{
    $productos = Producto::latest()->paginate(10);
    return view('admin.productos.index', compact('productos'));
}
```
**¿Qué hace?** Lista productos en el panel de administración con paginación.
**Ruta:** `GET /admin/productos`
**Vista:** `admin/productos/index.blade.php`

#### **Método: store(ProductoRequest $request)** (Solo Admin)
```php
public function store(ProductoRequest $request)
{
    $data = $request->validated();
    
    if ($request->hasFile('imagen')) {
        $path = $request->file('imagen')->store('productos', 'public');
        $data['imagen'] = $path;
    }
    
    Producto::create($data);
    
    return redirect()
        ->route('admin.productos.index')
        ->with('success', 'Producto creado exitosamente');
}
```
**¿Qué hace?** 
1. Valida los datos usando ProductoRequest
2. Sube la imagen al servidor
3. Crea el producto en la BD
4. Redirige con mensaje de éxito

**Ruta:** `POST /admin/productos`

#### **Método: update(ProductoRequest $request, $id)** (Solo Admin)
```php
public function update(ProductoRequest $request, $id)
{
    $producto = Producto::findOrFail($id);
    $data = $request->validated();
    
    if ($request->hasFile('imagen')) {
        // Eliminar imagen anterior
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $path = $request->file('imagen')->store('productos', 'public');
        $data['imagen'] = $path;
    }
    
    $producto->update($data);
    
    return redirect()
        ->route('admin.productos.index')
        ->with('success', 'Producto actualizado exitosamente');
}
```
**¿Qué hace?**
1. Encuentra el producto
2. Si hay nueva imagen, elimina la anterior y sube la nueva
3. Actualiza el producto
4. Redirige con mensaje

**Ruta:** `PUT /admin/productos/{id}`

#### **Método: destroy($id)** (Solo Admin)
```php
public function destroy($id)
{
    $producto = Producto::findOrFail($id);
    
    // Eliminar imagen
    if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
        Storage::disk('public')->delete($producto->imagen);
    }
    
    $producto->delete();
    
    return redirect()
        ->route('admin.productos.index')
        ->with('success', 'Producto eliminado exitosamente');
}
```
**¿Qué hace?**
1. Encuentra el producto
2. Elimina su imagen del storage
3. Elimina el producto de la BD
4. Redirige con mensaje

**Ruta:** `DELETE /admin/productos/{id}`

---

### **CarritoController** (`app/Http/Controllers/CarritoController.php`)

**Propósito:** Gestión del carrito de compras.

#### **Método: index()**
```php
public function index()
{
    $carrito = Auth::user()
        ->carrito()
        ->with('producto')
        ->get();
    
    $total = $carrito->sum('subtotal');
    
    return view('carrito', compact('carrito', 'total'));
}
```
**¿Qué hace?** Muestra el carrito del usuario actual con el total calculado.
**Ruta:** `GET /carrito`
**Vista:** `carrito.blade.php`

#### **Método: agregar($productoId)**
```php
public function agregar($productoId)
{
    $producto = Producto::findOrFail($productoId);
    
    // Verificar stock
    if ($producto->stock <= 0) {
        return back()->withErrors(['error' => 'Producto sin stock']);
    }
    
    // Buscar si ya existe en el carrito
    $itemCarrito = Carrito::where('usuario_id', Auth::id())
        ->where('producto_id', $productoId)
        ->first();
    
    if ($itemCarrito) {
        // Incrementar cantidad
        $itemCarrito->cantidad += 1;
        $itemCarrito->save();
    } else {
        // Crear nuevo item
        Carrito::create([
            'usuario_id' => Auth::id(),
            'producto_id' => $productoId,
            'cantidad' => 1,
            'precio_unitario' => $producto->precio,
        ]);
    }
    
    return redirect()
        ->route('carrito')
        ->with('success', 'Producto agregado al carrito');
}
```
**¿Qué hace?**
1. Busca el producto
2. Verifica que haya stock
3. Si ya está en el carrito, incrementa cantidad
4. Si no está, lo agrega
5. Redirige al carrito

**Ruta:** `POST /carrito/agregar/{producto}`

#### **Método: actualizar(Request $request, $itemId)**
```php
public function actualizar(Request $request, $itemId)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1',
    ]);
    
    $item = Carrito::where('id', $itemId)
        ->where('usuario_id', Auth::id())
        ->firstOrFail();
    
    // Verificar stock disponible
    if ($request->cantidad > $item->producto->stock) {
        return back()->withErrors(['error' => 'Stock insuficiente']);
    }
    
    $item->cantidad = $request->cantidad;
    $item->save();
    
    return back()->with('success', 'Cantidad actualizada');
}
```
**¿Qué hace?**
1. Valida la cantidad
2. Verifica que el item pertenezca al usuario
3. Verifica stock suficiente
4. Actualiza la cantidad
5. Regresa a la página anterior

**Ruta:** `POST /carrito/actualizar/{item}`

#### **Método: eliminar($itemId)**
```php
public function eliminar($itemId)
{
    $item = Carrito::where('id', $itemId)
        ->where('usuario_id', Auth::id())
        ->firstOrFail();
    
    $item->delete();
    
    return back()->with('success', 'Producto eliminado del carrito');
}
```
**¿Qué hace?**
1. Busca el item verificando que sea del usuario
2. Lo elimina
3. Regresa con mensaje

**Ruta:** `DELETE /carrito/{item}`

---

### **PedidoController** (`app/Http/Controllers/PedidoController.php`)

**Propósito:** Gestión de pedidos.

#### **Método: index()**
```php
public function index()
{
    $pedidos = Auth::user()
        ->pedidos()
        ->latest()
        ->with('detalles.producto')
        ->get();
    
    return view('pedidos', compact('pedidos'));
}
```
**¿Qué hace?** Lista todos los pedidos del usuario actual ordenados del más reciente.
**Ruta:** `GET /pedidos`
**Vista:** `pedidos.blade.php`

#### **Método: show($id)**
```php
public function show($id)
{
    $pedido = Pedido::with('detalles.producto')
        ->where('usuario_id', Auth::id())
        ->findOrFail($id);
    
    return view('pedido-detalle', compact('pedido'));
}
```
**¿Qué hace?** Muestra el detalle completo de un pedido específico.
**Ruta:** `GET /pedido/{id}`
**Vista:** `pedido-detalle.blade.php`

#### **Método: checkout()**
```php
public function checkout()
{
    $carrito = Auth::user()->carrito()->with('producto')->get();
    
    if ($carrito->isEmpty()) {
        return redirect()->route('carrito')
            ->withErrors(['error' => 'Tu carrito está vacío']);
    }
    
    $total = $carrito->sum('subtotal');
    
    return view('checkout', compact('carrito', 'total'));
}
```
**¿Qué hace?** Muestra la página de checkout si hay items en el carrito.
**Ruta:** `GET /checkout`
**Vista:** `checkout.blade.php`

#### **Método: crear(Request $request)**
```php
public function crear(Request $request)
{
    $validated = $request->validate([
        'direccion_envio' => 'required|string',
        'metodo_pago' => 'required|in:tarjeta,paypal,transferencia',
        'notas' => 'nullable|string|max:500',
    ]);
    
    $user = Auth::user();
    $carrito = $user->carrito()->with('producto')->get();
    
    if ($carrito->isEmpty()) {
        return back()->withErrors(['error' => 'Carrito vacío']);
    }
    
    // Verificar stock de todos los productos
    foreach ($carrito as $item) {
        if ($item->cantidad > $item->producto->stock) {
            return back()->withErrors([
                'error' => "Stock insuficiente para {$item->producto->nombre}"
            ]);
        }
    }
    
    $total = $carrito->sum('subtotal');
    
    // Crear pedido
    $pedido = Pedido::create([
        'usuario_id' => $user->id,
        'total' => $total,
        'estado' => 'pendiente',
        'direccion_envio' => $validated['direccion_envio'],
        'metodo_pago' => $validated['metodo_pago'],
        'notas' => $validated['notas'] ?? null,
    ]);
    
    // Crear detalles del pedido
    foreach ($carrito as $item) {
        DetallePedido::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $item->producto_id,
            'cantidad' => $item->cantidad,
            'precio_unitario' => $item->precio_unitario,
            'subtotal' => $item->subtotal,
        ]);
        
        // Reducir stock
        $item->producto->decrement('stock', $item->cantidad);
    }
    
    // Vaciar carrito
    $user->carrito()->delete();
    
    // Enviar notificación
    $user->notify(new PedidoCreadoNotification($pedido));
    
    return redirect()
        ->route('pedidos')
        ->with('success', 'Pedido realizado exitosamente');
}
```
**¿Qué hace?** (Paso a paso)
1. Valida datos del formulario
2. Obtiene el carrito del usuario
3. Verifica que haya stock suficiente de todos los productos
4. Calcula el total
5. Crea el registro del pedido
6. Crea los detalles del pedido (cada producto)
7. Reduce el stock de cada producto
8. Vacía el carrito del usuario
9. Envía notificación por email
10. Redirige a la lista de pedidos

**Ruta:** `POST /pedido/crear`

---

### **MensajeController** (`app/Http/Controllers/MensajeController.php`)

**Propósito:** Sistema de mensajería entre usuarios.

#### **Método: index(Request $request)**
```php
public function index(Request $request)
{
    // Obtener usuarios (excluyendo admin y el usuario actual)
    $usuarios = User::whereDoesntHave('roles', function ($query) {
        $query->where('nombre', 'administrador');
    })
    ->where('id', '!=', Auth::id())
    ->orderBy('name', 'asc')
    ->get();
    
    // Obtener destinatario seleccionado
    $destinatarioId = $request->get('destinatario_id', $usuarios->first()->id ?? null);
    
    // Obtener mensajes SOLO de esta conversación
    $mensajes = collect();
    if ($destinatarioId) {
        $mensajes = Mensaje::where(function($query) use ($destinatarioId) {
            $query->where('usuario_id', Auth::id())
                  ->where('destinatario_id', $destinatarioId);
        })->orWhere(function($query) use ($destinatarioId) {
            $query->where('usuario_id', $destinatarioId)
                  ->where('destinatario_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();
    }
    
    return view('mensajeria', compact('mensajes', 'usuarios', 'destinatarioId'));
}
```
**¿Qué hace?**
1. Lista usuarios disponibles para chatear (sin admins)
2. Obtiene el usuario con quien estás conversando
3. Filtra mensajes SOLO entre tú y esa persona (bidireccional)
4. Los ordena cronológicamente
5. Muestra la vista con los mensajes

**Ruta:** `GET /mensajeria?destinatario_id={id}`
**Vista:** `mensajeria.blade.php`

#### **Método: enviar(Request $request)**
```php
public function enviar(Request $request)
{
    $validated = $request->validate([
        'mensaje' => 'required|string|max:1000',
        'destinatario_id' => 'required|exists:users,id',
    ]);
    
    $mensaje = Mensaje::create([
        'usuario_id' => Auth::id(),
        'destinatario_id' => $validated['destinatario_id'],
        'mensaje' => $validated['mensaje'],
    ]);
    
    // Notificar al destinatario
    $destinatario = User::find($validated['destinatario_id']);
    $destinatario->notify(new MensajeRecibidoNotification($mensaje));
    
    return redirect()
        ->route('mensajeria', ['destinatario_id' => $validated['destinatario_id']])
        ->with('success', 'Mensaje enviado');
}
```
**¿Qué hace?**
1. Valida el mensaje y destinatario
2. Crea el mensaje en BD
3. Envía notificación al destinatario
4. Redirige a la conversación con ese usuario

**Ruta:** `POST /mensajeria/enviar`

---

### **IncidenciaController** (`app/Http/Controllers/IncidenciaController.php`)

**Propósito:** Sistema de soporte con preguntas frecuentes.

#### **Método: index()**
```php
public function index()
{
    $incidencias = Auth::user()
        ->incidencias()
        ->latest()
        ->get();
    
    $preguntasFrecuentes = PreguntaFrecuente::activas()->get();
    
    return view('incidencias', compact('incidencias', 'preguntasFrecuentes'));
}
```
**¿Qué hace?** Muestra el historial de incidencias del usuario y las FAQs disponibles.
**Ruta:** `GET /incidencias`
**Vista:** `incidencias.blade.php`

#### **Método: crear(Request $request)**
```php
public function crear(Request $request)
{
    $validated = $request->validate([
        'pregunta_id' => 'required|exists:preguntas_frecuentes,id',
    ]);
    
    $pregunta = PreguntaFrecuente::findOrFail($validated['pregunta_id']);
    
    Incidencia::create([
        'usuario_id' => Auth::id(),
        'asunto' => $pregunta->pregunta,
        'descripcion' => $pregunta->pregunta,
        'respuesta' => $pregunta->respuesta,
        'prioridad' => 'baja',
        'estado' => 'resuelta',
    ]);
    
    return redirect()
        ->route('incidencias')
        ->with('success', 'Consulta registrada');
}
```
**¿Qué hace?**
1. Valida que se haya seleccionado una pregunta frecuente
2. Obtiene la pregunta y su respuesta
3. Crea la incidencia con estado "resuelta" automáticamente
4. Redirige con mensaje

**Nota:** Solo permite preguntas frecuentes predefinidas, NO texto libre.

**Ruta:** `POST /incidencias/crear`

---

### **UsuarioController** (`app/Http/Controllers/UsuarioController.php`)

**Propósito:** Gestión del perfil del usuario.

#### **Método: perfil()**
```php
public function perfil()
{
    $user = Auth::user();
    return view('perfil', compact('user'));
}
```
**¿Qué hace?** Muestra el formulario de perfil con los datos actuales.
**Ruta:** `GET /perfil`
**Vista:** `perfil.blade.php`

#### **Método: actualizar(Request $request)**
```php
public function actualizar(Request $request)
{
    $user = Auth::user();
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
        'ciudad' => 'nullable|string|max:100',
        'codigo_postal' => 'nullable|string|max:10',
        'pais' => 'nullable|string|max:100',
        'password' => 'nullable|min:8|confirmed',
    ]);
    
    // Actualizar datos básicos
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->telefono = $validated['telefono'] ?? null;
    $user->direccion = $validated['direccion'] ?? null;
    $user->ciudad = $validated['ciudad'] ?? null;
    $user->codigo_postal = $validated['codigo_postal'] ?? null;
    $user->pais = $validated['pais'] ?? 'España';
    
    // Actualizar contraseña si se proporcionó
    if ($request->filled('password')) {
        $user->password = Hash::make($validated['password']);
    }
    
    $user->save();
    
    return back()->with('success', 'Perfil actualizado exitosamente');
}
```
**¿Qué hace?**
1. Valida todos los campos del perfil
2. Actualiza la información del usuario
3. Si se proporcionó nueva contraseña, la encripta y actualiza
4. Guarda los cambios
5. Regresa con mensaje de éxito

**Ruta:** `PUT /perfil/actualizar`

---

### **AdminController** (`app/Http/Controllers/AdminController.php`)

**Propósito:** Panel de administración completo.

#### **Método: main()**
```php
public function main()
{
    $stats = [
        'usuarios' => User::count(),
        'productos' => Producto::count(),
        'pedidos' => Pedido::count(),
        'ingresos' => Pedido::sum('total'),
    ];
    
    $pedidosRecientes = Pedido::with('usuario')
        ->latest()
        ->limit(5)
        ->get();
    
    return view('admin.main', compact('stats', 'pedidosRecientes'));
}
```
**¿Qué hace?** Muestra el dashboard con estadísticas generales.
**Ruta:** `GET /admin/main`
**Vista:** `admin/main.blade.php`

#### **Método: usuarios()**
```php
public function usuarios()
{
    $usuarios = User::with('roles')->latest()->paginate(15);
    return view('admin.usuarios', compact('usuarios'));
}
```
**¿Qué hace?** Lista todos los usuarios con paginación.
**Ruta:** `GET /admin/usuarios`
**Vista:** `admin/usuarios.blade.php`

#### **Método: guardarUsuario(Request $request)**
```php
public function guardarUsuario(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'rol' => 'required|exists:roles,id',
    ]);
    
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);
    
    // Asignar rol
    $user->roles()->attach($validated['rol']);
    
    return redirect()
        ->route('admin.usuarios')
        ->with('success', 'Usuario creado exitosamente');
}
```
**¿Qué hace?**
1. Valida datos del nuevo usuario
2. Crea el usuario con contraseña encriptada
3. Asigna el rol seleccionado
4. Redirige con mensaje

**Ruta:** `POST /admin/usuarios`

#### **Método: eliminarUsuario($usuarioId)**
```php
public function eliminarUsuario($usuarioId)
{
    $usuario = User::findOrFail($usuarioId);
    
    // No permitir eliminar al propio admin
    if ($usuario->id === Auth::id()) {
        return back()->withErrors(['error' => 'No puedes eliminarte a ti mismo']);
    }
    
    $usuario->delete();
    
    return redirect()
        ->route('admin.usuarios')
        ->with('success', 'Usuario eliminado');
}
```
**¿Qué hace?**
1. Busca el usuario
2. Verifica que no sea el mismo admin
3. Elimina el usuario
4. Redirige con mensaje

**Ruta:** `DELETE /admin/usuarios/{usuario}`

#### **Método: pedidos()**
```php
public function pedidos()
{
    $pedidos = Pedido::with('usuario', 'detalles')
        ->latest()
        ->paginate(20);
    
    return view('admin.pedidos', compact('pedidos'));
}
```
**¿Qué hace?** Lista todos los pedidos del sistema.
**Ruta:** `GET /admin/pedidos`
**Vista:** `admin/pedidos.blade.php`

#### **Método: cambiarEstadoPedido(Request $request, $id)**
```php
public function cambiarEstadoPedido(Request $request, $id)
{
    $validated = $request->validate([
        'estado' => 'required|in:pendiente,procesando,enviado,entregado,cancelado',
    ]);
    
    $pedido = Pedido::findOrFail($id);
    $pedido->estado = $validated['estado'];
    $pedido->save();
    
    return back()->with('success', 'Estado actualizado');
}
```
**¿Qué hace?**
1. Valida el nuevo estado
2. Busca el pedido
3. Actualiza su estado
4. Regresa con mensaje

**Ruta:** `PATCH /admin/pedidos/{id}/estado`

---

## 🎨 VISTAS EXPLICADAS

### **Vista: index.blade.php** (Página principal)

**Ubicación:** `resources/views/index.blade.php`

**Propósito:** Landing page de la aplicación.

**Elementos principales:**
- Hero section con mensaje de bienvenida
- Carrusel de productos destacados
- Secciones informativas sobre el servicio
- Call-to-action para registrarse
- Footer con enlaces

**Código relevante:**
```blade
@extends('layouts.app')

@section('content')
    <div class="hero-section">
        <h1>Bienvenido a IADECORATE</h1>
        <p>Transforma tu hogar con nuestros productos</p>
        <a href="{{ route('catalogo') }}" class="btn-primary">Ver Catálogo</a>
    </div>
    
    <div class="productos-destacados">
        <h2>Productos Destacados</h2>
        @foreach($productosDestacados as $producto)
            <div class="producto-card">
                <img src="{{ asset('storage/' . $producto->imagen) }}">
                <h3>{{ $producto->nombre }}</h3>
                <p>€{{ $producto->precio }}</p>
            </div>
        @endforeach
    </div>
@endsection
```

---

### **Vista: catalogo.blade.php**

**Ubicación:** `resources/views/catalogo.blade.php`

**Propósito:** Mostrar todos los productos disponibles.

**Elementos:**
- Grid de productos con imágenes
- Filtros por categoría
- Barra de búsqueda
- Botones para agregar al carrito

**Código relevante:**
```blade
@extends('layouts.app')

@section('content')
    <div class="catalogo-container">
        <h1>Catálogo de Productos</h1>
        
        <!-- Filtros -->
        <div class="filtros">
            <select id="categoriaFilter">
                <option value="">Todas las categorías</option>
                <option value="Muebles">Muebles</option>
                <option value="Decoración">Decoración</option>
                <option value="Iluminación">Iluminación</option>
            </select>
        </div>
        
        <!-- Grid de productos -->
        <div class="productos-grid">
            @forelse($productos as $producto)
                <div class="producto-card">
                    <a href="{{ route('producto.detalle', $producto->id) }}">
                        <img src="{{ asset('storage/' . $producto->imagen) }}" 
                             alt="{{ $producto->nombre }}">
                    </a>
                    <h3>{{ $producto->nombre }}</h3>
                    <p class="precio">€{{ number_format($producto->precio, 2) }}</p>
                    <p class="stock">Stock: {{ $producto->stock }}</p>
                    
                    @if($producto->stock > 0)
                        <form action="{{ route('carrito.agregar', $producto->id) }}" 
                              method="POST">
                            @csrf
                            <button type="submit" class="btn-add-cart">
                                Agregar al Carrito
                            </button>
                        </form>
                    @else
                        <button class="btn-disabled" disabled>Sin Stock</button>
                    @endif
                </div>
            @empty
                <p>No hay productos disponibles</p>
            @endforelse
        </div>
    </div>
@endsection
```

**JavaScript para filtros:**
```javascript
document.getElementById('categoriaFilter').addEventListener('change', function() {
    const categoria = this.value;
    window.location.href = `/catalogo?categoria=${categoria}`;
});
```

---

### **Vista: producto.blade.php** (Detalle de producto)

**Ubicación:** `resources/views/producto.blade.php`

**Propósito:** Mostrar información detallada de un producto.

**Elementos:**
- Imagen grande del producto
- Descripción completa
- Precio y stock
- Selector de cantidad
- Botón para agregar al carrito
- Productos relacionados

**Código relevante:**
```blade
@extends('layouts.app')

@section('content')
    <div class="producto-detalle-container">
        <div class="producto-imagen">
            <img src="{{ asset('storage/' . $producto->imagen) }}" 
                 alt="{{ $producto->nombre }}">
        </div>
        
        <div class="producto-info">
            <h1>{{ $producto->nombre }}</h1>
            <p class="categoria">{{ $producto->categoria }}</p>
            <p class="precio">€{{ number_format($producto->precio, 2) }}</p>
            
            <div class="descripcion">
                <h3>Descripción</h3>
                <p>{{ $producto->descripcion }}</p>
            </div>
            
            <div class="stock-info">
                @if($producto->stock > 0)
                    <span class="disponible">✓ Disponible ({{ $producto->stock }} unidades)</span>
                @else
                    <span class="agotado">✗ Agotado</span>
                @endif
            </div>
            
            @if($producto->stock > 0)
                <form action="{{ route('carrito.agregar', $producto->id) }}" 
                      method="POST" class="form-agregar">
                    @csrf
                    <button type="submit" class="btn-primary">
                        Agregar al Carrito
                    </button>
                </form>
            @endif
        </div>
    </div>
    
    <!-- Productos relacionados -->
    @if($relacionados->count() > 0)
        <div class="productos-relacionados">
            <h2>También te puede interesar</h2>
            <div class="productos-grid">
                @foreach($relacionados as $relacionado)
                    <div class="producto-card">
                        <a href="{{ route('producto.detalle', $relacionado->id) }}">
                            <img src="{{ asset('storage/' . $relacionado->imagen) }}">
                            <h3>{{ $relacionado->nombre }}</h3>
                            <p>€{{ $relacionado->precio }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
```

---

### **Vista: carrito.blade.php**

**Ubicación:** `resources/views/carrito.blade.php`

**Propósito:** Mostrar el carrito de compras del usuario.

**Elementos:**
- Lista de productos en el carrito
- Controles para actualizar cantidad
- Botón para eliminar items
- Resumen del total
- Botón para proceder al checkout

**Código relevante:**
```blade
@extends('layouts.app')

@section('content')
    <div class="carrito-container">
        <h1>Mi Carrito</h1>
        
        @if($carrito->isEmpty())
            <div class="carrito-vacio">
                <p>Tu carrito está vacío</p>
                <a href="{{ route('catalogo') }}" class="btn-primary">
                    Ir al Catálogo
                </a>
            </div>
        @else
            <div class="carrito-items">
                @foreach($carrito as $item)
                    <div class="carrito-item">
                        <img src="{{ asset('storage/' . $item->producto->imagen) }}" 
                             alt="{{ $item->producto->nombre }}">
                        
                        <div class="item-info">
                            <h3>{{ $item->producto->nombre }}</h3>
                            <p class="precio-unitario">
                                €{{ number_format($item->precio_unitario, 2) }}
                            </p>
                        </div>
                        
                        <form action="{{ route('carrito.actualizar', $item->id) }}" 
                              method="POST" class="cantidad-form">
                            @csrf
                            <input type="number" 
                                   name="cantidad" 
                                   value="{{ $item->cantidad }}" 
                                   min="1" 
                                   max="{{ $item->producto->stock }}">
                            <button type="submit" class="btn-update">Actualizar</button>
                        </form>
                        
                        <div class="item-subtotal">
                            <p>€{{ number_format($item->subtotal, 2) }}</p>
                        </div>
                        
                        <form action="{{ route('carrito.eliminar', $item->id) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            
            <div class="carrito-resumen">
                <h2>Resumen del Pedido</h2>
                <div class="resumen-linea">
                    <span>Subtotal:</span>
                    <span>€{{ number_format($total, 2) }}</span>
                </div>
                <div class="resumen-linea">
                    <span>Envío:</span>
                    <span>Gratis</span>
                </div>
                <div class="resumen-total">
                    <span>Total:</span>
                    <span>€{{ number_format($total, 2) }}</span>
                </div>
                
                <a href="{{ route('checkout') }}" class="btn-checkout">
                    Proceder al Pago
                </a>
            </div>
        @endif
    </div>
@endsection
```

---

### **Vista: checkout.blade.php**

**Ubicación:** `resources/views/checkout.blade.php`

**Propósito:** Formulario para finalizar la compra.

**Elementos:**
- Resumen del carrito
- Formulario de dirección de envío
- Selector de método de pago
- Campo de notas opcionales
- Botón para confirmar pedido

**Código relevante:**
```blade
@extends('layouts.app')

@section('content')
    <div class="checkout-container">
        <h1>Finalizar Compra</h1>
        
        <div class="checkout-content">
            <!-- Resumen del carrito -->
            <div class="checkout-resumen">
                <h2>Tu Pedido</h2>
                @foreach($carrito as $item)
                    <div class="item-resumen">
                        <span>{{ $item->producto->nombre }} x{{ $item->cantidad }}</span>
                        <span>€{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
                <div class="total-resumen">
                    <strong>Total:</strong>
                    <strong>€{{ number_format($total, 2) }}</strong>
                </div>
            </div>
            
            <!-- Formulario -->
            <div class="checkout-form">
                <form action="{{ route('pedido.crear') }}" method="POST">
                    @csrf
                    
                    <h3>Dirección de Envío</h3>
                    <div class="form-group">
                        <label for="direccion_envio">Dirección Completa *</label>
                        <textarea name="direccion_envio" 
                                  id="direccion_envio" 
                                  required>{{ auth()->user()->direccion ?? '' }}</textarea>
                        @error('direccion_envio')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <h3>Método de Pago</h3>
                    <div class="form-group">
                        <select name="metodo_pago" required>
                            <option value="">Selecciona método</option>
                            <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                            <option value="paypal">PayPal</option>
                            <option value="transferencia">Transferencia Bancaria</option>
                        </select>
                        @error('metodo_pago')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="notas">Notas (opcional)</label>
                        <textarea name="notas" 
                                  id="notas" 
                                  placeholder="Instrucciones especiales..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn-confirmar">
                        Confirmar Pedido
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
```

---

### **Vista: pedidos.blade.php**

**Ubicación:** `resources/views/pedidos.blade.php`

**Propósito:** Lista de todos los pedidos del usuario.

**Elementos:**
- Tabla con todos los pedidos
- Estado de cada pedido con colores
- Botón para ver detalle
- Total de cada pedido

**Código relevante:**
```blade
@extends('layouts.app')

@section('content')
    <div class="pedidos-container">
        <h1>Mis Pedidos</h1>
        
        @if($pedidos->isEmpty())
            <p>No tienes pedidos aún</p>
            <a href="{{ route('catalogo') }}" class="btn-primary">
                Ir de Compras
            </a>
        @else
            <div class="pedidos-lista">
                @foreach($pedidos as $pedido)
                    <div class="pedido-card">
                        <div class="pedido-header">
                            <h3>Pedido #{{ $pedido->id }}</h3>
                            <span class="estado estado-{{ $pedido->estado }}">
                                {{ ucfirst($pedido->estado) }}
                            </span>
                        </div>
                        
                        <div class="pedido-info">
                            <p><strong>Fecha:</strong> 
                                {{ $pedido->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p><strong>Total:</strong> 
                                €{{ number_format($pedido->total, 2) }}
                            </p>
                            <p><strong>Products:</strong> 
                                {{ $pedido->detalles->count() }} artículos
                            </p>
                        </div>
                        
                        <a href="{{ route('pedido.detalle', $pedido->id) }}" 
                           class="btn-ver-detalle">
                            Ver Detalle
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
```

**CSS para estados:**
```css
.estado-pendiente { background: #ffc107; color: #000; }
.estado-procesando { background: #2196f3; color: #fff; }
.estado-enviado { background: #ff9800; color: #fff; }
.estado-entregado { background: #4caf50; color: #fff; }
.estado-cancelado { background: #f44336; color: #fff; }
```

---

### **Vista: mensajeria.blade.php**

**Ubicación:** `resources/views/mensajeria.blade.php`

**Propósito:** Chat secuencial entre usuarios.

**Elementos:**
- Lista de contactos (sidebar)
- Área de mensajes de la conversación seleccionada
- Formulario para enviar mensajes
- Scroll automático al final

**Código relevante:**
```blade
@extends('layouts.app')

@section('content')
    <div class="chat-container">
        <!-- Sidebar de contactos -->
        <div class="chat-sidebar">
            <h2>Conversaciones</h2>
            <div class="conversations-list">
                @forelse($usuarios as $usuario)
                    <a href="{{ route('mensajeria', ['destinatario_id' => $usuario->id]) }}" 
                       class="conversation-item @if($destinatarioId == $usuario->id) active @endif">
                        <div class="conversation-avatar">
                            {{ strtoupper(substr($usuario->name, 0, 1)) }}
                        </div>
                        <div class="conversation-info">
                            <div class="conversation-name">{{ $usuario->name }}</div>
                            <div class="conversation-preview">Ver conversación</div>
                        </div>
                    </a>
                @empty
                    <div class="no-conversations">
                        No hay usuarios disponibles
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Área de chat -->
        <div class="chat-main">
            <div class="chat-header">
                <div class="chat-header-avatar">
                    @if(isset($destinatarioId))
                        @php
                            $destinatario = $usuarios->firstWhere('id', $destinatarioId);
                        @endphp
                        {{ $destinatario ? strtoupper(substr($destinatario->name, 0, 1)) : '👤' }}
                    @else
                        👤
                    @endif
                </div>
                <h3>
                    @if(isset($destinatarioId) && $destinatario)
                        {{ $destinatario->name }}
                    @else
                        Selecciona una conversación
                    @endif
                </h3>
            </div>
            
            <!-- Mensajes -->
            <div class="chat-messages" id="chatMessages">
                @forelse($mensajes as $mensaje)
                    <div class="message-group @if($mensaje->usuario_id == auth()->id()) user @endif">
                        @if($mensaje->usuario_id != auth()->id())
                            <div class="message-avatar">
                                {{ strtoupper(substr($mensaje->usuario->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <div class="message-content">
                            <div class="message-sender">
                                {{ $mensaje->usuario->name }}
                            </div>
                            <div class="message-text">
                                {{ $mensaje->mensaje }}
                            </div>
                            <div class="message-time">
                                {{ $mensaje->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-messages">
                        No hay mensajes en esta conversación
                    </div>
                @endforelse
            </div>
            
            <!-- Input para enviar mensaje -->
            <div class="chat-input-section">
                <form method="POST" action="{{ route('mensajeria.enviar') }}">
                    @csrf
                    <div class="chat-input-wrapper">
                        <input type="text" 
                               name="mensaje" 
                               placeholder="Escriba su mensaje aquí" 
                               required>
                        <input type="hidden" 
                               name="destinatario_id" 
                               value="{{ $destinatarioId ?? '' }}">
                        <button type="submit" 
                                @if(!isset($destinatarioId)) disabled @endif>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Scroll al final al cargar
    window.addEventListener('load', () => {
      const chatMessages = document.getElementById('chatMessages');
      if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }
    });
</script>
@endpush
```

**Características:**
- **Conversaciones independientes:** Cada usuario solo ve sus mensajes con la persona seleccionada
- **Sin Livewire:** Recarga de página para nuevos mensajes
- **Navegación:** Cada contacto es un enlace que filtra los mensajes

---

### **Vista: incidencias.blade.php**

**Ubicación:** `resources/views/incidencias.blade.php`

**Propósito:** Sistema de soporte basado en FAQs.

**Elementos:**
- Historial de consultas realizadas
- Selector de preguntas frecuentes
- Respuestas inmediatas con JavaScript

**Código relevante:**
```blade
@extends('layouts.app')

@section('content')
    <div class="incidencias-container">
        <h1>Centro de Ayuda</h1>
        
        <!-- Área de chat con historial -->
        <div class="chat-messages" id="chatMessages">
            @foreach($incidencias as $incidencia)
                <!-- Pregunta del usuario -->
                <div class="message-group user">
                    <div class="message-content">
                        <div class="message-sender">{{ auth()->user()->name }}</div>
                        <div class="message-text">{{ $incidencia->descripcion }}</div>
                    </div>
                </div>
                
                <!-- Respuesta automática -->
                <div class="message-group">
                    <div class="message-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="message-content">
                        <div class="message-sender">Atención al cliente</div>
                        <div class="message-text">{{ $incidencia->respuesta }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Selector de preguntas frecuentes -->
        <div class="chat-input-section">
            @if(isset($preguntasFrecuentes) && count($preguntasFrecuentes) > 0)
            <div style="text-align: center; margin-bottom: 15px;">
                <p style="color: var(--text-dark); font-weight: 600; margin-bottom: 10px;">
                    <i class="fas fa-info-circle"></i> Selecciona una pregunta frecuente:
                </p>
                <select class="faq-selector" id="faqSelector">
                    <option value="">¿En qué podemos ayudarte?</option>
                    @foreach($preguntasFrecuentes as $faq)
                        <option value="{{ $faq->id }}" 
                                data-pregunta="{{ $faq->pregunta }}" 
                                data-respuesta="{{ $faq->respuesta }}">
                            {{ $faq->pregunta }}
                        </option>
                    @endforeach
                </select>
            </div>
            @else
            <div style="text-align: center; padding: 20px;">
                <p style="color: var(--text-dark);">
                    No hay preguntas frecuentes disponibles en este momento.
                </p>
            </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    window.addEventListener('load', function() {
      const chatMessages = document.getElementById('chatMessages');
      if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }
    });

    // Selector de preguntas frecuentes
    const faqSelector = document.getElementById('faqSelector');
    const chatMessagesDiv = document.getElementById('chatMessages');

    if (faqSelector) {
      faqSelector.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const pregunta = selectedOption.getAttribute('data-pregunta');
        const respuesta = selectedOption.getAttribute('data-respuesta');

        if (this.value && pregunta && respuesta) {
          // Agregar pregunta del usuario
          const userMessageGroup = document.createElement('div');
          userMessageGroup.className = 'message-group user';
          userMessageGroup.innerHTML = `
            <div class="message-content">
              <div class="message-sender">{{ auth()->user()->name ?? 'Tú' }}</div>
              <div class="message-text">${pregunta}</div>
            </div>
          `;
          chatMessagesDiv.appendChild(userMessageGroup);

          // Scroll al final
          chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;

          // Agregar respuesta automática
          setTimeout(() => {
            const botMessageGroup = document.createElement('div');
            botMessageGroup.className = 'message-group';
            botMessageGroup.innerHTML = `
              <div class="message-avatar">
                <i class="fas fa-robot"></i>
              </div>
              <div class="message-content">
                <div class="message-sender">Atención al cliente</div>
                <div class="message-text">${respuesta}</div>
              </div>
            `;
            chatMessagesDiv.appendChild(botMessageGroup);

            // Scroll al final
            chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;
          }, 800);

          // Reset selector
          this.value = '';
        }
      });
    }
</script>
@endpush
```

**Funcionamiento:**
1. Usuario selecciona una pregunta del dropdown
2. JavaScript agrega la pregunta como mensaje del usuario
3. Después de 800ms agrega la respuesta automática
4. Todo sucede sin recargar la página
5. Scroll automático al final para ver los nuevos mensajes

---

### **Vista: perfil.blade.php**

**Ubicación:** `resources/views/perfil.blade.php`

**Propósito:** Editar información del perfil.

**Elementos:**
- Formulario con datos personales
- Campos de dirección
- Cambio de contraseña
- Botón para guardar

**Código simplificado:**
```blade
@extends('layouts.app')

@section('content')
    <div class="perfil-container">
        <h1>Mi Perfil</h1>
        
        <form action="{{ route('perfil.actualizar') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="name" value="{{ $user->name }}" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required>
            </div>
            
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ $user->telefono }}">
            </div>
            
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" value="{{ $user->direccion }}">
            </div>
            
            <!-- Más campos... -->
            
            <div class="form-group">
                <label>Nueva Contraseña (dejar vacío para no cambiar)</label>
                <input type="password" name="password">
            </div>
            
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation">
            </div>
            
            <button type="submit" class="btn-primary">Guardar Cambios</button>
        </form>
    </div>
@endsection
```

---

### **Vista: entorno.blade.php** (Entorno 3D)

**Ubicación:** `resources/views/entorno.blade.php`

**Propósito:** Visualizador 3D de productos (puede usar Three.js, Babylon.js, etc).

**Código básico:**
```blade
@extends('layouts.app')

@section('content')
    <div class="entorno-3d-container">
        <h1>Visualizador 3D</h1>
        <div id="canvas3D"></div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
    // Inicializar escena 3D
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer();
    
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.getElementById('canvas3D').appendChild(renderer.domElement);
    
    // ... resto del código 3D
</script>
@endpush
```

---

## 🛣️ RUTAS Y MIDDLEWARE

### **Rutas Web** (`routes/web.php`)

```php
// ========== RUTAS PÚBLICAS ==========
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/info', function () {
    return view('info');
})->name('info');

// ========== RUTAS AUTENTICADAS ==========
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Productos
    Route::get('/catalogo', [ProductoController::class, 'index'])->name('catalogo');
    Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('producto.detalle');
    
    // Carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/actualizar/{item}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/{item}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    
    // Pedidos
    Route::get('/checkout', [PedidoController::class, 'checkout'])->name('checkout');
    Route::post('/pedido/crear', [PedidoController::class, 'crear'])->name('pedido.crear');
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos');
    Route::get('/pedido/{id}', [PedidoController::class, 'show'])->name('pedido.detalle');
    
    // Perfil
    Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');
    Route::put('/perfil/actualizar', [UsuarioController::class, 'actualizar'])->name('perfil.actualizar');
    
    // Mensajería
    Route::get('/mensajeria', [MensajeController::class, 'index'])->name('mensajeria');
    Route::post('/mensajeria/enviar', [MensajeController::class, 'enviar'])->name('mensajeria.enviar');
    
    // Incidencias
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias');
    Route::post('/incidencias/crear', [IncidenciaController::class, 'crear'])->name('incidencias.crear');
    
    // Entorno 3D
    Route::get('/entorno', function () {
        return view('entorno');
    })->name('entorno');
});

// ========== RUTAS ADMINISTRADOR ==========
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/main', [AdminController::class, 'main'])->name('main');
    
    // Usuarios
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/usuarios/crear', [AdminController::class, 'crearUsuario'])->name('usuarios.create');
    Route::post('/usuarios', [AdminController::class, 'guardarUsuario'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}/editar', [AdminController::class, 'editarUsuario'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [AdminController::class, 'actualizarUsuario'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [AdminController::class, 'eliminarUsuario'])->name('usuarios.destroy');
    
    // Pedidos
    Route::get('/pedidos', [AdminController::class, 'pedidos'])->name('pedidos.index');
    Route::get('/pedidos/{id}', [AdminController::class, 'mostrarPedido'])->name('pedidos.show');
    Route::patch('/pedidos/{id}/estado', [AdminController::class, 'cambiarEstadoPedido'])->name('pedidos.cambiarEstado');
    
    // Productos
    Route::get('/productos', [ProductoController::class, 'adminIndex'])->name('productos.index');
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});
```

**Explicación de middlewares:**
- `auth` - Verifica que el usuario esté autenticado
- `verified` - Verifica que el email esté verificado
- `role:admin` - Middleware personalizado que verifica el rol

---

### **Rutas API** (`routes/api.php`)

```php
Route::middleware('auth:sanctum')->group(function () {
    
    // Usuario actual
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Productos API
    Route::apiResource('productos', Api\ProductoController::class);
    
    // Carrito API
    Route::apiResource('carrito', Api\CarritoController::class);
    
    // Pedidos API
    Route::apiResource('pedidos', Api\PedidoController::class);
});
```

**Nota:** `apiResource` crea automáticamente las rutas:
- `GET /api/productos` - index
- `POST /api/productos` - store
- `GET /api/productos/{id}` - show
- `PUT /api/productos/{id}` - update
- `DELETE /api/productos/{id}` - destroy

---

## ✅ VALIDACIONES Y FORM REQUESTS

### **ProductoRequest** (`app/Http/Requests/ProductoRequest.php`)

**Propósito:** Validar datos de productos.

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.max' => 'El nombre no puede superar 255 caracteres',
            'descripcion.required' => 'La descripción es obligatoria',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio debe ser un número válido',
            'precio.min' => 'El precio no puede ser negativo',
            'stock.required' => 'El stock es obligatorio',
            'stock.integer' => 'El stock debe ser un número entero',
            'stock.min' => 'El stock no puede ser negativo',
            'categoria.required' => 'La categoría es obligatoria',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif',
            'imagen.max' => 'La imagen no puede superar 2MB',
        ];
    }
}
```

**Uso en controlador:**
```php
public function store(ProductoRequest $request)
{
    // Los datos ya están validados
    $validated = $request->validated();
    
    // Procesar...
}
```

---

## 🔌 API REST

### **ProductoController API** (`app/Http/Controllers/Api/ProductoController.php`)

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * GET /api/productos
     * Lista todos los productos
     */
    public function index()
    {
        $productos = Producto::all();
        
        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }
    
    /**
     * GET /api/productos/{id}
     * Muestra un producto específico
     */
    public function show($id)
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $producto
        ]);
    }
    
    /**
     * POST /api/productos
     * Crea un nuevo producto
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required|string',
        ]);
        
        $producto = Producto::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Producto creado',
            'data' => $producto
        ], 201);
    }
    
    /**
     * PUT /api/productos/{id}
     * Actualiza un producto
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }
        
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'precio' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'categoria' => 'sometimes|string',
        ]);
        
        $producto->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado',
            'data' => $producto
        ]);
    }
    
    /**
     * DELETE /api/productos/{id}
     * Elimina un producto
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);
        
        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }
        
        $producto->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado'
        ]);
    }
}
```

**Ejemplo de uso con Postman:**

```bash
# 1. Obtener token (Login)
POST http://tu-dominio/api/login
Body: {
    "email": "usuario@example.com",
    "password": "password"
}
Response: {
    "token": "1|xyz123abc..."
}

# 2. Listar productos
GET http://tu-dominio/api/productos
Headers: 
    Authorization: Bearer 1|xyz123abc...
Response: {
    "success": true,
    "data": [
        {
            "id": 1,
            "nombre": "Sofá Moderno",
            "precio": 599.99,
            "stock": 10
        }
    ]
}

# 3. Crear producto
POST http://tu-dominio/api/productos
Headers:
    Authorization: Bearer 1|xyz123abc...
    Content-Type: application/json
Body: {
    "nombre": "Mesa de Centro",
    "descripcion": "Mesa moderna de madera",
    "precio": 199.99,
    "stock": 5,
    "categoria": "Muebles"
}
```

---

## 🔐 AUTENTICACIÓN Y ROLES

### **Configuración Fortify** (`app/Providers/FortifyServiceProvider.php`)

```php
<?php

namespace App\Providers;

use Laravel\Fortify\Fortify;
use Illuminate\Support\ServiceProvider;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Vistas personalizadas
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        // Autenticación de 2 factores
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });
    }
}
```

### **Sistema de Roles**

**Seeder de Roles** (`database/seeders/RolSeeder.php`):

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        Rol::create([
            'nombre' => 'admin',
            'descripcion' => 'Administrador del sistema'
        ]);

        Rol::create([
            'nombre' => 'user',
            'descripcion' => 'Usuario normal'
        ]);
    }
}
```

**Asignar rol al registrarse** (en FortifyServiceProvider o UserObserver):

```php
// Después de crear usuario
$user = User::create([...]);
$rolUser = Rol::where('nombre', 'user')->first();
$user->roles()->attach($rolUser->id);
```

---

## 🔔 NOTIFICACIONES

### **PedidoCreadoNotification** (`app/Notifications/PedidoCreadoNotification.php`)

```php
<?php

namespace App\Notifications;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PedidoCreadoNotification extends Notification
{
    use Queueable;

    protected $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Canales por los que se enviará la notificación
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Representación del email
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pedido Creado - IADECORATE #' . $this->pedido->id)
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Tu pedido ha sido creado exitosamente.')
            ->line('**Número de Pedido:** #' . $this->pedido->id)
            ->line('**Total:** €' . number_format($this->pedido->total, 2))
            ->line('**Estado:** ' . ucfirst($this->pedido->estado))
            ->action('Ver Pedido', url('/pedidos/' . $this->pedido->id))
            ->line('Gracias por tu compra en IADECORATE!')
            ->salutation('Saludos, El equipo de IADECORATE');
    }

    /**
     * Representación en base de datos
     */
    public function toArray($notifiable): array
    {
        return [
            'pedido_id' => $this->pedido->id,
            'total' => $this->pedido->total,
            'mensaje' => 'Nuevo pedido #' . $this->pedido->id . ' creado',
        ];
    }
}
```

**Uso:**
```php
// En PedidoController::crear()
$user->notify(new PedidoCreadoNotification($pedido));
```

**Ver notificaciones en vista:**
```blade
@foreach(auth()->user()->unreadNotifications as $notification)
    <div class="notification">
        {{ $notification->data['mensaje'] }}
        <a href="{{ $notification->data['url'] ?? '#' }}">Ver</a>
    </div>
@endforeach
```

---

## 🏭 FACTORIES Y SEEDERS

### **ProductoFactory** (`database/factories/ProductoFactory.php`)

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $categorias = ['Muebles', 'Decoración', 'Iluminación', 'Textiles', 'Accesorios'];
        
        return [
            'nombre' => fake()->words(3, true),
            'descripcion' => fake()->paragraph(3),
            'precio' => fake()->randomFloat(2, 10, 500),
            'stock' => fake()->numberBetween(0, 100),
            'imagen' => 'productos/default.jpg',
            'categoria' => fake()->randomElement($categorias),
        ];
    }
}
```

### **ProductoSeeder** (`database/seeders/ProductoSeeder.php`)

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 50 productos aleatorios
        Producto::factory()->count(50)->create();
        
        // O crear productos específicos
        Producto::create([
            'nombre' => 'Sofá Moderno 3 Plazas',
            'descripcion' => 'Sofá moderno de 3 plazas con tapizado en tela gris',
            'precio' => 599.99,
            'stock' => 10,
            'imagen' => 'productos/sofa-moderno.jpg',
            'categoria' => 'Muebles',
        ]);
        
        Producto::create([
            'nombre' => 'Lámpara de Pie LED',
            'descripcion' => 'Lámpara de pie moderna con luz LED regulable',
            'precio' => 89.99,
            'stock' => 25,
            'imagen' => 'productos/lampara-pie.jpg',
            'categoria' => 'Iluminación',
        ]);
    }
}
```

### **DatabaseSeeder Principal** (`database/seeders/DatabaseSeeder.php`)

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            UserSeeder::class,
            ProductoSeeder::class,
            PreguntaFrecuenteSeeder::class,
        ]);
    }
}
```

**Ejecutar seeders:**
```bash
php artisan db:seed
# O seeder específico
php artisan db:seed --class=ProductoSeeder
```

---

## 📥 INSTALACIÓN Y CONFIGURACIÓN

### **Requisitos Previos**

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js y NPM

### **Paso 1: Clonar el Proyecto**

```bash
cd /opt/lampp/htdocs/iadecorate
git clone [url-repo] php-iadecorate
cd php-iadecorate
```

### **Paso 2: Instalar Dependencias**

```bash
# Dependencias de PHP
composer install

# Dependencias de JavaScript
npm install
```

### **Paso 3: Configurar Entorno**

```bash
# Copiar archivo de entorno
cp .env.example .env

# Generar key de aplicación
php artisan key:generate
```

### **Paso 4: Configurar Base de Datos**

Editar `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iadecorate_db
DB_USERNAME=root
DB_PASSWORD=

APP_URL=http://localhost/iadecorate/php-iadecorate/public
```

### **Paso 5: Configurar Email**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### **Paso 6: Migrar Base de Datos**

```bash
# Crear tablas
php artisan migrate

# Llenar con datos de prueba
php artisan db:seed
```

### **Paso 7: Crear Enlace Simbólico para Storage**

```bash
php artisan storage:link
```

### **Paso 8: Compilar Assets**

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### **Paso 9: Iniciar Servidor**

```bash
# Opción 1: Artisan serve
php artisan serve

# Opción 2: XAMPP/LAMPP
# Acceder a: http://localhost/iadecorate/php-iadecorate/public
```

### **Paso 10: Crear Usuario Administrador**

```bash
php artisan tinker
>>> $user = User::create(['name' => 'Admin', 'email' => 'admin@iadecorate.com', 'password' => Hash::make('Admin123!')]);
>>> $admin = Rol::where('nombre', 'admin')->first();
>>> $user->roles()->attach($admin->id);
>>> exit
```

---

## 🎓 RESUMEN DE TECNOLOGÍAS USADAS

### **Backend:**
- **Laravel 11** - Framework principal
- **Eloquent ORM** - Manejo de base de datos
- **Fortify** - Autenticación
- **Sanctum** - API tokens
- **MySQL** - Base de datos

### **Frontend:**
- **Blade** - Motor de plantillas
- **Tailwind CSS** - Estilos
- **JavaScript Vanilla** - Interactividad
- **Font Awesome** - Iconos
- **AJAX** - Peticiones asíncronas

### **Características:**
- ✅ Relaciones 1:N y N:M
- ✅ Middleware personalizado (CheckRole)
- ✅ Factories para datos
- ✅ Control de acceso completo
- ✅ Componentes Blade
- ✅ Vistas personalizadas
- ✅ Form Requests con validaciones
- ✅ Subida de archivos
- ✅ API REST completa
- ✅ Roles de usuarios
- ✅ CRUD de usuarios (admin)
- ✅ Recuperar contraseña
- ✅ Verificación de email
- ✅ Notificaciones (email + database)
- ✅ 2FA opcional

### **Vistas (NO Livewire):**
- Todas las vistas son **Blade tradicionales**
- JavaScript vanilla para interactividad
- Sin componentes Livewire en el proyecto actual

---

## 📞 CONTACTO Y SOPORTE

Si tienes dudas sobre alguna parte del proyecto:

1. Revisa este README completo
2. Consulta la documentación de Laravel: https://laravel.com/docs
3. Revisa los comentarios en el código fuente

---

## 🎉 CONCLUSIÓN

Has completado un proyecto Laravel completo con **TODOS los requisitos del profesor**:

✅ Relaciones de BD (1:N y N:M)  
✅ Middleware personalizado  
✅ Factories  
✅ Control de usuarios  
✅ Componentes Blade  
✅ Vistas personalizadas  
✅ Validaciones con Form Requests  
✅ Subida de archivos + CRUD  
✅ API REST  
✅ Roles de usuarios  
✅ Recuperar contraseña  
✅ Verificación de email  
✅ Notificaciones  

**¡Proyecto completo y funcional!** 🚀

---

**Fecha de creación:** Febrero 2026  
**Framework:** Laravel 11  
**Autor:** IADECORATE Team
