@extends('layouts.customer')

@section('title', 'Incidencias - IA Decorate')

@push('styles')
<style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .incidencias-main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 0;
      background-color: #f5f5f5;
      margin-bottom: 0;
      position: relative;
      height: calc(100vh - 110px);
    }

    .chat-container {
      display: flex;
      flex-direction: column;
      height: 100%;
      width: 100%;
      position: relative;
    }

    .chat-messages {
      flex: 1;
      overflow-y: auto;
      padding: 30px 40px 20px 40px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      height: 0;
    }

    .message-group {
      display: flex;
      gap: 15px;
      align-items: flex-start;
    }

    .message-avatar {
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

    .message-content {
      display: flex;
      flex-direction: column;
      gap: 5px;
      max-width: 60%;
    }

    .message-sender {
      font-weight: 600;
      color: var(--text-dark);
      font-size: 14px;
    }

    .message-text {
      background-color: #00d4aa;
      color: var(--white);
      padding: 12px 18px;
      border-radius: 20px;
      font-size: 14px;
      line-height: 1.4;
      word-wrap: break-word;
    }

    .message-group.user {
      justify-content: flex-end;
    }

    .message-group.user .message-content {
      max-width: 60%;
      align-items: flex-end;
    }

    .message-group.user .message-sender {
      text-align: right;
    }

    .message-group.user .message-text {
      background-color: var(--primary-color);
      color: var(--text-dark);
    }

    .chat-messages::-webkit-scrollbar {
      width: 6px;
    }

    .chat-messages::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .chat-messages::-webkit-scrollbar-thumb {
      background: var(--primary-dark);
      border-radius: 10px;
    }

    .chat-messages::-webkit-scrollbar-thumb:hover {
      background: #d0a060;
    }

    .chat-input-section {
      padding: 20px 40px 30px;
      background-color: #f5f5f5;
      flex-shrink: 0;
      position: sticky;
      bottom: 0;
      z-index: 10;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .faq-selector {
      margin-bottom: 15px;
      padding: 12px 20px;
      border: none;
      border-radius: var(--input-radius);
      background-color: var(--primary-color);
      color: var(--text-dark);
      font-size: 14px;
      font-weight: 500;
      width: 100%;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .faq-selector:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(238, 208, 157, 0.5);
      background-color: #f9f5e6;
    }

    .faq-selector option {
      padding: 10px;
    }

    .chat-input-wrapper {
      display: flex;
      gap: 12px;
      align-items: flex-end;
    }

    .chat-input-actions {
      display: flex;
      gap: 10px;
    }

    .chat-action-btn {
      background-color: transparent;
      border: none;
      color: var(--text-dark);
      font-size: 18px;
      cursor: pointer;
      padding: 8px;
      transition: transform 0.2s ease;
    }

    .chat-action-btn:hover {
      transform: scale(1.15);
    }

    .chat-input {
      flex: 1;
      padding: 14px 20px;
      border: none;
      border-radius: var(--input-radius);
      background-color: var(--primary-color);
      color: var(--text-dark);
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .chat-input::placeholder {
      color: var(--text-dark);
      opacity: 0.6;
    }

    .chat-input:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(238, 208, 157, 0.5);
      background-color: #f9f5e6;
    }

    .chat-send-btn {
      background-color: transparent;
      border: none;
      color: var(--text-dark);
      font-size: 20px;
      cursor: pointer;
      padding: 8px;
      transition: transform 0.2s ease;
    }

    .chat-send-btn:hover {
      transform: scale(1.15);
    }

    .chat-send-btn:active {
      transform: scale(0.95);
    }

    @media (max-width: 768px) {
      .chat-messages {
        padding: 20px 20px 15px 20px;
        gap: 15px;
      }

      .chat-input-section {
        padding: 15px 20px 20px;
      }

      .message-content {
        max-width: 80%;
      }

      .message-group.user .message-content {
        max-width: 80%;
      }

      .message-avatar {
        width: 45px;
        height: 45px;
        font-size: 18px;
      }

      .message-text {
        padding: 10px 16px;
        font-size: 13px;
      }

      .chat-input {
        padding: 12px 16px;
        font-size: 13px;
      }

      .message-sender {
        font-size: 13px;
      }
    }

    @media (max-width: 576px) {
      .incidencias-main-content {
        height: calc(100vh - 100px);
      }

      .chat-messages {
        padding: 15px 12px 12px 12px;
        gap: 12px;
      }

      .chat-input-section {
        padding: 12px 12px 15px;
      }

      .message-content {
        max-width: 85%;
      }

      .message-group.user .message-content {
        max-width: 85%;
      }

      .message-avatar {
        width: 40px;
        height: 40px;
        font-size: 16px;
      }

      .message-text {
        padding: 9px 14px;
        font-size: 12px;
      }

      .chat-input {
        padding: 10px 14px;
        font-size: 12px;
      }

      .message-sender {
        font-size: 12px;
      }

      .chat-action-btn,
      .chat-send-btn {
        font-size: 16px;
        padding: 6px;
      }

      .chat-input-wrapper {
        gap: 8px;
      }
    }
</style>
@endpush

@section('content')
<main class="incidencias-main-content">
    <div class="chat-container">
      <!-- ÁREA DE MENSAJES -->
      <div class="chat-messages" id="chatMessages">
        @if(isset($incidencias) && count($incidencias) > 0)
            @foreach($incidencias as $incidencia)
                <!-- Pregunta del Usuario -->
                <div class="message-group user">
                  <div class="message-content">
                    <div class="message-sender">{{ $incidencia->user->name ?? 'Usuario' }}</div>
                    <div class="message-text">
                      <strong>{{ $incidencia->asunto }}</strong><br>
                      {{ $incidencia->descripcion }}
                    </div>
                  </div>
                </div>

                @if($incidencia->respuesta)
                <!-- Respuesta del Admin -->
                <div class="message-group">
                  <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                  </div>
                  <div class="message-content">
                    <div class="message-sender">Atención al cliente</div>
                    <div class="message-text">
                      {{ $incidencia->respuesta }}
                    </div>
                  </div>
                </div>
                @endif
            @endforeach
        @else
            <!-- Mensaje del Bot por defecto -->
            <div class="message-group">
              <div class="message-avatar">
                <i class="fas fa-robot"></i>
              </div>
              <div class="message-content">
                <div class="message-sender">Atención al cliente</div>
                <div class="message-text">
                  ¡Hola! Soy el bot Decorate ¿En qué puedo ayudarte?
                </div>
              </div>
            </div>
        @endif
      </div>

      <!-- ÁREA DE INPUT -->
      <div class="chat-input-section">
        <!-- Selector de Preguntas Frecuentes -->
        @if(isset($preguntasFrecuentes) && count($preguntasFrecuentes) > 0)
        <select class="faq-selector" id="faqSelector">
          <option value="">Selecciona una pregunta frecuente...</option>
          @foreach($preguntasFrecuentes as $faq)
            <option value="{{ $faq->id }}" data-respuesta="{{ $faq->respuesta }}">{{ $faq->pregunta }}</option>
          @endforeach
        </select>
        @endif

        <form method="POST" action="{{ route('incidencias.crear') }}" id="incidenciaForm">
            @csrf
            <div class="chat-input-wrapper">
              <div class="chat-input-actions">
                <button type="button" class="chat-action-btn" id="attachBtn" title="Adjuntar archivo">
                  <i class="fas fa-paperclip"></i>
                </button>
              </div>
              <input
                type="text"
                class="chat-input"
                id="messageInput"
                name="descripcion"
                placeholder="Escriba su pregunta aquí"
                required
              >
              <input type="hidden" name="asunto" value="Pregunta desde incidencias">
              <button type="submit" class="chat-send-btn" id="sendBtn" title="Enviar mensaje">
                <i class="fas fa-paper-plane"></i>
              </button>
            </div>
        </form>
      </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    window.addEventListener('load', function() {
      const chatMessages = document.getElementById('chatMessages');
      chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    // Selector de preguntas frecuentes
    const faqSelector = document.getElementById('faqSelector');
    const messageInput = document.getElementById('messageInput');
    const chatMessagesDiv = document.getElementById('chatMessages');

    if (faqSelector) {
      faqSelector.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const pregunta = selectedOption.text;
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
          }, 500);

          // Scroll al final
          chatMessagesDiv.scrollTop = chatMessagesDiv.scrollHeight;

          // Reset selector
          this.value = '';
        }
      });
    }
</script>
@endpush
