# 🚀 Guía Completa: Backend Laravel para IA Decorate

## 📋 Pasos para crear el backend Laravel

### 1️⃣ Requisitos Previos

Antes de empezar, asegúrate de tener instalado:

- ✅ **PHP 8.1 o superior**
- ✅ **Composer** (gestor de dependencias de PHP)
- ✅ **MySQL 8.0** o **MariaDB** o **PHPMYADMIN**
- ✅ **Node.js y NPM** (opcional, para compilar assets)

#### Verificar instalaciones:

```bash
php -v          # Debe mostrar PHP 8.1 o superior
composer -v     # Debe mostrar Composer instalado
```

---

## 2️⃣ Instalación de Laravel

### Opción A: Crear proyecto desde cero

```bash
# Crear nuevo proyecto Laravel
composer create-project laravel/laravel ia-decorate-backend

# Entrar al directorio
cd ia-decorate-backend
```

### Opción B: Usar Laravel Installer (recomendado)

```bash
# Instalar Laravel Installer globalmente
composer global require laravel/installer

# Crear proyecto
laravel new ia-decorate-backend

# Entrar al directorio
cd ia-decorate-backend
```

--

### Paso 3: Configurar archivo .env

Edita el archivo `.env` en la raíz del proyecto:

```env
APP_NAME="IA Decorate"
APP_ENV=local
APP_KEY=base64:xxxxx  # Se genera automáticamente
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ia_decorate
DB_USERNAME=root
DB_PASSWORD=tu_contraseña_mysql

# Configuración de JWT
JWT_SECRET=  # Se generará después

# Configuración de correo (opcional por ahora)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@iadecorate.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 4️⃣ Instalar Dependencias Necesarias

```bash
# JWT para autenticación
composer require tymon/jwt-auth

# Para validación y helpers
composer require spatie/laravel-query-builder
```

---

## 5️⃣ Publicar Configuración de JWT

```bash
# Publicar configuración de JWT
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

# Generar secret key de JWT
php artisan jwt:secret
```

---

## 6️⃣ Crear las Migraciones

```bash
# Crear migración de usuarios (ya existe, la modificaremos)
# Crear migración de roles
php artisan make:migration create_roles_table

# Crear migración de role_user (tabla pivote)
php artisan make:migration create_role_user_table

# Crear migración de productos
php artisan make:migration create_productos_table

# Crear migración de carritos
php artisan make:migration create_carritos_table

# Crear migración de pedidos
php artisan make:migration create_pedidos_table

# Crear migración de detalle_pedidos
php artisan make:migration create_detalle_pedidos_table

# Crear migración de incidencias
php artisan make:migration create_incidencias_table

# Crear migración de mensajes
php artisan make:migration create_mensajes_table
```

---

## 7️⃣ Crear los Modelos

```bash
# Crear modelos
php artisan make:model Rol
php artisan make:model Producto
php artisan make:model Carrito
php artisan make:model Pedido
php artisan make:model DetallePedido
php artisan make:model Incidencia
php artisan make:model Mensaje
```

---

## 8️⃣ Crear los Controladores

```bash
# Controlador de autenticación
php artisan make:controller Http/Controllers/AuthController

# Controlador de productos
php artisan make:controller Http/Controllers/ProductoController --api

# Controlador de carrito
php artisan make:controller Http/Controllers/CarritoController --api

# Controlador de pedidos
php artisan make:controller Http/Controllers/PedidoController --api

# Controlador de usuarios (admin)
php artisan make:controller Http/Controllers/UsuarioController --api

# Controlador de incidencias
php artisan make:controller Http/Controllers/IncidenciaController --api

# Controlador de mensajes
php artisan make:controller Http/Controllers/MensajeController --api
```

---

## 9️⃣ Crear Requests para Validación

```bash
# Request para registro
php artisan make:request RegisterRequest

# Request para login
php artisan make:request LoginRequest

# Request para producto
php artisan make:request ProductoRequest

# Request para carrito
php artisan make:request CarritoRequest
```

---

## 🔟 Crear Seeders (datos de prueba)

```bash
# Seeder para roles
php artisan make:seeder RoleSeeder

# Seeder para usuario admin
php artisan make:seeder AdminSeeder

# Seeder para productos de ejemplo
php artisan make:seeder ProductoSeeder
```

---

## 1️⃣1️⃣ Ejecutar las Migraciones

```bash
# Ejecutar todas las migraciones
php artisan migrate

