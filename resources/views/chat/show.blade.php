<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - IaDecorate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
</head>
<body class="bg-gray-100">
    @include('partials.navbar')

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header del chat -->
            <div class="bg-white rounded-t-lg shadow-md p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('chat.index') }}"
                           class="text-gray-600 hover:text-gray-800 mr-4 text-xl">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        <!-- Avatar -->
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold mr-3">
                            @if($chat->is_anonymous && !auth()->user()->hasRole('admin'))
                                <i class="fas fa-user-secret"></i>
                            @else
                                {{ substr($otroUsuario->name, 0, 1) }}
                            @endif
                        </div>

                        <div>
                            <h2 class="font-semibold text-gray-800">
                                @if($chat->is_anonymous && !auth()->user()->hasRole('admin'))
                                    Usuario Anónimo
                                @else
                                    {{ $otroUsuario->name }}
                                @endif
                            </h2>
                            @if(auth()->user()->hasRole('admin') && !$chat->is_anonymous)
                                <p class="text-sm text-gray-500">{{ $otroUsuario->email }}</p>
                            @endif
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('admin'))
                        <form action="{{ route('admin.chat.eliminar', $chat->id) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro de eliminar este chat?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-800 transition duration-200">
                                <i class="fas fa-trash"></i> Eliminar chat
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Componente Livewire del chat -->
            @livewire('chat.chat-box', ['chatId' => $chat->id])
        </div>
    </div>

    @include('partials.footer')
    @livewireScripts
</body>
</html>
