<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de {{ $candidate->name }} - Cuban Talent Connect</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Incluir la navegación -->
    @include('layouts.navigation')

    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header del Perfil -->
            <div class="text-center mb-8">
                <div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center mr-6">
                                <span class="text-white font-bold text-2xl">
                                    {{ $candidate->initials() }}
                                </span>
                            </div>
                            <div class="text-left">
                                <h1 class="text-3xl font-bold text-gray-800">{{ $candidate->name }}</h1>
                                <p class="text-gray-600 text-lg">{{ $candidate->email }}</p>
                                <p class="text-gray-500">{{ $candidate->candidateProfile->phone ?? 'Teléfono no especificado' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-500 to-purple-500 text-white">
                                {{ $candidate->candidateProfile->desired_position ?? 'Posición no especificada' }}
                            </span>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $candidate->candidateProfile->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                    {{ $candidate->candidateProfile->is_available ? 'Disponible' : 'No disponible' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Columna izquierda - Información principal -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Información Personal -->
                    <div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-user text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información Personal</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nacionalidad</label>
                                <p class="text-gray-800 text-lg">{{ $candidate->candidateProfile->nationality ?? 'No especificada' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Nacimiento</label>
                                <p class="text-gray-800 text-lg">
                                    @if($candidate->candidateProfile->birth_date)
                                        {{ \Carbon\Carbon::parse($candidate->candidateProfile->birth_date)->format('d/m/Y') }}
                                    @else
                                        No especificada
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Información Profesional -->
                    <div class="bg-white card-shadow rounded-2xl p-8 border border-green-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-briefcase text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Información Profesional</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Posición Deseada</label>
                                <p class="text-xl font-bold text-blue-600">{{ $candidate->candidateProfile->desired_position ?? 'No especificada' }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nivel Educativo</label>
                                    <p class="text-gray-800 text-lg">{{ $candidate->candidateProfile->education_level ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Salario Deseado</label>
                                    <p class="text-gray-800 text-lg">
                                        @if($candidate->candidateProfile->desired_salary)
                                            ${{ number_format($candidate->candidateProfile->desired_salary, 2) }}
                                        @else
                                            No especificado
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Experiencia Laboral -->
                    <div class="bg-white card-shadow rounded-2xl p-8 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-chart-line text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Experiencia Laboral</h2>
                        </div>
                        
                        <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-line">
                            {{ $candidate->candidateProfile->work_experience ?? 'No especificada' }}
                        </p>
                    </div>

                    <!-- Habilidades e Idiomas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Idiomas -->
                        <div class="bg-white card-shadow rounded-2xl p-6 border border-blue-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-language text-blue-600"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">Idiomas</h3>
                            </div>
                            
                            @if($candidate->candidateProfile->languages && count($candidate->candidateProfile->languages) > 0)
                                <div class="space-y-2">
                                    @foreach($candidate->candidateProfile->languages as $language)
                                        <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-check-circle mr-2 text-blue-500"></i>
                                            {{ $language }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-lg">No especificado</p>
                            @endif
                        </div>

                        <!-- Habilidades -->
                        <div class="bg-white card-shadow rounded-2xl p-6 border border-green-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-tools text-green-600"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">Habilidades</h3>
                            </div>
                            
                            @if($candidate->candidateProfile->skills && count($candidate->candidateProfile->skills) > 0)
                                <div class="space-y-2">
                                    @foreach($candidate->candidateProfile->skills as $skill)
                                        <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-star mr-2 text-green-500"></i>
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-lg">No especificado</p>
                            @endif
                        </div>
                    </div>

                    <!-- Respuestas a Preguntas -->
                    @if($candidate->answers->count() > 0)
                    <div class="bg-white card-shadow rounded-2xl p-8 border border-orange-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-question-circle text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Respuestas del Candidato</h2>
                        </div>
                        
                        <div class="space-y-6">
                            @foreach($candidate->answers as $answer)
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                    <h3 class="font-semibold text-gray-800 text-lg mb-3">
                                        {{ $answer->question->question_text ?? 'Pregunta' }}
                                    </h3>
                                    <p class="text-gray-700 text-lg">{{ $answer->answer }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Columna derecha - Información adicional -->
                <div class="space-y-8">
                    <!-- Sobre Mí -->
                    @if($candidate->candidateProfile->about_me)
                    <div class="bg-white card-shadow rounded-2xl p-6 border border-pink-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-heart text-pink-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Sobre Mí</h3>
                        </div>
                        
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $candidate->candidateProfile->about_me }}
                        </p>
                    </div>
                    @endif

                    <!-- CV -->
                    <div class="bg-white card-shadow rounded-2xl p-6 border border-red-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-file-pdf text-red-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Curriculum Vitae</h3>
                        </div>
                        
                        @if($candidate->candidateProfile->cv_path)
                            <a href="{{ asset('storage/' . $candidate->candidateProfile->cv_path) }}" 
                               target="_blank"
                               class="inline-flex items-center justify-center w-full px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition duration-200 font-semibold text-lg">
                                <i class="fas fa-download mr-3"></i>
                                Descargar CV
                            </a>
                        @else
                            <p class="text-gray-500 text-lg text-center py-4">CV no disponible</p>
                        @endif
                    </div>

                    <!-- Información de Contacto -->
                    <div class="bg-white card-shadow rounded-2xl p-6 border border-indigo-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-indigo-600"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Información de Contacto</h3>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 mr-3"></i>
                                <span class="text-gray-700">{{ $candidate->email }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 mr-3"></i>
                                <span class="text-gray-700">{{ $candidate->candidateProfile->phone ?? 'No especificado' }}</span>
                            </div>
                        </div>
                    </div>
                  
<div class="bg-white card-shadow rounded-2xl p-6 border border-purple-200">
    <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
            <i class="fas fa-crown text-purple-600"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800">Estado de Suscripción</h3>
    </div>
    
    @if($candidate->activeSubscription)
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Tipo:</span>
                <span class="font-semibold text-purple-600 capitalize">
                    {{ $candidate->activeSubscription->type }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Válida hasta:</span>
                <span class="font-semibold text-gray-800">
                    {{ $candidate->activeSubscription->end_date->format('d/m/Y') }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Estado:</span>
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <i class="fas fa-check-circle mr-1"></i>
                    Activa
                </span>
            </div>
        </div>
    @else
        <div class="text-center py-4">
            <i class="fas fa-clock text-yellow-500 text-2xl mb-2"></i>
            <p class="text-gray-600">Sin suscripción activa</p>
        </div>
    @endif
</div>
                    <!-- Acciones Rápidas -->
                    @auth
                        @if(auth()->user()->isInterviewer() || auth()->user()->isAdmin())
                        <div class="bg-white card-shadow rounded-2xl p-6 border border-green-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-bolt text-green-600"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">Acciones Rápidas</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <button class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition duration-200 font-semibold">
                                    <i class="fas fa-check mr-3"></i>
                                    Seleccionar Candidato
                                </button>
                                <button class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
                                    <i class="fas fa-envelope mr-3"></i>
                                    Enviar Mensaje
                                </button>
                            </div>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Botones de Navegación -->
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center px-8 py-4 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition duration-300 font-semibold">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Volver
                </a>
                
                <div class="text-sm text-gray-600">
                    Candidato registrado el {{ $candidate->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- AlpineJS para interactividad -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>