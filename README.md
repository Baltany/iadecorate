<<<<<<< HEAD
# IA Decorate - Backend Spring Boot

Backend completo para la plataforma IA Decorate desarrollado con Spring Boot 3.2.1, Spring Security, JWT y MySQL.

## 📋 Características

- ✅ Autenticación y autorización con JWT
- ✅ Gestión de usuarios con roles (USER, ADMIN) 
- ✅ CRUD completo de productos
- ✅ Gestión de carrito de compras
- ✅ Sistema de pedidos
- ✅ Gestión de incidencias
- ✅ Sistema de mensajería entre usuarios
- ✅ Configuración CORS
- ✅ Validación de datos
- ✅ Manejo global de excepciones
- ✅ Documentación de API

## 🛠️ Tecnologías Utilizadas

- **Spring Boot 3.2.1**
- **Spring Security** con JWT
- **Spring Data JPA**
- **MySQL** (base de datos principal)
- **H2** (base de datos para desarrollo/testing)
- **Lombok** (reducción de código boilerplate)
- **ModelMapper** (mapeo de DTOs)
- **Maven** (gestión de dependencias)

## 📦 Requisitos Previos

- Java 17 o superior
- Maven 3.6 o superior
- MySQL 8.0 o superior (o usar H2 para desarrollo)

## 🚀 Instalación y Configuración

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd ia-decorate-backend
```

### 2. Configurar la base de datos

#### Opción A: Usar MySQL (Recomendado para producción)

1. Crear la base de datos:
```sql
CREATE DATABASE ia_decorate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Configurar las credenciales en `src/main/resources/application.properties`:
```properties
spring.datasource.url=jdbc:mysql://localhost:3306/ia_decorate?createDatabaseIfNotExist=true&useSSL=false&serverTimezone=UTC
spring.datasource.username=tu_usuario
spring.datasource.password=tu_contraseña
```

#### Opción B: Usar H2 (Desarrollo rápido)

Descomentar estas líneas en `application.properties`:
```properties
spring.datasource.url=jdbc:h2:mem:testdb
spring.datasource.driverClassName=org.h2.Driver
spring.datasource.username=sa
spring.datasource.password=
spring.h2.console.enabled=true
spring.h2.console.path=/h2-console
```

Y comentar las líneas de MySQL.

### 3. Compilar el proyecto

```bash
mvn clean install
```

### 4. Ejecutar la aplicación

```bash
mvn spring-boot:run
```

La aplicación estará disponible en: `http://localhost:8080/api`

## 👤 Usuario Administrador por Defecto

Al iniciar la aplicación por primera vez, se crea automáticamente un usuario administrador:

- **Email:** `admin@iadecorate.com`
- **Contraseña:** `admin123`

## 📚 Endpoints Principales

### Autenticación

#### Registro de Usuario
=======
# 🚀 IA Decorate - Backend Laravel

Backend API RESTful para la plataforma IA Decorate desarrollado con Laravel 10 y autenticación JWT.

## 📋 Características

- ✅ Autenticación JWT (JSON Web Tokens)
- ✅ Gestión de usuarios con roles (Admin/User)
- ✅ CRUD completo de productos
- ✅ Sistema de carrito de compras
- ✅ Gestión de pedidos
- ✅ Sistema de incidencias/tickets
- ✅ Mensajería entre usuarios
- ✅ Validación de datos
- ✅ Manejo de errores
- ✅ CORS configurado
- ✅ Seeders con datos de ejemplo

## 🛠️ Tecnologías

- **Laravel 10**
- **PHP 8.1+**
- **XAMPP**
- **JWT Auth (tymon/jwt-auth)**
- **Composer**

## 📦 Instalación Paso a Paso

### 1. Requisitos Previos

```bash
# Verificar versiones
php -v        # Debe ser 8.1 o superior
composer -v   # Composer instalado
npm -v #npm instalado para el vite
```

### 2. Clonar o Crear Proyecto

Si tienes el código:
```bash
cd ia-decorate-laravel
```

