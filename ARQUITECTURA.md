# 🏗️ ARQUITECTURA DEL PROYECTO iADecorate

## 📐 DIAGRAMA DE ARQUITECTURA MVC

```
┌─────────────────────────────────────────────────────────────────┐
│                         NAVEGADOR (Cliente)                      │
│  [HTML] [CSS] [JavaScript] [AJAX] [Blade Templates]             │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             │ HTTP Request
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                         LARAVEL ROUTES                           │
│  • web.php         → Rutas web con sesión                       │
│  • api.php         → API REST (JSON)                            │
│  • settings.php    → Configuración Livewire                     │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             │ Route → Controller
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                          MIDDLEWARE                              │
│  • auth            → Verificar autenticación                    │
│  • verified        → Verificar email verificado                 │
│  • role:admin      → Verificar rol de administrador             │
│  • csrf            → Protección CSRF                            │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             │ Pass middleware
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                        CONTROLADORES                             │
│                                                                  │
│  ProductoController     CarritoController    PedidoController   │
│  ├─ index()            ├─ index()            ├─ index()         │
│  ├─ show()             ├─ agregar()          ├─ show()          │
│  ├─ create()           ├─ eliminar()         ├─ checkout()      │
│  ├─ store()            └─ actualizar()       └─ crear()         │
│  ├─ edit()                                                      │
│  ├─ update()           MensajeController     AdminController    │
│  └─ destroy()          ├─ index()            ├─ main()          │
│                        ├─ enviar()           ├─ usuarios()      │
│  UsuarioController     └─ obtenerNuevos()    ├─ pedidos()       │
│  ├─ perfil()                                 └─ productos()     │
│  └─ actualizar()       IncidenciaController                     │
│                        ├─ index()                               │
│                        └─ crear()                               │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             │ Query/Update
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                        MODELOS ELOQUENT                          │
│                                                                  │
│  User                 Producto              Carrito             │
│  • id                 • id                  • id                │
│  • name               • nombre              • user_id           │
│  • email              • descripcion         • producto_id       │
│  • password           • precio              • cantidad          │
│  • roles()            • stock                                   │
│  • pedidos()          • imagen              Mensaje             │
│  • mensajes()         • carritos()          • id                │
│                       • detalles()          • remitente_id      │
│  Pedido                                     • destinatario_id   │
│  • id                 DetallePedido         • contenido         │
│  • user_id            • id                  • leido             │
│  • total              • pedido_id                               │
│  • estado             • producto_id         Incidencia          │
│  • direccion_envio    • cantidad            • id                │
│  • usuario()          • precio_unitario     • user_id           │
│  • detalles()         • pedido()            • asunto            │
│                       • producto()          • descripcion       │
│  Rol                                        • estado            │
│  • id                 PreguntaFrecuente     • prioridad         │
│  • nombre             • id                                      │
│  • descripcion        • pregunta                                │
│  • usuarios()         • respuesta                               │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             │ SQL Queries
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                      BASE DE DATOS (MySQL)                       │
│  [users] [productos] [carritos] [pedidos] [detalle_pedidos]    │
│  [mensajes] [incidencias] [roles] [role_user] [FAQs]           │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔄 FLUJO DE DATOS: REALIZAR UNA COMPRA

```
┌───────────┐
│  CLIENTE  │
└─────┬─────┘
      │ 1. Hace login
      ▼
┌──────────────────┐
│  /login (POST)   │ ──→ Laravel Fortify
└─────┬────────────┘     • Valida credenciales
      │                  • Crea sesión
      │ 2. Autenticado correctamente
      ▼
┌──────────────────────────┐
│  GET /catalogo           │
│  ProductoController@index│
└─────┬────────────────────┘
      │ 3. Consulta productos disponibles
      ▼
┌──────────────────────────┐
│  Modelo: Producto        │
│  Producto::where(        │
│    'stock', '>', 0       │
│  )->get()                │
└─────┬────────────────────┘
      │ 4. Retorna productos
      ▼
┌──────────────────────────┐
│  Vista: cliente.catalogo │ ──→ Muestra productos al cliente
└─────┬────────────────────┘
      │ 5. Cliente selecciona producto
      ▼
┌──────────────────────────┐
│  GET /producto/{id}      │
│  ProductoController@show │
└─────┬────────────────────┘
      │ 6. Consulta producto específico
      ▼
