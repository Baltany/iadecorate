# 🗺️ MAPA VISUAL DEL PROYECTO - REFERENCIA RÁPIDA

## 📍 DONDE MIRAR SEGÚN LA PREGUNTA

```
┌─────────────────────────────────────────────────────────────────┐
│         "¿Cómo has hecho la API REST?"                          │
└─────────────────────────────────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  routes/api.php                     │  → Define endpoints (/api/productos)
         └─────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  app/Http/Controllers/Api/          │  → Lógica de la API
         │  • ProductoController.php           │
         │  • CarritoController.php            │
         │  • PedidoController.php             │
         └─────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  app/Models/Producto.php            │  → Datos de la BD
         └─────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  Devuelve JSON                      │
         │  { "data": [...] }                  │
         └─────────────────────────────────────┘

═══════════════════════════════════════════════════════════════════

┌─────────────────────────────────────────────────────────────────┐
│         "¿Cómo funciona el login/registro?"                     │
└─────────────────────────────────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  Laravel Fortify (paquete oficial)  │  → Sistema base
         │  config/fortify.php                 │
         └─────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  app/Http/Controllers/Auth/         │  → Personalizaciones
         │  RegisterController.php             │
         └─────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  app/Http/Requests/LoginRequest.php │  → Validaciones
         └─────────────────────────────────────┘

         💡 IMPORTANTE: Laravel Fortify hace el trabajo pesado,
            tú solo personalizas algunos comportamientos

═══════════════════════════════════════════════════════════════════

┌─────────────────────────────────────────────────────────────────┐
│         "¿Para qué son los Requests?"                           │
└─────────────────────────────────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  app/Http/Requests/                 │
         │  • ProductoRequest.php              │  → Valida productos
         │  • CarritoRequest.php               │  → Valida carrito
         │  • PedidoRequest.php                │  → Valida pedidos
         │  • LoginRequest.php                 │  → Valida login
         └─────────────────────────────────────┘
                               ↓
         ┌─────────────────────────────────────┐
         │  Separan la VALIDACIÓN del          │
         │  controlador para código más limpio │
         └─────────────────────────────────────┘

         ANTES (mal):
         Controller → valida + guarda (todo mezclado)
         
         AHORA (bien):
         Request → valida
         Controller → solo guarda

═══════════════════════════════════════════════════════════════════

┌─────────────────────────────────────────────────────────────────┐
│         "¿Cómo funciona el catálogo/carrito/pedidos?"          │
└─────────────────────────────────────────────────────────────────┘
                               ↓
    1. RUTA (routes/web.php)
         ┌─────────────────────────────────────┐
         │  GET /catalogo → ProductoController │
         └─────────────────────────────────────┘
                               ↓
    2. CONTROLADOR (app/Http/Controllers/)
         ┌─────────────────────────────────────┐
         │  ProductoController@index()         │
         │  • consulta productos               │
         │  • aplica filtros                   │
         └─────────────────────────────────────┘
                               ↓
    3. MODELO (app/Models/)
         ┌─────────────────────────────────────┐
         │  Producto::where('stock','>',0)     │
         │            ->get()                  │
         └─────────────────────────────────────┘
                               ↓
    4. VISTA (resources/views/cliente/)
         ┌─────────────────────────────────────┐
         │  catalogo.blade.php                 │
         │  • muestra productos                │
         │  • botones agregar                  │
         └─────────────────────────────────────┘

═══════════════════════════════════════════════════════════════════

┌─────────────────────────────────────────────────────────────────┐
│         "¿Cómo has organizado las vistas?"                      │
└─────────────────────────────────────────────────────────────────┘
                               ↓
         resources/views/
              │
              ├─ publico/        → Sin login
              │  ├─ index.blade.php
              │  └─ info.blade.php
              │
              ├─ cliente/        → Con login
              │  ├─ catalogo.blade.php
              │  ├─ carrito.blade.php
              │  ├─ checkout.blade.php
              │  ├─ pedidos.blade.php
              │  ├─ perfil.blade.php
              │  └─ ...
              │
              └─ admin/          → Solo admin
                 ├─ main.blade.php
                 ├─ usuarios/
                 ├─ productos/
                 └─ pedidos/

═══════════════════════════════════════════════════════════════════

┌─────────────────────────────────────────────────────────────────┐
│         "¿Cómo funciona la seguridad?"                          │
└─────────────────────────────────────────────────────────────────┘
                               ↓
    NIVEL 1: Middleware de Laravel
         ┌─────────────────────────────────────┐
         │  'auth' → ¿Usuario logueado?        │
         │  'verified' → ¿Email verificado?    │
         └─────────────────────────────────────┘
                               ↓
    NIVEL 2: Middleware personalizado
         ┌─────────────────────────────────────┐
         │  'role:admin'                       │
         │  app/Http/Middleware/CheckRole.php  │
         └─────────────────────────────────────┘
                               ↓
    NIVEL 3: Form Requests
         ┌─────────────────────────────────────┐
         │  authorize() → ¿Tiene permiso?      │
         │  rules() → ¿Datos válidos?          │
         └─────────────────────────────────────┘
                               ↓
    NIVEL 4: CSRF automático
         ┌─────────────────────────────────────┐
         │  @csrf en formularios Blade         │
         └─────────────────────────────────────┘

═══════════════════════════════════════════════════════════════════
```

