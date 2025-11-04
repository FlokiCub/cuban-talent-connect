<!DOCTYPE html>
@php
    // Asegurar que las variables existan
    $recentCandidates = $recentCandidates ?? collect();
    $totalCandidates = $totalCandidates ?? 0;
@endphp
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cuban Talent Connect</title>
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
            
            <!-- Header del Dashboard -->
            <div class="text-center mb-12">
                <div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                        Bienvenido a Cuban Talent Connect
                    </h1>
                    <p class="text-xl text-gray-700 mb-6">
                        Conectando el talento cubano con oportunidades en la industria hotelera
                    </p>
                    
                    @auth
                        @if(auth()->user()->isInterviewer())
                        <div class="inline-flex items-center space-x-2 bg-green-100 text-green-800 px-6 py-3 rounded-full font-semibold">
                            <i class="fas fa-user-tie text-green-600"></i>
                            <span>Modo Entrevistador</span>
                        </div>
                        @elseif(auth()->user()->isCandidate())
                        <div class="inline-flex items-center space-x-2 bg-blue-100 text-blue-800 px-6 py-3 rounded-full font-semibold">
                            <i class="fas fa-user-graduate text-blue-600"></i>
                            <span>Modo Candidato</span>
                        </div>
                        @else
                        <div class="inline-flex items-center space-x-2 bg-purple-100 text-purple-800 px-6 py-3 rounded-full font-semibold">
                            <i class="fas fa-user text-purple-600"></i>
                            <span>Modo Administrador</span>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Contenido específico por tipo de usuario -->
            @auth
                <!-- Para ADMINISTRADORES y ENTREVISTADORES -->
                @if(auth()->user()->isAdmin() || auth()->user()->isInterviewer())
                    <!-- Estadísticas Rápidas -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                        <!-- Total Candidatos -->
                        <div class="bg-white card-shadow rounded-2xl p-6 border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600">Total Candidatos</p>
                                    <p class="text-3xl font-bold text-gray-800">
                                        {{ $totalCandidates }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('candidates.index') }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-semibold flex items-center">
                                    Ver todos los candidatos
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Candidatos Activos -->
<div class="bg-white card-shadow rounded-2xl p-6 border border-green-200">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-gray-600">Candidatos Activos</p>
            <p class="text-3xl font-bold text-gray-800">
                {{ $totalCandidates }}
            </p>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
            <i class="fas fa-user-check text-green-600 text-xl"></i>
        </div>
    </div>
