<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Anónimo - IaDecorate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('partials.navbar')

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">
                            <i class="fas fa-comments text-blue-600"></i> Mis Chats
                        </h1>
                        <p class="text-gray-600 mt-2">
                            @if(auth()->user()->hasRole('admin'))
                                Vista de administrador - Puedes ver todos los chats
                            @else
                                Chatea de forma anónima con otros usuarios
                            @endif
                        </p>
                    </div>

                    @if(!auth()->user()->hasRole('admin'))
                        <a href="{{ route('chat.anonimo') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300 inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Iniciar Chat Anónimo
                        </a>
                    @endif
                </div>
            </div>

            <!-- Admin: Crear chat con usuario -->
            @if(auth()->user()->hasRole('admin'))
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-bold mb-4">Crear chat con usuario</h3>
                    <form action="{{ route('admin.chat.crear') }}" method="POST" class="flex gap-4">
                        @csrf
                        <select name="usuario_id" required
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccionar usuario...</option>
                            @foreach(App\Models\User::where('id', '!=', auth()->id())->get() as $usuario)
                                <option value="{{ $usuario->id }}">
                                    {{ $usuario->name }} ({{ $usuario->email }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition duration-300">
                            <i class="fas fa-plus"></i> Crear Chat
                        </button>
                    </form>
                </div>
            @endif

            <!-- Lista de chats -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($chats->isEmpty())
                    <div class="p-12 text-center">
                        <i class="fas fa-comments text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No tienes conversaciones</h3>
                        <p class="text-gray-500 mb-6">Inicia un chat anónimo para comenzar a conversar</p>
                        @if(!auth()->user()->hasRole('admin'))
                            <a href="{{ route('chat.anonimo') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300 inline-block">
                                <i class="fas fa-plus mr-2"></i> Iniciar Chat Anónimo
                            </a>
                        @endif
                    </div>
                @else
                    <div class="divide-y divide-gray-200">
                        @foreach($chats as $chat)
                            @php
                                $otroUsuario = $chat->otroUsuario(auth()->id());
                                $ultimoMensaje = $chat->ultimoMensaje;
                                $mensajesNoLeidos = $chat->mensajesNoLeidosPara(auth()->id());
                            @endphp
                            <a href="{{ route('chat.show', $chat->id) }}"
                               class="block p-6 hover:bg-gray-50 transition duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        <!-- Avatar -->
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg mr-4">
                                            @if($chat->is_anonymous && !auth()->user()->hasRole('admin'))
                                                <i class="fas fa-user-secret"></i>
                                            @else
                                                {{ substr($otroUsuario->name, 0, 1) }}
                                            @endif
                                        </div>

                                        <!-- Info del chat -->
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h3 class="font-semibold text-gray-800">
                                                    @if($chat->is_anonymous && !auth()->user()->hasRole('admin'))
                                                        Usuario Anónimo
                                                    @else
                                                        {{ $otroUsuario->name }}
                                                        @if(auth()->user()->hasRole('admin'))
                                                            <span class="text-sm text-gray-500">({{ $otroUsuario->email }})</span>
                                                        @endif
                                                    @endif
                                                </h3>
                                                @if($chat->ultimo_mensaje_at)
                                                    <span class="text-sm text-gray-500">
                                                        {{ $chat->ultimo_mensaje_at->diffForHumans() }}
                                                    </span>
                                                @endif
                                            </div>

                                            @if($ultimoMensaje)
                                                <p class="text-sm text-gray-600 truncate">
                                                    @if($ultimoMensaje->usuario_id === auth()->id())
                                                        <span class="font-medium">Tú:</span>
                                                    @endif
                                                    {{ $ultimoMensaje->contenido }}
                                                </p>
                                            @else
                                                <p class="text-sm text-gray-400 italic">Sin mensajes aún</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Badge de mensajes no leídos -->
                                    @if($mensajesNoLeidos > 0)
                                        <div class="ml-4">
                                            <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                {{ $mensajesNoLeidos }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Paginación (si es admin) -->
                    @if(auth()->user()->hasRole('admin') && $chats instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="p-6 border-t border-gray-200">
                            {{ $chats->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>
</html>
