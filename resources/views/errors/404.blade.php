<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-blue-600">404</h1>
                <p class="text-4xl font-medium text-gray-800 mb-4">Página no encontrada</p>
                <p class="text-gray-600 mb-8">Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-300">
                    Volver al inicio
                </a>
                <a href="{{ route('catalogo') }}"
                   class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-lg transition duration-300">
                    Ver catálogo
                </a>
            </div>

            <div class="mt-12">
                <img src="/img/404-illustration.svg" alt="404" class="mx-auto opacity-50" style="max-width: 300px;" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</body>
</html>