┌──────────────────────────┐
│  Producto::findOrFail()  │
└─────┬────────────────────┘
      │ 7. Retorna detalle
      ▼
┌──────────────────────────┐
│  Vista: cliente.producto │ ──→ Muestra detalle + botón "Agregar"
└─────┬────────────────────┘
      │ 8. Cliente hace clic en "Agregar al carrito"
      ▼
┌─────────────────────────────┐
│  POST /carrito/agregar/{id} │
│  CarritoController@agregar  │
└─────┬───────────────────────┘
      │ 9. Valida stock disponible
      ▼
┌────────────────────────────┐
│  Carrito::create([        │
│    'user_id' => auth()->id│
│    'producto_id' => $id   │
│    'cantidad' => 1        │
│  ])                       │
└─────┬──────────────────────┘
      │ 10. Producto agregado al carrito
      ▼
┌──────────────────────────┐
│  Redirect → /carrito     │
└─────┬────────────────────┘
      │ 11. Muestra carrito
      ▼
┌──────────────────────────┐
│  GET /carrito            │
│  CarritoController@index │
└─────┬────────────────────┘
      │ 12. Consulta items del carrito
      ▼
┌────────────────────────────┐
│  Carrito::where(          │
│    'user_id', auth()->id  │
│  )->with('producto')->get()│
└─────┬──────────────────────┘
      │ 13. Calcula subtotal + envío
      ▼
┌──────────────────────────┐
│  Vista: cliente.carrito  │ ──→ Muestra items + total + botón "Checkout"
└─────┬────────────────────┘
      │ 14. Cliente hace clic en "Finalizar compra"
      ▼
┌──────────────────────────┐
│  GET /checkout           │
│  PedidoController@       │
│       checkout           │
└─────┬────────────────────┘
      │ 15. Muestra resumen + formulario de envío
      ▼
┌──────────────────────────┐
│  Vista: cliente.checkout │ ──→ Confirmar dirección y datos
└─────┬────────────────────┘
      │ 16. Cliente confirma y envía formulario
      ▼
┌──────────────────────────┐
│  POST /pedido/crear      │
│  PedidoController@crear  │
└─────┬────────────────────┘
      │ 17. Crea el pedido
      ▼
┌────────────────────────────┐
│  Pedido::create([         │
│    'user_id' => auth()->id│
│    'total' => $total      │
│    'estado' => 'pendiente'│
│    'direccion_envio' => ..│
│  ])                       │
└─────┬──────────────────────┘
      │ 18. Crea detalles del pedido
      ▼
┌────────────────────────────┐
│  DetallePedido::create([  │
│    'pedido_id' => $pedido │
│    'producto_id' => ..    │
│    'cantidad' => ..       │
│    'precio_unitario' => ..│
│  ])                       │
└─────┬──────────────────────┘
      │ 19. Reduce stock de productos
      ▼
┌────────────────────────────┐
│  $producto->decrement(    │
│    'stock', $cantidad     │
│  )                        │
└─────┬──────────────────────┘
      │ 20. Vacía el carrito
      ▼
┌────────────────────────────┐
│  Carrito::where(          │
│    'user_id', auth()->id  │
│  )->delete()              │
└─────┬──────────────────────┘
      │ 21. Envía notificaciones
      ▼
┌────────────────────────────┐
│  PedidoCreadoNotification │ ──→ Email al cliente + admin
└─────┬──────────────────────┘
      │ 22. Redirect a detalle del pedido
      ▼
┌──────────────────────────┐
│  Redirect → /pedido/{id} │
└─────┬────────────────────┘
      │ 23. Muestra confirmación
      ▼
┌──────────────────────────────┐
│  Vista: cliente.pedido-      │
│         detalle              │ ──→ ✅ Pedido confirmado!
└──────────────────────────────┘
```

---

## 🔐 FLUJO DE AUTENTICACIÓN Y AUTORIZACIÓN

```
┌──────────────┐
│   USUARIO    │
└──────┬───────┘
       │ Intenta acceder a ruta protegida
       ▼
