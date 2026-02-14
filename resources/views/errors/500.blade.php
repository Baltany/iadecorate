<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Error del servidor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-orange-600">500</h1>
                <p class="text-4xl font-medium text-gray-800 mb-4">Error del servidor</p>
                <p class="text-gray-600 mb-8">Algo salió mal en nuestro servidor. Estamos trabajando para solucionarlo. Por favor, intenta de nuevo más tarde.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}"
                   class="inline-block bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300">
                    Volver al inicio
                </a>
                <button onclick="location.reload()"
                        class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-lg transition duration-300">
                    Reintentar
                </button>
            </div>

            <div class="mt-12">
                <div class="text-6xl">⚠️</div>
            </div>

            @if(config('app.debug') && isset($exception))
            <div class="mt-8 text-left bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="text-red-800 font-bold mb-2">Debug Info:</h3>
                <pre class="text-xs text-red-700 overflow-auto">{{ $exception->getMessage() }}</pre>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