</div>

                        <!-- Posiciones Populares -->
                        <div class="bg-white card-shadow rounded-2xl p-6 border border-purple-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-600">Posiciones Solicitadas</p>
                                    <p class="text-3xl font-bold text-gray-800">
                                        @php
                                            $positionsCount = \App\Models\CandidateProfile::distinct('desired_position')->count('desired_position');
                                        @endphp
                                        {{ $positionsCount }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-briefcase text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Candidatos Destacados -->
                    <div class="bg-white card-shadow rounded-2xl p-8 border border-purple-200 mb-12">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-star text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Candidatos Destacados</h2>
                                    <p class="text-gray-600">Descubre talento excepcional para tu equipo hotelero</p>
                                </div>
                            </div>
                            <a href="{{ route('candidates.index') }}" 
                               class="inline-flex items-center space-x-2 bg-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-purple-700 transition duration-200">
                                <i class="fas fa-users mr-2"></i>
                                <span>Explorar Todos los Candidatos</span>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($recentCandidates as $candidate)
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border border-gray-200 hover:border-purple-300 hover:shadow-lg transition duration-300">
                                <!-- Header del Candidato -->
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center mr-4">
                                        <span class="text-white font-bold text-lg">
                                            {{ substr($candidate->name, 0, 1) }}{{ substr(strstr($candidate->name, ' ') ?: '', 1, 1) ?? '' }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-800 text-lg">{{ $candidate->name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $candidate->email }}</p>
                                    </div>
                                </div>

                                <!-- Información Principal -->
                                <div class="space-y-3 mb-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Posición:</span>
                                        <span class="text-sm font-semibold text-purple-700 bg-purple-100 px-2 py-1 rounded-full">
                                            {{ $candidate->candidateProfile->desired_position ?? 'No especificada' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Educación:</span>
                                        <span class="text-sm font-medium text-gray-800">
                                            {{ $candidate->candidateProfile->education_level ?? 'No especificado' }}
                                        </span>
                                    </div>

                                    @if($candidate->candidateProfile && $candidate->candidateProfile->languages)
                                    <div>
                                        <span class="text-sm text-gray-600">Idiomas:</span>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach(array_slice($candidate->candidateProfile->languages, 0, 2) as $language)
                                                <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $language }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Habilidades Destacadas -->
                                @if($candidate->candidateProfile && $candidate->candidateProfile->skills)
                                <div class="mb-4">
                                    <label class="text-xs font-medium text-gray-500 mb-2 block">Habilidades destacadas</label>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($candidate->candidateProfile->skills, 0, 3) as $skill)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1" style="font-size: 8px;"></i>
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Estado y Acciones -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                   <div class="flex items-center space-x-2">
    @php
        $hasActiveSubscription = $candidate->subscriptions->count() > 0;
        $statusText = $hasActiveSubscription ? 'Disponible' : 'No disponible';
        $statusClass = $hasActiveSubscription ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    @endphp
    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
        <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
        {{ $statusText }}
    </span>
</div>
                                    
                                    <a href="{{ route('candidate.show', $candidate) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition duration-200 font-semibold">
                                        <i class="fas fa-eye mr-2"></i>
                                        Ver Perfil
                                    </a>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-3 text-center py-12">
                                <div class="w-20 h-20 bg-gradient-to-r from-purple-100 to-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-users text-purple-400 text-3xl"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2">Aún no hay candidatos</h3>
                                <p class="text-gray-500 max-w-md mx-auto mb-6">
                                    Los perfiles de candidatos aparecerán aquí una vez que se registren en la plataforma.
                                </p>
                                <div class="flex justify-center space-x-4">
                                    <a href="{{ route('candidate.register') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition duration-200 font-semibold">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Registrar Primer Candidato
                                    </a>
                                </div>
                            </div>
                            @endforelse
                        </div>

                        @if($recentCandidates->count() > 0)
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center space-x-6 bg-gray-50 rounded-2xl px-8 py-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600">{{ $totalCandidates }}</div>
                                    <div class="text-sm text-gray-600">Candidatos Totales</div>
                                </div>
                                <div class="h-8 w-px bg-gray-300"></div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $recentCandidates->where('is_active', true)->count() }}
                                    </div>
                                    <div class="text-sm text-gray-600">Disponibles</div>
                                </div>
                                <div class="h-8 w-px bg-gray-300"></div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">
                                        {{ $recentCandidates->count() }}
                                    </div>
                                    <div class="text-sm text-gray-600">Recientes</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    <!-- Para CANDIDATOS -->
                    <div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200 mb-12">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-user-graduate text-white text-2xl"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-4">¡Bienvenido, {{ auth()->user()->name }}!</h2>
                            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                                Estamos aquí para ayudarte a encontrar las mejores oportunidades en la industria hotelera.
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                                <!-- Estado del Perfil -->
                                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-user-circle text-blue-600 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Estado de tu Perfil</h3>
                                    </div>
                                    <p class="text-gray-700 mb-4">
                                        @if(auth()->user()->candidateProfile)
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                Perfil Completo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                                <i class="fas fa-exclamation-circle mr-2"></i>
                                                Perfil Incompleto
                                            </span>
                                        @endif
                                    </p>
                                    @if(!auth()->user()->candidateProfile)
                                    <a href="{{ route('candidate.register') }}" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                                        Completar perfil
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                    @endif
                                </div>

                                <!-- Próximos Pasos -->
                                <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                                    <div class="flex items-center mb-4">
                                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-road text-green-600 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800">Próximos Pasos</h3>
                                    </div>
                                    <ul class="text-gray-700 space-y-2">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span>Completar registro</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                                            <span>Revisión de perfil</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-briefcase text-purple-500 mr-2"></i>
                                            <span>Oportunidades laborales</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Sección de Objetivos y Características -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Misión y Visión -->
                <div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-bullseye text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Nuestra Misión</h2>
                    </div>
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">
                        Conectar el talento profesional cubano con las mejores oportunidades en la industria 
                        hotelera nacional e internacional, facilitando un proceso de reclutamiento eficiente 
                        y transparente.
                    </p>
                    
                    <div class="flex items-center mb-4">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Base de datos centralizada de candidatos</span>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Perfiles completos con CV y respuestas pregrabadas</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Proceso de selección optimizado</span>
                    </div>
                </div>

                <!-- Características Principales -->
                <div class="bg-white card-shadow rounded-2xl p-8 border border-green-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-star text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">¿Por qué Elegirnos?</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-bolt text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Proceso Ágil</h3>
                                <p class="text-gray-600">Registro simplificado y evaluación eficiente de candidatos.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-shield-alt text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Información Confiable</h3>
                                <p class="text-gray-600">Perfiles verificados con respuestas estandarizadas.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-hotel text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Especializado en Hotelería</h3>
                                <p class="text-gray-600">Enfocado exclusivamente en la industria hotelera cubana.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Llamadas a la Acción -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @auth
                    @if(auth()->user()->isInterviewer() || auth()->user()->isAdmin())
                    <!-- Para Entrevistadores -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl card-shadow p-8 text-white">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-search text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold">Buscar Talento</h2>
                        </div>
                        <p class="text-blue-100 text-lg mb-6">
                            Accede a nuestra base de datos de candidatos calificados y encuentra el talento 
                            perfecto para tu equipo hotelero.
                        </p>
                        <a href="{{ route('candidates.index') }}" 
                           class="inline-flex items-center space-x-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition duration-200">
                            <i class="fas fa-users"></i>
                            <span>Explorar Candidatos</span>
                        </a>
                    </div>
                    @else
                    <!-- Para Candidatos -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl card-shadow p-8 text-white">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-user-edit text-white text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold">Mi Perfil</h2>
                        </div>
                        <p class="text-blue-100 text-lg mb-6">
                            Completa o actualiza tu perfil para aumentar tus oportunidades en la industria hotelera.
                        </p>
                        @if(auth()->user()->candidateProfile)
                        <a href="{{ route('candidate.register') }}" 
                           class="inline-flex items-center space-x-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition duration-200">
                            <i class="fas fa-edit"></i>
                            <span>Actualizar Perfil</span>
                        </a>
                        @else
                        <a href="{{ route('candidate.register') }}" 
                           class="inline-flex items-center space-x-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition duration-200">
                            <i class="fas fa-user-plus"></i>
                            <span>Completar Perfil</span>
                        </a>
                        @endif
                    </div>
                    @endif
                @endauth

                <!-- Para Nuevos Candidatos -->
                <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-2xl card-shadow p-8 text-white">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold">Únete a Nosotros</h2>
                    </div>
                    <p class="text-green-100 text-lg mb-6">
                        ¿Buscas oportunidades en la industria hotelera? Registra tu perfil y accede a 
                        ofertas exclusivas.
                    </p>
                    <a href="{{ route('candidate.register') }}" 
                       class="inline-flex items-center space-x-2 bg-white text-green-600 px-6 py-3 rounded-xl font-semibold hover:bg-green-50 transition duration-200">
                        <i class="fas fa-user-graduate"></i>
                        <span>Registrarse como Candidato</span>
                    </a>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="mt-12 bg-white card-shadow rounded-2xl p-8 border border-gray-200">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Transformando el Reclutamiento Hotelero en Cuba</h2>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto">
                        Cuban Talent Connect nace para revolucionar la forma en que los hoteles encuentran talento 
                        y los profesionales acceden a oportunidades en la industria más vibrante de Cuba.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-rocket text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800 mb-2">Innovación</h3>
                            <p class="text-gray-600">Tecnología moderna para procesos tradicionales</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-handshake text-green-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800 mb-2">Confianza</h3>
                            <p class="text-gray-600">Conexiones verificadas y transparentes</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-trophy text-purple-600 text-2xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800 mb-2">Excelencia</h3>
                            <p class="text-gray-600">Comprometidos con la calidad en cada conexión</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- AlpineJS para interactividad -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>