# 💬 Sistema de Chat Anónimo - IaDecorate

## 📋 Características Implementadas

### ✅ Funcionalidades Principales

1. **Chat Anónimo entre Usuarios**
   - Cada usuario puede tener un chat con otro usuario asignado aleatoriamente
   - Los usuarios no ven el nombre real del otro participante (anónimo)
   - Cada chat tiene su propio historial de mensajes independiente
   - No se comparte historial entre diferentes chats

2. **Panel de Administrador**
   - El admin puede ver todos los chats activos
   - El admin puede comunicarse con cualquier usuario específico
   - El admin ve los nombres reales de los participantes
   - El admin puede crear chats con usuarios específicos
   - El admin puede eliminar chats

3. **Características Técnicas**
   - Actualización automática de mensajes cada 5 segundos (polling)
   - Notificaciones en base de datos cuando se recibe un mensaje
   - Indicador de mensajes no leídos
   - Marca automática de mensajes como leídos al abrir el chat
   - Scroll automático al final de la conversación
   - Validación de mensajes (máximo 2000 caracteres)

---

## 📁 Archivos Creados

### Modelos
- `app/Models/Chat.php` - Modelo de chat con relaciones y métodos auxiliares
- `app/Models/ChatMensaje.php` - Modelo de mensajes individuales

### Migraciones
- `database/migrations/2026_02_17_100000_create_chats_table.php`
- `database/migrations/2026_02_17_100001_create_chat_mensajes_table.php`

### Controlador
- `app/Http/Controllers/ChatController.php` - Lógica completa del chat

### FormRequest
- `app/Http/Requests/ChatMensajeRequest.php` - Validación de mensajes

### Componente Livewire
- `app/Livewire/Chat/ChatBox.php` - Componente de chat en tiempo real

### Notificaciones
- `app/Notifications/ChatMensajeRecibidoNotification.php`

### Vistas
- `resources/views/chat/index.blade.php` - Lista de chats
- `resources/views/chat/show.blade.php` - Vista de conversación
- `resources/views/livewire/chat/chat-box.blade.php` - Componente Livewire

---

## 🗄️ Estructura de Base de Datos

### Tabla: `chats`
```sql
- id
- usuario1_id (FK a users)
- usuario2_id (FK a users)
- is_anonymous (boolean)
- ultimo_mensaje_at (timestamp)
- created_at
- updated_at
```

### Tabla: `chat_mensajes`
```sql
- id
- chat_id (FK a chats)
- usuario_id (FK a users)
- contenido (text)
- leido (boolean)
- created_at
- updated_at
```

---

## 🔗 Rutas Disponibles

### Para Usuarios Autenticados
```php
GET  /chat                      - Lista de chats (chat.index)
GET  /chat/anonimo              - Obtener/crear chat anónimo (chat.anonimo)
GET  /chat/{chat}               - Ver conversación (chat.show)
POST /chat/{chat}/mensaje       - Enviar mensaje (chat.mensaje)
```

### Para Administrador
```php
POST   /admin/chat/crear        - Crear chat con usuario específico (admin.chat.crear)
DELETE /admin/chat/{chat}       - Eliminar chat (admin.chat.eliminar)
```

---

## 🚀 Cómo Usar

### Usuario Regular

1. **Iniciar Chat Anónimo:**
   ```
   Navegar a: /chat
   Clic en "Iniciar Chat Anónimo"
   ```

2. **Ver Conversaciones:**
   - Lista de chats muestra todos los chats activos
   - Badge indica mensajes no leídos
   - Clic en un chat para abrir la conversación

3. **Chatear:**
   - Los mensajes se actualizan automáticamente cada 5 segundos
   - Al enviar un mensaje, el otro usuario recibe una notificación
   - El nombre del otro usuario aparece como "Usuario Anónimo"

### Administrador

1. **Ver Todos los Chats:**
   - El admin ve todos los chats del sistema
   - Puede ver nombres reales de todos los participantes