## 🎯 TABLA ULTRA-RÁPIDA

| SI TE PREGUNTA... | ABRIR ESTO | Y DECIR ESTO |
|-------------------|------------|--------------|
| **API REST** | `routes/api.php` + `Controllers/Api/` | "Endpoints REST con Sanctum que devuelven JSON" |
| **Login** | `config/fortify.php` | "Laravel Fortify con personalizaciones en Auth/" |
| **Validación** | `Http/Requests/ProductoRequest.php` | "Form Requests separan validación del controlador" |
| **Base de datos** | `Models/Producto.php` | "Eloquent ORM con relaciones definidas" |
| **Vistas** | `views/cliente/catalogo.blade.php` | "Blade con vistas organizadas por tipo de usuario" |
| **Rutas** | `routes/web.php` línea 31 | "Rutas protegidas con middleware auth y role" |
| **Seguridad** | `Middleware/CheckRole.php` | "Middleware personalizado verifica roles de usuario" |

---

## 🔄 FLUJO COMPLETO DE UNA COMPRA (EJEMPLO)

```
USUARIO
   │
   │ 1️⃣ Accede a /catalogo
   ▼
┌─────────────────────┐
│ routes/web.php      │ Route::get('/catalogo', [ProductoController::class, 'index'])
└──────────┬──────────┘
           │ 2️⃣ Enruta a controlador
           ▼
┌─────────────────────┐
│ ProductoController  │ public function index() { ... }
│ @index()            │
└──────────┬──────────┘
           │ 3️⃣ Consulta BD
           ▼
┌─────────────────────┐
│ Producto::where()   │ Modelo Eloquent
│       ->get()       │
└──────────┬──────────┘
           │ 4️⃣ Retorna datos
           ▼
┌─────────────────────┐
│ catalogo.blade.php  │ Vista Blade muestra productos
└──────────┬──────────┘
           │ 5️⃣ Usuario hace clic "Agregar"
           ▼
┌─────────────────────┐
│ POST /carrito/      │ Formulario con @csrf
│      agregar/{id}   │
└──────────┬──────────┘
           │ 6️⃣ Middleware verifica auth
           ▼
┌─────────────────────┐
│ CarritoController   │ public function agregar() { ... }
│ @agregar()          │
└──────────┬──────────┘
           │ 7️⃣ Valida y guarda
           ▼
┌─────────────────────┐
│ Carrito::create()   │ Crea registro en tabla carritos
└──────────┬──────────┘
           │ 8️⃣ Redirect a /carrito
           ▼
┌─────────────────────┐
│ carrito.blade.php   │ Muestra carrito actualizado
└─────────────────────┘
```

---

## 📚 ESTRUCTURA DE ARCHIVOS CLAVE

```
php-iadecorate/
│
├── 🛣️ RUTAS
│   ├── routes/web.php          ← URLs web + endpoints
│   └── routes/api.php          ← URLs API REST
│
├── 🎮 CONTROLADORES
│   └── app/Http/Controllers/
│       ├── ProductoController.php       ← Catálogo + Admin productos
│       ├── CarritoController.php        ← Gestión carrito
│       ├── PedidoController.php         ← Pedidos + Checkout
│       ├── MensajeController.php        ← Chat/Mensajería
│       ├── IncidenciaController.php     ← Soporte
│       ├── UsuarioController.php        ← Perfil
│       ├── AdminController.php          ← Panel admin
│       ├── Auth/
│       │   └── RegisterController.php   ← Personaliza registro
│       └── Api/
│           ├── ProductoController.php   ← API productos
│           ├── CarritoController.php    ← API carrito
│           └── PedidoController.php     ← API pedidos
│
├── ✅ VALIDACIÓN
│   └── app/Http/Requests/
│       ├── ProductoRequest.php          ← Valida productos
│       ├── CarritoRequest.php           ← Valida carrito
│       ├── PedidoRequest.php            ← Valida pedidos
│       ├── LoginRequest.php             ← Valida login
│       └── ...
│
├── 🛡️ SEGURIDAD
│   └── app/Http/Middleware/
│       └── CheckRole.php                ← Verifica roles
│
├── 🗄️ MODELOS (Base de datos)
│   └── app/Models/
│       ├── User.php                     ← Usuarios
│       ├── Producto.php                 ← Productos
│       ├── Carrito.php                  ← Items del carrito
│       ├── Pedido.php                   ← Pedidos
│       ├── DetallePedido.php            ← Detalles de pedidos
│       ├── Mensaje.php                  ← Conversaciones
│       ├── Incidencia.php               ← Tickets
│       └── Rol.php                      ← Roles (admin/cliente)
│
└── 🎨 VISTAS (Frontend)
    └── resources/views/
        ├── publico/                     ← Sin login
        │   ├── index.blade.php
        │   └── info.blade.php
        ├── cliente/                     ← Con login
        │   ├── catalogo.blade.php
        │   ├── producto.blade.php
        │   ├── carrito.blade.php
        │   ├── checkout.blade.php
        │   ├── pedidos.blade.php
        │   ├── perfil.blade.php
        │   ├── mensajeria.blade.php
        │   └── incidencias.blade.php
        └── admin/                       ← Solo admin
            ├── main.blade.php
            ├── usuarios/ (index, create, edit)
            ├── productos/ (index, create, edit)
            └── pedidos/ (index, show)
```

