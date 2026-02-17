<div x-data="{
    scrollToBottom() {
        this.$nextTick(() => {
            const container = this.$refs.messagesContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    }
}"
x-init="scrollToBottom();
        window.addEventListener('mensajeEnviado', () => scrollToBottom());"
wire:poll.5s="actualizarMensajes"
class="flex flex-col bg-white rounded-b-lg shadow-md" style="height: calc(100vh - 300px);">

    <!-- Mensajes del chat -->
    <div x-ref="messagesContainer"
         class="flex-1 overflow-y-auto p-6 space-y-4"
         @scroll="scrollToBottom()">

        @if(empty($mensajes))
            <div class="text-center py-12">
                <i class="fas fa-comments text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500">No hay mensajes aún. ¡Envía el primero!</p>
            </div>
        @else
            @foreach($mensajes as $mensaje)
                @php
                    $esMio = $mensaje['usuario_id'] === auth()->id();
                @endphp

                <div class="flex {{ $esMio ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md">
                        <!-- Nombre del remitente (solo si no es mío y el chat no es anónimo, o si es admin) -->
                        @if(!$esMio && (!$chat->is_anonymous || auth()->user()->hasRole('admin')))
                            <p class="text-xs text-gray-500 mb-1 {{ $esMio ? 'text-right' : 'text-left' }}">
                                {{ $otroUsuario->name }}
                            </p>
                        @endif

                        <!-- Mensaje -->
                        <div class="rounded-lg p-3 {{ $esMio ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                            <p class="break-words">{{ $mensaje['contenido'] }}</p>
                        </div>

                        <!-- Hora y estado de lectura -->
                        <div class="flex items-center mt-1 text-xs text-gray-500 {{ $esMio ? 'justify-end' : 'justify-start' }}">
                            <span>{{ \Carbon\Carbon::parse($mensaje['created_at'])->format('H:i') }}</span>
                            @if($esMio)
                                <i class="fas fa-check{{ $mensaje['leido'] ? '-double text-blue-500' : '' }} ml-1"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Input para enviar mensaje -->
    <div class="border-t border-gray-200 p-4">
        <form wire:submit.prevent="enviarMensaje" class="flex gap-3">
            <input type="text"
                   wire:model="mensaje"
                   placeholder="Escribe tu mensaje..."
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   maxlength="2000"
                   required>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-300 font-semibold flex items-center gap-2"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="fas fa-paper-plane"></i>
                </span>
                <span wire:loading>
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
                Enviar
            </button>
        </form>

        @error('mensaje')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('[x-ref="messagesContainer"]');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });

    // Auto-scroll después de actualizar mensajes
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            const container = document.querySelector('[x-ref="messagesContainer"]');
            if (container) {
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight;
                }, 100);
            }
        });
    });
</script>
@endpush