2. **Crear Chat con Usuario:**
   - Seleccionar usuario del dropdown
   - Clic en "Crear Chat"
   - Si ya existe un chat, redirige al existente

3. **Eliminar Chats:**
   - Botón "Eliminar chat" en la vista de conversación
   - Elimina el chat y todos sus mensajes (CASCADE)

---

## 🔐 Seguridad Implementada

1. ✅ Verificación de permisos en cada acción
2. ✅ Middleware de autenticación en todas las rutas
3. ✅ Verificación de que el usuario pertenece al chat
4. ✅ Solo admin puede ver todos los chats
5. ✅ Solo admin puede eliminar chats
6. ✅ Validación de formularios con FormRequest
7. ✅ Protección CSRF en todos los formularios
8. ✅ Sanitización de inputs

---

## 🎨 Características de la Interfaz

1. **Diseño Responsivo:**
   - Adaptado para móviles, tablets y escritorio
   - Usa Tailwind CSS

2. **Experiencia de Usuario:**
   - Scroll automático al final
   - Indicadores visuales de mensajes leídos/no leídos
   - Avatares con iniciales o icono anónimo
   - Timestamp de mensajes
   - Estado de carga con spinner

3. **Actualización en Tiempo Real:**
   - Polling cada 5 segundos con Livewire
   - Sin necesidad de recargar la página

---

## 📊 Flujo de Funcionamiento

### Para Usuarios Regulares:
```
Usuario accede a /chat
  ↓
¿Tiene chat anónimo?
  NO → Crear chat con usuario aleatorio
  SÍ → Mostrar chat existente
  ↓
Usuario envía mensaje
  ↓
Mensaje guardado en BD
  ↓
Notificación al destinatario
  ↓
Actualización automática cada 5s
```

### Para Admin:
```
Admin accede a /chat
  ↓
Ve lista de TODOS los chats
  ↓
Puede crear chat con cualquier usuario
  ↓
Puede ver nombres reales
  ↓
Puede comunicarse con todos
  ↓
Puede eliminar chats
```

---

## 🧪 Testing Recomendado

1. **Crear múltiples usuarios**
2. **Cada usuario inicia su chat anónimo**
3. **Verificar que no pueden ver nombres reales**
4. **Admin accede y verifica que ve todos los chats**
5. **Admin crea chat con usuario específico**
6. **Probar envío de mensajes**
7. **Verificar notificaciones**
8. **Verificar contador de no leídos**

---

## 🔧 Próximas Mejoras (Opcionales)

- [ ] Broadcasting con Pusher/WebSockets para tiempo real instantáneo
- [ ] Adjuntar imágenes en mensajes
- [ ] Emojis picker
- [ ] Búsqueda de mensajes
- [ ] Exportar conversación a PDF
- [ ] Indicador "escribiendo..."
- [ ] Mensajes con respuesta (reply)
- [ ] Reacciones a mensajes

---

## 📝 Notas Importantes

1. **Asignación Aleatoria:** El sistema empareja usuarios aleatoriamente para el chat anónimo
2. **Sin Historial Compartido:** Cada chat es completamente independiente
3. **Privacidad:** Los usuarios regulares nunca ven nombres reales en chats anónimos
4. **Admin Privilegios:** El admin tiene acceso total para moderación
5. **Notificaciones:** Solo se envían notificaciones a base de datos (no email por defecto)

---

## ✅ Estado del Sistema

🟢 **COMPLETAMENTE FUNCIONAL**

Todas las funcionalidades han sido implementadas y probadas:
- ✅ Modelos con relaciones Eloquent
- ✅ Migraciones ejecutadas correctamente
- ✅ Controlador con toda la lógica
- ✅ Vistas responsivas y funcionales
- ✅ Componente Livewire para tiempo real
- ✅ Notificaciones configuradas
- ✅ Rutas protegidas con middleware
- ✅ Validaciones implementadas

**¡El sistema está listo para usar!** 🚀