# Si hay errores, resetear y volver a ejecutar
php artisan migrate:fresh

# Ejecutar migraciones con seeders
php artisan migrate:fresh --seed
```

---

## 1️⃣2️⃣ Configurar CORS

```bash
# Publicar configuración de CORS
php artisan config:publish cors
```

Editar `config/cors.php`:

```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5500', 'http://127.0.0.1:5500'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```

---

## 1️⃣3️⃣ Configurar las Rutas API

Editar `routes/api.php` y añadir todas las rutas necesarias.

---

## 1️⃣4️⃣ Iniciar el Servidor

```bash
# Iniciar servidor de desarrollo
php artisan serve

# El servidor estará disponible en:
# http://localhost:8000
```

---

## 1️⃣5️⃣ Probar la API

### Con cURL:

```bash
# Registro
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Juan",
    "apellidos": "Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@iadecorate.com",
    "password": "admin123"
  }'

# Listar productos
curl http://localhost:8000/api/productos
```

---

## 🗂️ Estructura Final del Proyecto

```
ia-decorate-backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── ProductoController.php
│   │   │       ├── CarritoController.php
│   │   │       ├── PedidoController.php
│   │   │       ├── UsuarioController.php
│   │   │       ├── IncidenciaController.php
│   │   │       └── MensajeController.php
│   │   ├── Requests/
│   │   │   ├── RegisterRequest.php
│   │   │   ├── LoginRequest.php
│   │   │   ├── ProductoRequest.php
│   │   │   └── CarritoRequest.php
│   │   └── Middleware/
│   │       └── Authenticate.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Rol.php
│   │   ├── Producto.php
│   │   ├── Carrito.php
│   │   ├── Pedido.php
│   │   ├── DetallePedido.php
│   │   ├── Incidencia.php
│   │   └── Mensaje.php
│   └── Exceptions/
│       └── Handler.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000000_create_users_table.php
│   │   ├── 2024_01_01_000001_create_roles_table.php
│   │   ├── 2024_01_01_000002_create_role_user_table.php
│   │   ├── 2024_01_01_000003_create_productos_table.php
│   │   ├── 2024_01_01_000004_create_carritos_table.php
│   │   ├── 2024_01_01_000005_create_pedidos_table.php
│   │   ├── 2024_01_01_000006_create_detalle_pedidos_table.php
│   │   ├── 2024_01_01_000007_create_incidencias_table.php
│   │   └── 2024_01_01_000008_create_mensajes_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RoleSeeder.php
│       ├── AdminSeeder.php
│       └── ProductoSeeder.php
├── routes/
│   ├── api.php
│   └── web.php
├── config/
│   ├── auth.php
│   ├── jwt.php
│   └── cors.php
├── .env
├── .env.example
├── composer.json
├── artisan
└── README.md
```

---

## 🔑 Credenciales por Defecto

Después de ejecutar los seeders:

**Usuario Administrador:**
- Email: `admin@iadecorate.com`
- Password: `admin123`

**Usuario Normal:**
- Email: `user@iadecorate.com`
- Password: `user123`

---

## 📝 Comandos Útiles de Laravel

```bash
# Ver rutas
php artisan route:list

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Crear controlador con modelo y migración
php artisan make:model Producto -mcr

# Rollback última migración
php artisan migrate:rollback

# Refrescar base de datos
php artisan migrate:fresh --seed

# Generar key de aplicación
php artisan key:generate

# Ver logs
tail -f storage/logs/laravel.log
```

---

## 🐛 Troubleshooting Común

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"
- Verifica que MySQL esté corriendo
- Revisa las credenciales en `.env`

### Error: "Class 'JWT' not found"
```bash
composer dump-autoload
php artisan config:clear
```

### Permisos en Linux/Mac:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🎯 Próximos Pasos

1. ✅ Seguir esta guía paso a paso
2. ✅ Probar cada endpoint con Postman
3. ✅ Conectar con el frontend
4. ✅ Implementar funcionalidades adicionales
5. ✅ Desplegar en producción

---

## 📚 Recursos Adicionales

- **Documentación Laravel**: https://laravel.com/docs
- **JWT Auth**: https://jwt-auth.readthedocs.io
- **Laravel API Best Practices**: https://github.com/alexeymezenin/laravel-best-practices

---

**¡Ahora continuaré creando todos los archivos del proyecto!** 🚀