┌────────────────────────────┐
│  Middleware: auth          │
│  ¿Usuario autenticado?     │
└──────┬────────────────┬────┘
       │ NO             │ SÍ
       ▼                ▼
   Redirect       ┌────────────────────────────┐
   → /login       │  Middleware: verified      │
                  │  ¿Email verificado?        │
                  └──────┬────────────────┬────┘
                         │ NO             │ SÍ
                         ▼                ▼
                   Redirect       ┌────────────────────────────┐
                   → /verify      │  Middleware: role:admin    │
                                  │  ¿Tiene rol requerido?     │
                                  └──────┬────────────────┬────┘
                                         │ NO             │ SÍ
                                         ▼                ▼
                                   Error 403       ┌──────────────┐
                                   Forbidden       │ CONTROLADOR  │
                                                   │ Ejecuta lógica│
                                                   └──────┬───────┘
                                                          │
                                                          ▼
                                                   ┌──────────────┐
                                                   │    VISTA     │
                                                   └──────────────┘
```

---

## 🗄️ ESQUEMA DE BASE DE DATOS

```
┌──────────────────────┐
│       users          │
├──────────────────────┤
│ id                   │←────────┐
│ name                 │         │
│ email                │         │
│ password             │         │
│ apellidos            │         │
│ telefono             │         │
│ direccion            │         │
│ ciudad               │         │
│ codigo_postal        │         │
│ fecha_nacimiento     │         │
│ email_verified_at    │         │
└──────────────────────┘         │
         │ 1                     │
         │                       │
         │ N                     │ 1
         ▼                       │
┌──────────────────────┐         │
│      pedidos         │         │
├──────────────────────┤         │
│ id                   │         │
│ user_id              │─────────┘
│ total                │
│ estado               │
│ direccion_envio      │
│ ciudad               │
│ codigo_postal        │
└──────────────────────┘
         │ 1
         │
         │ N
         ▼
┌──────────────────────┐         ┌──────────────────────┐
│  detalle_pedidos     │    N    │     productos        │
├──────────────────────┤←────────│──────────────────────┤
│ id                   │    1    │ id                   │
│ pedido_id            │         │ nombre               │
│ producto_id          │─────────│→descripcion          │
│ cantidad             │         │ precio               │
│ precio_unitario      │         │ stock                │
└──────────────────────┘         │ imagen               │
                                 └──────────────────────┘
                                          │ 1
                                          │
                                          │ N
                                          ▼
┌──────────────────────┐         ┌──────────────────────┐
│      carritos        │         │      mensajes        │
├──────────────────────┤         ├──────────────────────┤
│ id                   │         │ id                   │
│ user_id              │         │ remitente_id         │
│ producto_id          │         │ destinatario_id      │
│ cantidad             │         │ contenido            │
└──────────────────────┘         │ leido                │
                                 └──────────────────────┘

┌──────────────────────┐         ┌──────────────────────┐
│    incidencias       │         │       roles          │
├──────────────────────┤         ├──────────────────────┤
│ id                   │         │ id                   │
│ user_id              │         │ nombre               │
│ asunto               │         │ descripcion          │
│ descripcion          │         └──────────────────────┘
│ estado               │                  │ N
│ prioridad            │                  │
└──────────────────────┘                  │ N
                                          ▼
┌──────────────────────┐         ┌──────────────────────┐
│ preguntas_frecuentes │         │     role_user        │
├──────────────────────┤         ├──────────────────────┤
│ id                   │         │ user_id              │
│ pregunta             │         │ role_id              │
│ respuesta            │         └──────────────────────┘
└──────────────────────┘           (Tabla pivot)
```

---

## 🎭 SISTEMA DE ROLES

```
┌────────────────────────────────────────┐
│            ROLES DEL SISTEMA           │
└────────────────────────────────────────┘
        │
        ├──→ ADMIN (Administrador)
        │    ├─ Acceso total al sistema
        │    ├─ Gestiona usuarios
        │    ├─ Gestiona productos
        │    ├─ Gestiona pedidos
        │    ├─ Cambia estados de pedidos
        │    ├─ Responde mensajes
        │    └─ Resuelve incidencias
        │
        └──→ CLIENTE (Usuario normal)
             ├─ Ve catálogo
             ├─ Compra productos
             ├─ Ve su historial de pedidos
             ├─ Edita su perfil
             ├─ Envía mensajes a admin
             └─ Crea incidencias

