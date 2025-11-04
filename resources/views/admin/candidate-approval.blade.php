<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobar Candidato - Cuban Talent Connect</title>
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
    @include('layouts.navigation')

    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="bg-white card-shadow rounded-2xl p-8 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center mr-6">
                                <i class="fas fa-user-check text-white text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <h1 class="text-3xl font-bold text-gray-800">Aprobar Candidato</h1>
                                <p class="text-gray-600 text-lg">Revisa el perfil y configura la suscripción</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-semibold">
                                <i class="fas fa-clock mr-2"></i>
                                Pendiente de Aprobación
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Candidato -->
            <div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200 mb-8">
                <!-- Header del Perfil -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center mr-6">
                            <span class="text-white font-bold text-2xl">
                                {{ $candidate->initials() }}
                            </span>
                        </div>
                        <div class="text-left">
                            <h2 class="text-2xl font-bold text-gray-800">{{ $candidate->name }}</h2>
                            <p class="text-gray-600">{{ $candidate->email }}</p>
                            <p class="text-gray-500">{{ $candidate->candidateProfile->phone ?? 'Teléfono no especificado' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-500 to-purple-500 text-white">
                            {{ $candidate->candidateProfile->desired_position ?? 'Posición no especificada' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Columna izquierda -->
                    <div class="space-y-6">
                        <!-- Información Personal -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Personal</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Nacionalidad</label>
                                    <p class="text-gray-800">{{ $candidate->candidateProfile->nationality ?? 'No especificada' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Fecha de Nacimiento</label>
                                    <p class="text-gray-800">
                                        @if($candidate->candidateProfile->birth_date)
                                            {{ \Carbon\Carbon::parse($candidate->candidateProfile->birth_date)->format('d/m/Y') }}
                                        @else
                                            No especificada
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Nivel Educativo</label>
                                    <p class="text-gray-800">{{ $candidate->candidateProfile->education_level ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Salario Deseado</label>
                                    <p class="text-gray-800">
                                        @if($candidate->candidateProfile->desired_salary)
                                            ${{ number_format($candidate->candidateProfile->desired_salary, 2) }}
                                        @else
                                            No especificado
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Experiencia Laboral -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Experiencia Laboral</h3>
                            <p class="text-gray-700 whitespace-pre-line">
                                {{ $candidate->candidateProfile->work_experience ?? 'No especificada' }}
                            </p>
                        </div>
                    </div>

                    <!-- Columna derecha -->
                    <div class="space-y-6">
                        <!-- Idiomas -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Idiomas</h3>
                            @if($candidate->candidateProfile->languages && count($candidate->candidateProfile->languages) > 0)
                                <div class="space-y-2">
                                    @foreach($candidate->candidateProfile->languages as $language)
                                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                            {{ $language }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No especificado</p>
                            @endif
                        </div>

                        <!-- Habilidades -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Habilidades</h3>
                            @if($candidate->candidateProfile->skills && count($candidate->candidateProfile->skills) > 0)
                                <div class="space-y-2">
                                    @foreach($candidate->candidateProfile->skills as $skill)
                                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No especificado</p>
                            @endif
                        </div>

                        <!-- Sobre Mí -->
                        @if($candidate->candidateProfile->about_me)
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Sobre Mí</h3>
                            <p class="text-gray-700 whitespace-pre-line">
                                {{ $candidate->candidateProfile->about_me }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Respuestas a Preguntas -->
                @if($candidate->answers->count() > 0)
                <div class="mt-6 bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Respuestas del Candidato</h3>
                    <div class="space-y-4">
                        @foreach($candidate->answers as $answer)
                            <div class="border-l-4 border-blue-500 pl-4">
                                <h4 class="font-semibold text-gray-800">{{ $answer->question->question_text ?? 'Pregunta' }}</h4>
                                <p class="text-gray-600 mt-1">{{ $answer->answer }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Formulario de Aprobación -->
            <div class="bg-white card-shadow rounded-2xl p-8 border border-green-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Configurar Suscripción</h2>
                </div>

                <form action="{{ route('admin.approve-candidate', $candidate) }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Tipo de Suscripción -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-crown mr-1"></i>
                                Tipo de Suscripción *
                            </label>
                            <select name="subscription_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                <option value="">Seleccionar tipo...</option>
                                <option value="standard">Standard</option>
                                <option value="plus">Plus</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>

                        <!-- Fecha de Inicio -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                Fecha de Inicio *
                            </label>
                            <input type="date" name="start_date" required
                                   value="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                        </div>

                        <!-- Duración en Meses -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clock mr-1"></i>
                                Duración (meses) *
                            </label>
                            <select name="months_duration" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                <option value="1">1 mes</option>
                                <option value="3">3 meses</option>
                                <option value="6" selected>6 meses</option>
                                <option value="12">12 meses</option>
                                <option value="24">24 meses</option>
                            </select>
                        </div>
                    </div>

                    <!-- Notas del Administrador -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-1"></i>
                            Notas del Administrador
                        </label>
                        <textarea name="admin_notes" rows="3"
                                  placeholder="Observaciones o notas internas..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"></textarea>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.pending-requests') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition duration-200 font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Volver a Solicitudes
                        </a>

                        <div class="space-x-3">
                            <button type="button" 
                                    class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition duration-200 font-semibold">
                                <i class="fas fa-times mr-2"></i>
                                Rechazar
                            </button>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition duration-200 font-semibold">
                                <i class="fas fa-check mr-2"></i>
                                Aprobar Candidato
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>