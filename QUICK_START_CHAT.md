# 🚀 Guía Rápida de Inicio - Sistema de Chat

## ⚡ Comandos para Iniciar

```bash
# 1. Las migraciones ya fueron ejecutadas ✅
# Si necesitas revertir y volver a migrar:
php artisan migrate:fresh

# 2. Opcional: Crear usuarios de prueba
php artisan tinker
>>> User::factory()->count(5)->create()

# 3. Opcional: Asignar roles de admin a un usuario
php artisan tinker
>>> $user = User::find(1)
>>> $adminRole = App\Models\Rol::where('nombre', 'admin')->first()
>>> $user->roles()->attach($adminRole->id)
```

## 📱 Acceso Directo

### Como Usuario Regular:
1. Inicia sesión: `/login`
2. Ve a: `/chat`
3. Clic en "Iniciar Chat Anónimo"
4. ¡Empieza a chatear!

### Como Administrador:
1. Inicia sesión con cuenta admin
2. Ve a: `/chat`
3. Verás TODOS los chats del sistema
4. Puedes crear chat con cualquier usuario
5. Puedes eliminar chats

## 🔍 Verificar Instalación

```bash
# Verificar que las tablas existen
php artisan tinker
>>> DB::table('chats')->count()
>>> DB::table('chat_mensajes')->count()

# Verificar rutas del chat
php artisan route:list | grep chat
```

## 💡 Crear Chat de Prueba Manualmente

```bash
php artisan tinker

# Crear un chat de prueba entre dos usuarios
>>> $chat = App\Models\Chat::create([
...   'usuario1_id' => 1,
...   'usuario2_id' => 2,
...   'is_anonymous' => true,
...   'ultimo_mensaje_at' => now()
... ]);

# Crear un mensaje de prueba
>>> App\Models\ChatMensaje::create([
...   'chat_id' => $chat->id,
...   'usuario_id' => 1,
...   'contenido' => '¡Hola! Este es un mensaje de prueba',
...   'leido' => false
... ]);
```

## 🎯 Puntos de Entrada

- **Lista de chats:** `http://localhost/chat`
- **Chat anónimo:** `http://localhost/chat/anonimo`
- **Chat específico:** `http://localhost/chat/{id}`

## ⚠️ Requisitos Previos

✅ PHP >= 8.1
✅ Laravel 11
✅ Livewire 3
✅ Base de datos configurada
✅ Composer instalado
✅ Migraciones ejecutadas

## 🆘 Solución de Problemas

### Error: "Class 'Chat' not found"
```bash
composer dump-autoload
```

### Error: "Table 'chats' doesn't exist"
```bash
php artisan migrate
```

### Error de permisos
```bash
chmod -R 777 storage bootstrap/cache
```

### Limpiar caché de Laravel
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 🎨 Personalización

### Cambiar frecuencia de actualización (por defecto 5s)
Editar: `resources/views/livewire/chat/chat-box.blade.php`
```blade
wire:poll.5s="actualizarMensajes"
         ↑
    Cambiar: .10s, .3s, etc.
```

### Cambiar longitud máxima de mensajes (por defecto 2000)
Editar: `app/Http/Requests/ChatMensajeRequest.php`
```php
'contenido' => 'required|string|max:2000',
                                    ↑
                              Cambiar número
```

### Activar notificaciones por email
Editar: `app/Notifications/ChatMensajeRecibidoNotification.php`
```php
public function via(object $notifiable): array
{
    return ['mail', 'database']; // Agregar 'mail'
}
```

## ✨ ¡Listo para Usar!

El sistema está completamente funcional. Solo necesitas:
1. Tener usuarios registrados
2. Al menos un usuario con rol admin (para pruebas completas)
3. Navegar a `/chat`

**¡Disfruta del sistema de chat anónimo!** 💬