Verificación en código:
┌──────────────────────────────────────┐
│ // En rutas (web.php)                │
│ Route::middleware([                  │
│   'auth',                            │
│   'verified',                        │
│   'role:admin'                       │
│ ])->group(...)                       │
│                                      │
│ // En modelos (User.php)             │
│ public function hasRole($role) {     │
│   return $this->roles()              │
│     ->where('nombre', $role)         │
│     ->exists();                      │
│ }                                    │
└──────────────────────────────────────┘
```

---

## 📨 SISTEMA DE NOTIFICACIONES

```
┌─────────────────────────────────────────────────────────────┐
│                   EVENTOS QUE GENERAN NOTIFICACIONES        │
└─────────────────────────────────────────────────────────────┘
          │
          ├──→ Pedido creado
          │    ├─ Notifica a: Cliente + Admin
          │    ├─ Clase: PedidoCreadoNotification
          │    └─ Canales: Email + Base de datos
          │
          ├──→ Mensaje recibido
          │    ├─ Notifica a: Destinatario
          │    ├─ Clase: MensajeRecibidoNotification
          │    └─ Canales: Email + Base de datos
          │
          ├──→ Estado de pedido cambiado
          │    ├─ Notifica a: Cliente
          │    └─ Canales: Email
          │
          └──→ Incidencia creada
               ├─ Notifica a: Admin
               └─ Canales: Email + Base de datos

Flujo de notificación:
┌─────────────┐
│   EVENTO    │ (Ej: Se crea un pedido)
└──────┬──────┘
       │
       ▼
┌───────────────────┐
│  NOTIFICATION     │
│  PedidoCreado     │
└──────┬────────────┘
       │
       ├──→ Email
       │    └─ Mail::send()
       │
       └──→ Base de datos
            └─ notifications table
```

---

## 🔄 CICLO DE VIDA DE UN PEDIDO

```
┌─────────────────────────────────────────────────────────────┐
│                 ESTADOS DE UN PEDIDO                        │
└─────────────────────────────────────────────────────────────┘

    ┌──────────────┐
    │  PENDIENTE   │  ← Estado inicial al crear el pedido
    └──────┬───────┘
           │ Admin cambia estado
           ▼
    ┌──────────────┐
    │  PROCESANDO  │  ← Pedido en preparación
    └──────┬───────┘
           │ Admin cambia estado
           ▼
    ┌──────────────┐
    │   ENVIADO    │  ← Pedido en camino al cliente
    └──────┬───────┘
           │ Admin cambia estado
           ▼
    ┌──────────────┐
    │  ENTREGADO   │  ← Pedido completado ✅
    └──────────────┘

    Alternativamente, en cualquier momento:
    
    ┌──────────────┐
    │  CANCELADO   │  ← Pedido cancelado ❌
    └──────────────┘

Admin puede cambiar el estado desde:
/admin/pedidos/{id} → PATCH /admin/pedidos/{id}/estado
```

---

## 🎨 ARQUITECTURA DE VISTAS

```
┌────────────────────────────────────────────────────────────────┐
│                     SISTEMA DE VISTAS BLADE                    │
└────────────────────────────────────────────────────────────────┘

resources/views/
│
├─ layouts/
│  ├─ app.blade.php          ← Layout principal para usuarios autenticados
│  └─ guest.blade.php        ← Layout para usuarios no autenticados
│
├─ components/               ← Componentes reutilizables
│  ├─ navbar.blade.php
│  ├─ footer.blade.php
│  ├─ auth-header.blade.php
│  └─ desktop-user-menu.blade.php
│
├─ partials/                 ← Fragmentos de vistas
│  ├─ alert.blade.php
│  └─ form-errors.blade.php
│
├─ publico/                  ← Vistas públicas (sin autenticación)
│  ├─ index.blade.php        ← @extends('layouts.guest')
│  └─ info.blade.php         ← @extends('layouts.guest')
│
├─ cliente/                  ← Vistas de clientes autenticados
│  ├─ catalogo.blade.php     ← @extends('layouts.app')
│  ├─ producto.blade.php     ← @extends('layouts.app')
│  ├─ carrito.blade.php      ← @extends('layouts.app')
│  ├─ checkout.blade.php     ← @extends('layouts.app')
│  ├─ pedidos.blade.php      ← @extends('layouts.app')
│  ├─ pedido-detalle.blade...← @extends('layouts.app')
│  ├─ perfil.blade.php       ← @extends('layouts.app')
│  ├─ mensajeria.blade.php   ← @extends('layouts.app')
│  ├─ incidencias.blade.php  ← @extends('layouts.app')
│  └─ entorno.blade.php      ← @extends('layouts.app')
│
└─ admin/                    ← Vistas de administrador
   ├─ main.blade.php         ← @extends('layouts.app')
   ├─ usuarios/
   │  ├─ index.blade.php
   │  ├─ create.blade.php
   │  └─ edit.blade.php
   ├─ pedidos/
   │  ├─ index.blade.php
   │  └─ show.blade.php
   └─ productos/
      ├─ index.blade.php
      ├─ create.blade.php
      └─ edit.blade.php