---

## 💡 RESPUESTAS CORTAS Y DIRECTAS

### "¿Qué framework usas?"
> **Laravel 11.x**, un framework PHP que usa el patrón MVC.

### "¿Cómo gestionas la base de datos?"
> **Eloquent ORM** de Laravel. Cada tabla tiene un modelo en `app/Models/`.

### "¿Qué motor de plantillas usas?"
> **Blade**, el motor de Laravel. Uso `@extends`, `@section`, `@foreach`, etc.

### "¿Cómo proteges las rutas?"
> Con **middleware**: `auth` para autenticación, `verified` para email verificado, y `role:admin` personalizado para administradores.

### "¿Dónde validas los datos?"
> En **Form Requests** (`app/Http/Requests/`) que separan la validación del controlador.

### "¿Cómo funciona la API?"
> Controladores en `Api/` devuelven JSON. Uso **Laravel Sanctum** para autenticación con tokens.

### "¿Por qué Auth/ está separado?"
> Es **convención de Laravel** separar código de autenticación. Aunque uso **Fortify** que lo gestiona automáticamente.

### "¿Qué has programado tú vs Laravel?"
> **Laravel**: Estructura MVC, rutas, ORM, Blade, Fortify  
> **Yo**: Todos los controladores, modelos personalizados, vistas, lógica de negocio, sistema de roles

---

## 🎓 PALABRAS CLAVE PARA IMPRESIONAR

Usa estos términos cuando hables con el profesor:

- ✅ **Patrón MVC** (Modelo-Vista-Controlador)
- ✅ **Eloquent ORM** (para base de datos)
- ✅ **Blade Templates** (motor de plantillas)
- ✅ **Middleware** (filtros de seguridad)
- ✅ **Form Requests** (validación separada)
- ✅ **Laravel Fortify** (autenticación)
- ✅ **Laravel Sanctum** (API tokens)
- ✅ **RESTful API** (arquitectura API)
- ✅ **CRUD** (Create, Read, Update, Delete)
- ✅ **Migraciones** (estructura de BD)
- ✅ **Seeders** (datos de prueba)
- ✅ **Relaciones Eloquent** (1:N, N:M)
- ✅ **Protección CSRF**
- ✅ **Inyección de dependencias**

---

## 🚀 CONCLUSIÓN

### Estructura básica para responder CUALQUIER pregunta:

1. **Dónde está:** "El código está en `ruta/del/archivo.php`"
2. **Qué hace:** "Este archivo gestiona [funcionalidad]"
3. **Cómo funciona:** "Cuando el usuario [acción], se ejecuta [método] que [lógica]"
4. **Por qué así:** "He usado [técnica/patrón] porque [razón]"

### Ejemplo completo:

**P: "¿Cómo agregas productos al carrito?"**

**R:** 
> "El código está en `app/Http/Controllers/CarritoController.php`, método `agregar()`. 
> 
> Este controlador gestiona el carrito de compras. 
> 
> Cuando el usuario hace clic en 'Agregar al carrito' desde el catálogo, se envía un POST a `/carrito/agregar/{producto}`. El middleware `auth` verifica que está logueado, luego el método consulta si el producto tiene stock disponible con `Producto::find($id)`, y si hay stock crea un registro en la tabla `carritos` con `Carrito::create()` asociando el user_id, producto_id y cantidad.
> 
> He usado Eloquent ORM porque simplifica las consultas SQL y Laravel automáticamente gestiona las relaciones entre tablas."

---

**¡Con esto tienes TODO lo necesario para explicar tu proyecto al profesor!** 🎓✅
