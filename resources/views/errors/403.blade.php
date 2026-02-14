<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso denegado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-red-600">403</h1>
                <p class="text-4xl font-medium text-gray-800 mb-4">Acceso denegado</p>
                <p class="text-gray-600 mb-8">No tienes permisos para acceder a esta página. Si crees que esto es un error, contacta con el administrador.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}"
                   class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300">
                    Volver al inicio
                </a>
                @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-lg transition duration-300">
                    Ir al panel
                </a>
                @endauth
            </div>

            <div class="mt-12">
                <div class="text-6xl">🔒</div>
            </div>
        </div>
    </div>
</body>
</html>