Si empiezas desde cero:
```bash
composer create-project laravel/laravel ia-decorate-laravel
cd ia-decorate-laravel
```

### 3. Instalar Dependencias

```bash
composer install
```

### 4. Instalar JWT Auth

```bash
composer require tymon/jwt-auth
```

### 5. Configurar Entorno

```bash
# Copiar archivo de entorno
cp .env.example .env

# Generar key de aplicación
php artisan key:generate

# Publicar configuración JWT
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

# Generar JWT secret
php artisan jwt:secret
```

### 6. Configurar Base de Datos

Editar `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ia_decorate
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

Crear base de datos:

```bash
# Entrar a MySQL
mysql -u root -p

# Crear BD
CREATE DATABASE ia_decorate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

### 7. Copiar Archivos del Proyecto

Copiar los archivos proporcionados en sus ubicaciones correspondientes:

- `app/Models/` → Modelos
- `app/Http/Controllers/Api/` → Controladores
- `app/Http/Middleware/` → Middlewares
- `database/migrations/` → Migraciones
- `database/seeders/` → Seeders
- `routes/api.php` → Rutas
- `config/auth.php` → Configuración de autenticación

### 8. Registrar Middleware

Editar `bootstrap/app.php` y añadir:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

O editar `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    // ... otros middlewares
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
```

### 9. Ejecutar Migraciones y Seeders

```bash
# Ejecutar migraciones
php artisan migrate

# O resetear y ejecutar con seeders
php artisan migrate:fresh --seed
```

### 10. Iniciar Servidor

```bash
php artisan serve
```

La API estará disponible en: **http://localhost:8000**

## 🔑 Credenciales por Defecto

Después de ejecutar los seeders:

**Administrador:**
- Email: `admin@iadecorate.com`
- Password: `admin123`

**Usuario Normal:**
- Email: `user@iadecorate.com`
- Password: `user123`

## 📡 Endpoints de la API

### Autenticación

#### Registro
>>>>>>> origin/daniel
```http
POST /api/auth/register
Content-Type: application/json

{
  "nombre": "Juan",
<<<<<<< HEAD
  "apellidos": "Pérez García",
  "email": "juan@example.com",
  "password": "password123"
=======
  "apellidos": "Pérez",
  "email": "juan@example.com",
  "password": "password123",
  "password_confirmation": "password123"
>>>>>>> origin/daniel
}
```

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
<<<<<<< HEAD
  "email": "juan@example.com",
  "password": "password123"
=======
  "email": "admin@iadecorate.com",
  "password": "admin123"
>>>>>>> origin/daniel
}
```

**Respuesta:**
```json
{
<<<<<<< HEAD
  "token": "eyJhbGciOiJIUzUxMiJ9...",
  "type": "Bearer",
  "id": 1,
  "email": "juan@example.com",
  "nombreUsuario": "juanperezgarcia",
  "roles": ["ROLE_USER"]
}
```

### Productos

#### Obtener todos los productos
=======
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "type": "Bearer",
  "user": {
    "id": 1,
    "nombre": "Admin",
    "apellidos": "IA Decorate",
    "email": "admin@iadecorate.com",
    "nombre_usuario": "admin",
    "roles": ["admin", "user"]
  }
}
```

#### Obtener Usuario Autenticado
```http
GET /api/auth/me
Authorization: Bearer {token}
```

#### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

### Productos

#### Listar Productos
>>>>>>> origin/daniel
```http
GET /api/productos
```

<<<<<<< HEAD
#### Obtener producto por ID
=======
**Parámetros opcionales:**
- `categoria` - Filtrar por categoría
- `destacado=true` - Solo productos destacados
- `buscar` - Buscar por nombre

#### Ver Producto
>>>>>>> origin/daniel
```http
GET /api/productos/{id}
```

<<<<<<< HEAD
#### Buscar productos por nombre
```http
GET /api/productos/buscar?nombre=sofa
```

#### Filtrar por categoría
```http
GET /api/productos/categoria/muebles
```

#### Crear producto (requiere rol ADMIN)
=======
#### Categorías Disponibles
```http
GET /api/productos/categorias
```

