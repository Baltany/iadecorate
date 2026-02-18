@extends('layouts.customer')

@section('title', 'Mensajería - IA Decorate')

@push('styles')
<style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .mensajeria-main-content {
      flex: 1;
      display: flex;
      padding: 0;
      background-color: var(--primary-color);
      overflow: hidden;
      margin-bottom: 0;
      height: calc(100vh - 110px);
    }

    .mensajeria-container {
      display: grid;
      grid-template-columns: 280px 1fr;
      width: 100%;
      height: 100%;
      gap: 0;
      overflow: hidden;
    }

    .conversations-list {
      background-color: var(--primary-color);
      overflow-y: auto;
      padding: 0;
      display: flex;
      flex-direction: column;
      border-right: 1px solid rgba(0, 0, 0, 0.1);
    }

    .conversation-item {
      display: flex;
      gap: 12px;
      align-items: center;
      padding: 12px 15px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: all 0.3s ease;
      background-color: var(--primary-color);
      flex-shrink: 0;
    }

    .conversation-item:hover {
      background-color: var(--primary-dark);
    }

    .conversation-item.active {
      background-color: var(--primary-dark);
    }

    .conversation-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #00d4aa;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--white);
      font-weight: 600;
      font-size: 20px;
      flex-shrink: 0;
    }

    .conversation-info {
      flex: 1;
      min-width: 0;
    }

    .conversation-name {
      font-weight: 700;
      color: var(--text-dark);
      font-size: 13px;
      margin-bottom: 3px;
    }

    .conversation-preview {
      color: var(--text-light);
      font-size: 12px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .conversations-list::-webkit-scrollbar {
      width: 5px;
    }

    .conversations-list::-webkit-scrollbar-track {
      background: transparent;
    }

    .conversations-list::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.2);
      border-radius: 10px;
    }

    .chat-area {
      display: flex;
      flex-direction: column;
      background-color: var(--primary-color);
      overflow: hidden;
      height: 100%;
    }

    .chat-header {
      background-color: var(--primary-color);
      padding: 12px 25px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
      flex-shrink: 0;
    }

    .chat-header-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #00d4aa;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--white);
      font-weight: 600;
      font-size: 16px;
    }

    .chat-header-name {
      font-weight: 700;
      color: var(--text-dark);
      font-size: 13px;
      margin: 0;
    }

    .chat-messages {
      flex: 1;
      overflow-y: auto;
      padding: 25px;
      display: flex;
      flex-direction: column;
      gap: 15px;
      background-color: #ffffff;
      height: 0;
    }

    .message-group {
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }

    .message-avatar {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background-color: #00d4aa;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--white);
      font-weight: 600;
      font-size: 14px;
      flex-shrink: 0;
    }

    .message-content {
      display: flex;
      flex-direction: column;
      gap: 4px;
      max-width: 55%;
    }

    .message-text {
      background-color: #00d4aa;
      color: var(--white);
      padding: 9px 14px;
      border-radius: 16px;
      font-size: 12px;
      line-height: 1.4;
      word-wrap: break-word;
    }

    .message-group.user {
      justify-content: flex-end;
    }

    .message-group.user .message-content {
      max-width: 55%;
      align-items: flex-end;
    }

    .message-group.user .message-avatar {
      display: none;
    }

    .message-group.user .message-text {
      background-color: var(--primary-color);
      color: var(--text-dark);
    }

    /* Estilos especiales para mensajes del administrador */
    .message-group.admin .message-avatar {
      background-color: #7c3aed;
    }

    .message-group.admin .message-text {
      background-color: #7c3aed;
      color: var(--white);
    }

    /* Si el admin es el usuario actual, mantener estilo de usuario pero con borde distintivo */
    .message-group.user.admin .message-text {
      background-color: var(--primary-color);
      color: var(--text-dark);
      border: 2px solid #7c3aed;
    }

    .chat-messages::-webkit-scrollbar {
      width: 5px;
    }

    .chat-messages::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    .chat-messages::-webkit-scrollbar-thumb {
      background: var(--primary-dark);
      border-radius: 10px;
    }

    .chat-input-section {
      padding: 12px 25px 12px 25px;
      background-color: var(--primary-color);
      flex-shrink: 0;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
      margin: 0;
      position: sticky;
      bottom: 0;
      z-index: 10;
    }

    .chat-input-wrapper {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .chat-action-btn {
      background-color: transparent;
      border: none;
      color: var(--text-dark);
      font-size: 16px;
      cursor: pointer;
      padding: 6px;
      transition: transform 0.2s ease;
      flex-shrink: 0;
    }

    .chat-action-btn:hover {
      transform: scale(1.15);
    }

    .chat-input {
      flex: 1;
      padding: 10px 16px;
      border: none;
      border-radius: 20px;
      background-color: var(--white);
      color: var(--text-dark);
      font-size: 12px;
      transition: all 0.3s ease;
    }

    .chat-input::placeholder {
      color: var(--text-light);
    }

    .chat-input:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(0, 212, 170, 0.3);
    }

    .chat-send-btn {
      background-color: transparent;
      border: none;
      color: var(--text-dark);
      font-size: 16px;
      cursor: pointer;
      padding: 6px;
      transition: transform 0.2s ease;
      flex-shrink: 0;
    }

    .chat-send-btn:hover {
      transform: scale(1.15);
    }

    @media (max-width: 1024px) {
      .mensajeria-container {
        grid-template-columns: 250px 1fr;
      }
    }

    @media (max-width: 768px) {
      .mensajeria-container {
        grid-template-columns: 200px 1fr;
      }

      .conversation-item {
        padding: 10px 12px;
        gap: 10px;
      }

      .conversation-avatar {
        width: 45px;
        height: 45px;
        font-size: 18px;
      }

      .chat-messages {
        padding: 15px;
        gap: 12px;
      }

      .message-content {
        max-width: 70%;
      }

      .message-group.user .message-content {
        max-width: 70%;
      }
    }

    @media (max-width: 576px) {
      .mensajeria-main-content {
        height: calc(100vh - 100px);
      }

      .mensajeria-container {
        grid-template-columns: 150px 1fr;
      }

      .conversation-item {
        padding: 8px 10px;
      }

      .conversation-avatar {
        width: 40px;
        height: 40px;
        font-size: 16px;
      }

      .conversation-name {
        font-size: 12px;
      }

      .conversation-preview {
        font-size: 11px;
      }

      .chat-header {
        padding: 10px 15px;
      }

      .chat-header-avatar {
        width: 35px;
        height: 35px;
        font-size: 14px;
      }

      .chat-header-name {
        font-size: 12px;
      }

      .chat-messages {
        padding: 12px;
        gap: 10px;
      }

      .message-content {
        max-width: 75%;
      }

      .message-group.user .message-content {
        max-width: 75%;
      }

      .chat-input-section {
        padding: 10px 15px;
      }

      .chat-input {
        padding: 8px 14px;
        font-size: 11px;
      }
    }
