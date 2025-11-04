<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Candidatos - Cuban Talent Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
            
            <!-- Header -->
            <div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mr-6">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Base de Datos de Candidatos</h1>
                            <p class="text-gray-600 mt-2">Encuentra el talento perfecto para tu equipo hotelero</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg text-gray-700">Total de candidatos: <strong>{{ $candidates->total() }}</strong></p>
                        <div class="mt-2 flex space-x-3">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-home mr-2"></i>
                                Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros y Búsqueda -->
            <div class="bg-white card-shadow rounded-2xl p-6 mb-6 border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Búsqueda por nombre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1"></i>Buscar por nombre
                        </label>
                        <input type="text" 
                               placeholder="Nombre del candidato..." 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                    
                    <!-- Filtro por posición -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-briefcase mr-1"></i>Posición deseada
                        </label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Todas las posiciones</option>
                            <option value="recepcionista">Recepcionista</option>
                            <option value="camarero">Camarero/Mesero</option>
                            <option value="cocinero">Cocinero</option>
                            <option value="ayudante_cocina">Ayudante de Cocina</option>
                            <option value="limpieza">Personal de Limpieza</option>
                            <option value="gobernanta">Gobernanta</option>
                            <option value="gerente">Gerente</option>
                            <option value="subgerente">Subgerente</option>
                            <option value="bartender">Bartender</option>
                            <option value="seguridad">Seguridad</option>
                            <option value="animacion">Animación</option>
                            <option value="conserje">Conserje</option>
                            <option value="lavanderia">Lavandería</option>
                        </select>
                    </div>
                    
                    <!-- Filtro por nivel educativo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-graduation-cap mr-1"></i>Nivel educativo
                        </label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="">Todos los niveles</option>
                            <option value="Secundaria Básica">Secundaria Básica</option>
                            <option value="Técnico Medio">Técnico Medio</option>
                            <option value="Preuniversitario">Preuniversitario</option>
                            <option value="Universitario">Universitario</option>
                            <option value="Master">Master</option>
                            <option value="Doctorado">Doctorado</option>
                        </select>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                        <div class="flex space-x-2">
                            <button class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
                                <i class="fas fa-filter mr-2"></i>Filtrar
                            </button>
                            <button class="bg-gray-600 text-white px-4 py-3 rounded-xl hover:bg-gray-700 transition duration-200">
                                <i class="fas fa-redo"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de Candidatos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($candidates as $candidate)
                <div class="bg-white rounded-2xl card-shadow border border-gray-200 hover:border-blue-300 hover:shadow-lg transition duration-300">
                    <!-- Header con Avatar -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-2xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                                <span class="text-white font-bold text-sm">
                                    {{ $candidate->initials() }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-semibold truncate">{{ $candidate->name }}</h3>
                                <p class="text-blue-100 text-sm truncate">{{ $candidate->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Candidato -->
                    <div class="p-4">
                        <div class="space-y-3">
                            <!-- Posición deseada -->
                            <div>
                                <label class="text-xs font-medium text-gray-500">Posición deseada</label>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $candidate->candidateProfile->desired_position ?? 'No especificada' }}
                                </p>
                            </div>
                            
                            <!-- Nivel educativo -->
                            <div>
                                <label class="text-xs font-medium text-gray-500">Nivel educativo</label>
                                <p class="text-sm text-gray-800">
                                    {{ $candidate->candidateProfile->education_level ?? 'No especificado' }}
                                </p>
                            </div>

                            <!-- Habilidades principales -->
                            @if($candidate->candidateProfile && $candidate->candidateProfile->skills)
                            <div>
                                <label class="text-xs font-medium text-gray-500">Habilidades principales</label>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach(array_slice($candidate->candidateProfile->skills, 0, 2) as $skill)
                                        <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                    @if(count($candidate->candidateProfile->skills) > 2)
                                        <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">
                                            +{{ count($candidate->candidateProfile->skills) - 2 }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Información adicional -->
                            <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-200">
                                <span>Registrado: {{ $candidate->created_at->format('d/m/Y') }}</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $candidate->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                    {{ $candidate->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('candidate.show', $candidate) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                                <i class="fas fa-eye mr-2"></i>
                                Ver Perfil
                            </a>
                            <button class="inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition duration-200">
                                <i class="fas fa-star mr-2"></i>
                                Favorito
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-4 text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay candidatos registrados</h3>
                    <p class="text-gray-500 max-w-md mx-auto">
                        Aún no hay candidatos registrados en la plataforma. Los perfiles aparecerán aquí una vez que los candidatos completen su registro.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Volver al Dashboard
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginación -->
            @if($candidates->hasPages())
            <div class="mt-8 bg-white card-shadow rounded-2xl p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Mostrando {{ $candidates->firstItem() }} - {{ $candidates->lastItem() }} de {{ $candidates->total() }} candidatos
                    </div>
                    <div>
                        {{ $candidates->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>