#### Productos Destacados
```http
GET /api/productos/destacados
```

#### Crear Producto (Admin)
>>>>>>> origin/daniel
```http
POST /api/productos
Authorization: Bearer {token}
Content-Type: application/json

{
<<<<<<< HEAD
  "nombre": "Sofá Moderno",
  "descripcion": "Sofá de diseño contemporáneo",
  "precio": 599.99,
  "categoria": "muebles",
=======
  "nombre": "Sofá Nuevo",
  "descripcion": "Descripción del sofá",
  "precio": 599.99,
  "categoria": "Sofás",
>>>>>>> origin/daniel
  "stock": 10,
  "altura": 85,
  "ancho": 220,
  "profundidad": 90,
<<<<<<< HEAD
  "unidadMedida": "cm",
=======
>>>>>>> origin/daniel
  "activo": true,
  "destacado": false
}
```

<<<<<<< HEAD
#### Actualizar producto (requiere rol ADMIN)
=======
#### Actualizar Producto (Admin)
>>>>>>> origin/daniel
```http
PUT /api/productos/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
<<<<<<< HEAD
  "nombre": "Sofá Moderno Actualizado",
  "precio": 549.99,
  ...
}
```

#### Eliminar producto (requiere rol ADMIN)
=======
  "nombre": "Sofá Actualizado",
  "precio": 549.99
}
```

#### Eliminar Producto (Admin)
>>>>>>> origin/daniel
```http
DELETE /api/productos/{id}
Authorization: Bearer {token}
```

<<<<<<< HEAD
## 🔐 Autenticación con JWT
=======
### Health Check
```http
GET /api/health
```

## 🔐 Autenticación
>>>>>>> origin/daniel

Para acceder a endpoints protegidos, incluye el token JWT en el header:

```http
<<<<<<< HEAD
Authorization: Bearer eyJhbGciOiJIUzUxMiJ9...
```

## 🗄️ Estructura de la Base de Datos

### Principales Tablas

- **usuarios**: Información de usuarios
- **roles**: Roles del sistema (USER, ADMIN)
- **usuario_roles**: Relación muchos a muchos entre usuarios y roles
- **productos**: Catálogo de productos
- **carrito**: Items en el carrito de cada usuario
- **pedidos**: Pedidos realizados
- **detalle_pedido**: Líneas de cada pedido
- **incidencias**: Tickets de soporte
- **mensajes**: Sistema de mensajería

## 📁 Estructura del Proyecto

```
ia-decorate-backend/
├── src/
│   ├── main/
│   │   ├── java/com/iadecorate/
│   │   │   ├── config/           # Configuraciones (Security, CORS, DataLoader)
│   │   │   ├── controller/       # Controladores REST
│   │   │   ├── dto/              # Data Transfer Objects
│   │   │   ├── exception/        # Manejo de excepciones
│   │   │   ├── model/            # Entidades JPA
│   │   │   ├── repository/       # Repositorios Spring Data
│   │   │   ├── security/         # Clases de seguridad JWT
│   │   │   ├── service/          # Lógica de negocio
│   │   │   └── IaDecorateApplication.java
│   │   └── resources/
│   │       └── application.properties
│   └── test/                     # Tests unitarios e integración
├── pom.xml
└── README.md
```

## 🔧 Configuración Avanzada

### Cambiar el puerto del servidor

En `application.properties`:
```properties
server.port=8081
```

### Configurar tiempo de expiración del JWT

En `application.properties`:
```properties
jwt.expiration=86400000  # 24 horas en milisegundos
```

### Configurar CORS

En `application.properties`:
```properties
cors.allowed-origins=http://localhost:3000,http://localhost:5500
```

### Configurar correo electrónico

Para el sistema de recuperación de contraseñas:
```properties
spring.mail.host=smtp.gmail.com
spring.mail.port=587
spring.mail.username=tu-email@gmail.com
spring.mail.password=tu-app-password
```

## 🧪 Testing

Ejecutar tests:
```bash
mvn test
=======
Authorization: Bearer tu_token_aqui
```

## 📁 Estructura del Proyecto

```
ia-decorate-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       └── ProductoController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Rol.php
│       ├── Producto.php
│       ├── Carrito.php
│       ├── Pedido.php
│       ├── DetallePedido.php
│       ├── Incidencia.php
│       └── Mensaje.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000000_create_users_table.php
│   │   ├── 2024_01_01_000001_create_roles_table.php
│   │   ├── 2024_01_01_000002_create_role_user_table.php
│   │   ├── 2024_01_01_000003_create_productos_table.php
│   │   └── ... (8 migraciones en total)
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RoleSeeder.php
│       ├── AdminSeeder.php
│       └── ProductoSeeder.php
├── routes/
│   └── api.php
├── config/
│   ├── auth.php
│   └── jwt.php
├── .env
├── .env.example
├── composer.json
└── README.md
```

## 🧪 Probar la API (ESTO SE HARÁ MAS ADELANTE, VAMOS POR LO ANTERIOR QUE ES LO ESENCIAL)

### Con cURL:

```bash
# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@iadecorate.com","password":"admin123"}'