Herencia de plantillas:
┌─────────────────┐
│  layouts.app    │  ← Define estructura general
└────────┬────────┘
         │ @extends
         ▼
┌─────────────────┐
│  @section       │
│  'content'      │  ← Cada vista define su contenido
└─────────────────┘
```

---

## 🔌 API REST - ARQUITECTURA

```
┌────────────────────────────────────────────────────────────────┐
│                        API REST ENDPOINTS                      │
└────────────────────────────────────────────────────────────────┘

Cliente Frontend/Mobile
      │
      │ HTTP Request (JSON)
      ▼
┌──────────────────────────┐
│    routes/api.php        │
│    Prefijo: /api         │
└──────────┬───────────────┘
           │
           ├─→ PÚBLICAS (sin auth)
           │   ├─ GET /api/productos
           │   └─ GET /api/productos/{id}
           │
           └─→ PROTEGIDAS (requiere token Sanctum)
               ├─ POST /api/productos
               ├─ PUT /api/productos/{id}
               ├─ DELETE /api/productos/{id}
               ├─ /api/carrito (CRUD)
               └─ /api/pedidos (CRUD)
      │
      │ Pasa por Middleware
      ▼
┌──────────────────────────┐
│   auth:sanctum           │  ← Verifica token de autenticación
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────┐
│   Api\Controllers        │
│   • ProductoController   │
│   • CarritoController    │
│   • PedidoController     │
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────┐
│   Modelos Eloquent       │
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────┐
│   Base de datos          │
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────┐
│   Response JSON          │
│   { "data": [...] }      │
└──────────────────────────┘
```

---

## 📊 MONITOREO Y LOGS

```
┌────────────────────────────────────────────────────────────────┐
│                    SISTEMA DE LOGS                             │
└────────────────────────────────────────────────────────────────┘

Ubicación: storage/logs/

├─ laravel.log              ← Log general de la aplicación
│  ├─ Errores PHP
│  ├─ Excepciones
│  ├─ Queries SQL (en debug)
│  └─ Mensajes personalizados (Log::info())
│
├─ Niveles de log:
│  ├─ EMERGENCY    → Sistema inutilizable
│  ├─ ALERT        → Acción inmediata requerida
│  ├─ CRITICAL     → Condición crítica
│  ├─ ERROR        → Error que no detiene la ejecución
│  ├─ WARNING      → Advertencia
│  ├─ NOTICE       → Notificación normal
│  ├─ INFO         → Información general
│  └─ DEBUG        → Información de depuración
│
└─ Configuración:
   config/logging.php
   • Canal: stack, single, daily
   • Nivel: debug, info, error
```

---

## ⚡ OPTIMIZACIONES APLICABLES

```
┌────────────────────────────────────────────────────────────────┐
│                    MEJORAS DE RENDIMIENTO                      │
└────────────────────────────────────────────────────────────────┘

1. CACHÉ
   ├─ Cache de configuración:    php artisan config:cache
   ├─ Cache de rutas:            php artisan route:cache
   ├─ Cache de vistas:           php artisan view:cache
   └─ Cache de consultas:        Cache::remember()

2. EAGER LOADING (evitar N+1)
   ├─ $pedidos = Pedido::with('usuario', 'detalles.producto')->get();
   └─ En lugar de: $pedido->usuario (lazy loading)

3. PAGINACIÓN
   ├─ $productos = Producto::paginate(15);
   └─ Evita cargar todos los registros

4. ÍNDICES EN BASE DE DATOS
   ├─ user_id en pedidos
   ├─ producto_id en carritos
   └─ estado en pedidos

5. QUEUE JOBS (para tareas pesadas)
   ├─ Envío de emails
   ├─ Generación de reportes
   └─ Procesamiento de imágenes

6. COMPRESIÓN DE ASSETS
   ├─ npm run build (producción)
   └─ Minificación de CSS/JS
```

---

**Fecha de creación:** 20 de Febrero de 2026  
**Versión Laravel:** 11.x  
**Proyecto:** iADecorate
