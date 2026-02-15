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
            <div class="conversation-item @if($loop->first) active @endif" data-user-id="{{ $usuario->id }}">
              <div class="conversation-avatar">{{ strtoupper(substr($usuario->name, 0, 1)) }}</div>
              <div class="conversation-info">
                <div class="conversation-name">{{ $usuario->name }}</div>
                <div class="conversation-preview">Mensaje nuevo</div>
              </div>
            </div>
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
          <div class="chat-header-avatar">👤</div>
          <h3 class="chat-header-name" id="chatHeaderName">Selecciona una conversación</h3>
        </div>

        <div class="chat-messages" id="chatMessages">
          @if(isset($mensajes) && count($mensajes) > 0)
              @foreach($mensajes as $mensaje)
              <div class="message-group @if($mensaje->usuario_id == auth()->id()) user @endif">
                @if($mensaje->usuario_id != auth()->id())
                <div class="message-avatar">{{ strtoupper(substr($mensaje->usuario->name ?? 'U', 0, 1)) }}</div>
                @endif
                <div class="message-content">
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
          <form method="POST" action="{{ route('mensajeria.enviar') }}">
              @csrf
              <div class="chat-input-wrapper">
                <button type="button" class="chat-action-btn" id="attachBtn" title="Adjuntar archivo">
                  <i class="fas fa-paperclip"></i>
                </button>
                <input type="text" class="chat-input" id="messageInput" name="mensaje" placeholder="Escriba su mensaje aquí" required>
                <input type="hidden" name="receptor_id" id="receptorId" value="">
                <button type="submit" class="chat-send-btn" id="sendBtn" title="Enviar mensaje">
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
    // CONVERSACIONES
    const conversationItems = document.querySelectorAll('.conversation-item');
    const chatHeaderName = document.getElementById('chatHeaderName');
    const receptorId = document.getElementById('receptorId');

    conversationItems.forEach(item => {
      item.addEventListener('click', () => {
        conversationItems.forEach(conv => conv.classList.remove('active'));
        item.classList.add('active');

        const userName = item.querySelector('.conversation-name').textContent;
        const userId = item.getAttribute('data-user-id');

        chatHeaderName.textContent = userName;
        if (userId) {
          receptorId.value = userId;
        }
      });
    });

    // Set first user as default
    if (conversationItems.length > 0) {
      const firstItem = conversationItems[0];
      const userId = firstItem.getAttribute('data-user-id');
      if (userId) {
        receptorId.value = userId;
      }
    }

    // Scroll al final
    window.addEventListener('load', () => {
      const chatMessages = document.getElementById('chatMessages');
      chatMessages.scrollTop = chatMessages.scrollHeight;
    });
</script>
@endpush