</style>
@endpush

@section('content')
<main class="mensajeria-main-content">
    <div class="mensajeria-container">
      <!-- CONVERSACIONES -->
      <div class="conversations-list" id="conversationsList">
        @if(isset($usuarios) && count($usuarios) > 0)
            @foreach($usuarios as $usuario)
            <a href="{{ route('mensajeria', ['destinatario_id' => $usuario->id]) }}"
               class="conversation-item @if(isset($destinatarioId) && $destinatarioId == $usuario->id) active @elseif(!isset($destinatarioId) && $loop->first) active @endif"
               data-user-id="{{ $usuario->id }}">
              <div class="conversation-avatar">{{ strtoupper(substr($usuario->name, 0, 1)) }}</div>
              <div class="conversation-info">
                <div class="conversation-name">{{ $usuario->name }}</div>
                <div class="conversation-preview">Ver conversación</div>
              </div>
            </a>
            @endforeach
        @else
            <div class="conversation-item active">
              <div class="conversation-avatar">👤</div>
              <div class="conversation-info">
                <div class="conversation-name">Sin conversaciones</div>
                <div class="conversation-preview">No hay usuarios</div>
              </div>
            </div>
        @endif
      </div>

      <!-- ÁREA DE CHAT -->
      <div class="chat-area">
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
          <h3 class="chat-header-name" id="chatHeaderName">
            @if(isset($destinatarioId))
              {{ $destinatario->name ?? 'Usuario' }}
            @else
              Selecciona una conversación
            @endif
          </h3>
        </div>

        <div class="chat-messages" id="chatMessages">
          @if(isset($mensajes) && count($mensajes) > 0)
              @foreach($mensajes as $mensaje)
              @php
                $isUser = $mensaje->usuario_id == auth()->id();
                $isAdmin = $mensaje->usuario->roles->contains('nombre', 'admin');
                $messageClasses = 'message-group';
                if ($isUser) $messageClasses .= ' user';
                if ($isAdmin) $messageClasses .= ' admin';
              @endphp
              <div class="{{ $messageClasses }}">
                @if(!$isUser)
                <div class="message-avatar">{{ strtoupper(substr($mensaje->usuario->name ?? 'U', 0, 1)) }}</div>
                @endif
                <div class="message-content">
                  @if($isAdmin)
                  <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
                    <span style="font-size: 11px; font-weight: 600; color: #666;">{{ $mensaje->usuario->name }}</span>
                    <span style="background: #7c3aed; color: white; font-size: 9px; padding: 2px 6px; border-radius: 4px; font-weight: 600;">ADMIN</span>
                  </div>
                  @endif
                  <div class="message-text">{{ $mensaje->mensaje }}</div>
                </div>
              </div>
              @endforeach
          @else
              <div class="message-group">
                <div class="message-avatar">👤</div>
                <div class="message-content">
                  <div class="message-text">¡Hola! Inicia una conversación</div>
                </div>
              </div>
          @endif
        </div>

        <div class="chat-input-section">
          <form method="POST" action="{{ route('mensajeria.enviar') }}" id="formEnviarMensaje">
              @csrf
              <div class="chat-input-wrapper">
                <button type="button" class="chat-action-btn" id="attachBtn" title="Adjuntar archivo">
                  <i class="fas fa-paperclip"></i>
                </button>
                <input type="text" class="chat-input" id="messageInput" name="mensaje" placeholder="Escriba su mensaje aquí" required autocomplete="off">
                <input type="hidden" name="destinatario_id" id="destinatarioIdInput" value="{{ $destinatarioId ?? '' }}">
                <button type="submit" class="chat-send-btn" id="sendBtn" title="Enviar mensaje" @if(!isset($destinatarioId)) disabled @endif>
                  <i class="fas fa-paper-plane"></i>
                </button>
              </div>
          </form>
        </div>
      </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Variables globales
    let ultimoMensajeId = {{ $mensajes->last()->id ?? 0 }};
    let destinatarioId = {{ $destinatarioId ?? 'null' }};
    let pollingInterval;
    let notificationTimeout;

    // Función para scroll al final
    function scrollToBottom() {
      const chatMessages = document.getElementById('chatMessages');
      if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }
    }

    // Función para crear el HTML de un mensaje
    function crearMensajeHTML(mensaje) {
      const messageClasses = ['message-group'];
      if (mensaje.es_usuario_actual) messageClasses.push('user');
      if (mensaje.es_admin) messageClasses.push('admin');

      let avatarHTML = '';
      if (!mensaje.es_usuario_actual) {
        avatarHTML = `<div class="message-avatar">${mensaje.usuario_inicial}</div>`;
      }

      let adminBadge = '';
      if (mensaje.es_admin) {
        adminBadge = `
          <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
            <span style="font-size: 11px; font-weight: 600; color: #666;">${mensaje.usuario_nombre}</span>
            <span style="background: #7c3aed; color: white; font-size: 9px; padding: 2px 6px; border-radius: 4px; font-weight: 600;">ADMIN</span>
          </div>
        `;
      }

      return `
        <div class="${messageClasses.join(' ')}">
          ${avatarHTML}
          <div class="message-content">
            ${adminBadge}
            <div class="message-text">${mensaje.mensaje}</div>
          </div>
        </div>
      `;
    }

    // Función para mostrar notificación del navegador
    function mostrarNotificacion(mensaje) {
      if (!("Notification" in window)) {
        return;
      }

      if (Notification.permission === "granted") {
        const titulo = mensaje.es_admin
          ? `Nuevo mensaje de ${mensaje.usuario_nombre} (ADMIN)`
          : `Nuevo mensaje de ${mensaje.usuario_nombre}`;

        const notification = new Notification(titulo, {
          body: mensaje.mensaje,
          icon: "{{ asset('img/logo.png') }}",
          badge: "{{ asset('img/logo.png') }}"
        });

        notification.onclick = function() {
          window.focus();
          notification.close();
        };
      } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
          if (permission === "granted") {
            mostrarNotificacion(mensaje);
          }
        });
      }
    }

    // Función para mostrar notificación visual en la página
    function mostrarNotificacionVisual(mensaje) {
      // Limpiar notificación anterior si existe
      if (notificationTimeout) {
        clearTimeout(notificationTimeout);
      }

      // Crear elemento de notificación
      const existingNotif = document.getElementById('mensajeNotificacion');
      if (existingNotif) {
        existingNotif.remove();
      }

      const notificacion = document.createElement('div');
      notificacion.id = 'mensajeNotificacion';
      notificacion.style.cssText = `
        position: fixed;
        top: 80px;
        right: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        z-index: 10000;
        max-width: 350px;
        animation: slideInRight 0.3s ease-out;
      `;

      notificacion.innerHTML = `
        <div style="display: flex; align-items: center; gap: 12px;">
          <div style="width: 40px; height: 40px; background: ${mensaje.es_admin ? '#7c3aed' : 'rgba(255,255,255,0.3)'}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 16px;">
            ${mensaje.usuario_inicial}
          </div>
          <div style="flex: 1;">
            <div style="font-weight: 600; margin-bottom: 4px; display: flex; align-items: center;">
              ${mensaje.usuario_nombre}
              ${mensaje.es_admin ? '<span style="background: #7c3aed; color: white; font-size: 9px; padding: 2px 6px; border-radius: 4px; font-weight: 600; margin-left: 6px;">ADMIN</span>' : ''}
            </div>
            <div style="font-size: 14px; opacity: 0.95;">${mensaje.mensaje.substring(0, 50)}${mensaje.mensaje.length > 50 ? '...' : ''}</div>
          </div>
        </div>
      `;

      document.body.appendChild(notificacion);

      // Agregar animación
      const style = document.createElement('style');
      style.innerHTML = `
        @keyframes slideInRight {
          from {
            transform: translateX(400px);
            opacity: 0;
          }
          to {
            transform: translateX(0);
            opacity: 1;
          }
        }
        @keyframes slideOutRight {
          from {
            transform: translateX(0);
            opacity: 1;
          }
          to {
            transform: translateX(400px);
            opacity: 0;
          }
        }
      `;
      if (!document.getElementById('notificationStyles')) {
        style.id = 'notificationStyles';
        document.head.appendChild(style);
      }

      // Remover después de 5 segundos
      notificationTimeout = setTimeout(() => {
        notificacion.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notificacion.remove(), 300);
      }, 5000);

      // Click para cerrar
      notificacion.style.cursor = 'pointer';
      notificacion.onclick = () => {
        notificacion.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notificacion.remove(), 300);
      };
    }

    // Función de polling para obtener nuevos mensajes
    function verificarNuevosMensajes() {
      if (!destinatarioId) return;

      fetch(`{{ route('mensajeria.obtener-nuevos') }}?destinatario_id=${destinatarioId}&ultimo_mensaje_id=${ultimoMensajeId}`, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.mensajes && data.mensajes.length > 0) {
          const chatMessages = document.getElementById('chatMessages');

          // Agregar cada mensaje nuevo al DOM
          data.mensajes.forEach(mensaje => {
            const mensajeHTML = crearMensajeHTML(mensaje);
            chatMessages.insertAdjacentHTML('beforeend', mensajeHTML);

            // Actualizar último mensaje ID
            if (mensaje.id > ultimoMensajeId) {
              ultimoMensajeId = mensaje.id;
            }

            // Mostrar notificaciones solo para mensajes de otros usuarios
            if (!mensaje.es_usuario_actual) {
              mostrarNotificacionVisual(mensaje);
              mostrarNotificacion(mensaje);
            }
          });

          // Scroll al final
          scrollToBottom();
        }
      })
      .catch(error => {
        console.error('Error al verificar nuevos mensajes:', error);
      });
    }

    // Inicializar al cargar la página
    window.addEventListener('load', () => {
      scrollToBottom();

      // Solicitar permiso para notificaciones
      if ("Notification" in window && Notification.permission === "default") {
        Notification.requestPermission();
      }

      // Iniciar polling cada 3 segundos
      if (destinatarioId) {
        pollingInterval = setInterval(verificarNuevosMensajes, 3000);
      }
    });

    // Limpiar interval al salir de la página
    window.addEventListener('beforeunload', () => {
      if (pollingInterval) {
        clearInterval(pollingInterval);
      }
    });

    // Actualizar destinatario cuando se cambie de conversación
    document.addEventListener('DOMContentLoaded', function() {
      const conversationItems = document.querySelectorAll('.conversation-item');
      conversationItems.forEach(item => {
        item.addEventListener('click', function(e) {
          // Limpiar interval anterior
          if (pollingInterval) {
            clearInterval(pollingInterval);
          }
        });
      });

      // Envío de mensajes por AJAX sin recargar página
      const formEnviarMensaje = document.getElementById('formEnviarMensaje');
      if (formEnviarMensaje) {
        formEnviarMensaje.addEventListener('submit', function(e) {
          e.preventDefault();

          const messageInput = document.getElementById('messageInput');
          const destinatarioIdInput = document.getElementById('destinatarioIdInput');
          const mensaje = messageInput.value.trim();

          if (!mensaje || !destinatarioIdInput.value) {
            return;
          }

          // Obtener token CSRF
          const csrfToken = document.querySelector('input[name="_token"]').value;

          // Deshabilitar input mientras se envía
          messageInput.disabled = true;
          const sendBtn = document.getElementById('sendBtn');
          sendBtn.disabled = true;

          // Enviar mensaje por AJAX
          fetch('{{ route("mensajeria.enviar") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
              mensaje: mensaje,
              destinatario_id: destinatarioIdInput.value
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Agregar mensaje al DOM inmediatamente
              const chatMessages = document.getElementById('chatMessages');
              const nuevoMensajeHTML = `
                <div class="message-group user">
                  <div class="message-content">
                    <div class="message-text">${mensaje}</div>
                  </div>
                </div>
              `;
              chatMessages.insertAdjacentHTML('beforeend', nuevoMensajeHTML);

              // Actualizar último mensaje ID
              if (data.mensaje_id > ultimoMensajeId) {
                ultimoMensajeId = data.mensaje_id;
              }

              // Limpiar input
              messageInput.value = '';

              // Scroll al final
              scrollToBottom();
            }
          })
          .catch(error => {
            console.error('Error al enviar mensaje:', error);
            alert('Error al enviar el mensaje. Intenta de nuevo.');
          })
          .finally(() => {
            // Re-habilitar input
            messageInput.disabled = false;
            sendBtn.disabled = false;
            messageInput.focus();
          });
        });
      }
    });
</script>
@endpush