# Listar productos
curl http://localhost:8000/api/productos

# Crear producto (necesitas el token del login)
curl -X POST http://localhost:8000/api/productos \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -d '{"nombre":"Sofá Test","precio":299.99,"categoria":"Sofás","stock":5}'
```

### Con Postman:

1. Importar colección de Postman (crear una)
2. Hacer login para obtener token
3. Configurar Authorization: Bearer Token
4. Probar endpoints

## 🔄 Comandos Útiles

```bash
# Ver rutas
php artisan route:list

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Resetear base de datos
php artisan migrate:fresh --seed

# Ver logs
tail -f storage/logs/laravel.log

# Crear migración
php artisan make:migration create_ejemplo_table

# Crear modelo con migración y controlador
php artisan make:model Ejemplo -mcr

# Crear controlador
php artisan make:controller Api/EjemploController --api

# Crear seeder
php artisan make:seeder EjemploSeeder
```

## 🐛 Solución de Problemas

### Error: "No application encryption key"
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"
- Verifica que MySQL esté corriendo
- Revisa credenciales en `.env`

### Error: "Class 'JWT' not found"
```bash
composer dump-autoload
php artisan config:clear
php artisan jwt:secret
```

### Permisos en Linux/Mac:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Error de CORS:
Editar `config/cors.php`:
```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5500', 'http://127.0.0.1:5500'],
```

## 🌐 Configurar CORS

Editar `config/cors.php`:

```php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5500', 'http://127.0.0.1:5500'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
>>>>>>> origin/daniel
```

## 📝 Próximas Funcionalidades

<<<<<<< HEAD
- [ ] Sistema de recuperación de contraseña por email
- [ ] Subida de imágenes a servidor/cloud
- [ ] Integración con pasarela de pago
- [ ] Sistema de notificaciones en tiempo real
- [ ] API para visualización 3D
- [ ] Sistema de valoraciones y reseñas
- [ ] Reportes y estadísticas para administradores

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto es privado y de uso exclusivo para IA Decorate.

## 👥 Autores

- Equipo de desarrollo IA Decorate

## 📞 Soporte

Para reportar bugs o solicitar nuevas funcionalidades, por favor crea un issue en el repositorio.

---

**Nota**: Este es un proyecto en desarrollo activo. Consulta el changelog para ver las últimas actualizaciones.
=======
- [ ] Sistema de carrito completo
- [ ] Gestión de pedidos
- [ ] Sistema de incidencias
- [ ] Mensajería entre usuarios
- [ ] Recuperación de contraseña
- [ ] Subida de imágenes
- [ ] Notificaciones por email
- [ ] Sistema de valoraciones

## 📚 Documentación

- Laravel: https://laravel.com/docs
- JWT Auth: https://jwt-auth.readthedocs.io

## 👥 Autor

Equipo IA Decorate

---

**¡Backend Laravel listo para usar! 🎉**
>>>>>>> origin/daniel
