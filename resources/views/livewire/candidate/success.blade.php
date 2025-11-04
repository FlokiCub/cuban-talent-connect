<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso - Cuban Talent Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-white text-3xl"></i>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-800 mb-4">¡Registro Exitoso!</h1>
            
            <p class="text-gray-600 mb-6 text-lg">
                Tu perfil de candidato ha sido creado exitosamente. Los entrevistadores podrán ver tu información y contactarte para oportunidades laborales.
            </p>

            <div class="space-y-4">
                <a href="{{ route('dashboard') }}" 
                   class="block w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition duration-300 font-semibold">
                    Ir al Dashboard
                </a>
                
                <a href="{{ url('/') }}" 
                   class="block w-full bg-gray-600 text-white py-3 rounded-xl hover:bg-gray-700 transition duration-300 font-semibold">
                    Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</body>
</html>