<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Pendientes - Cuban Talent Connect</title>
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
                <div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center mr-6">
                                <i class="fas fa-clock text-white text-2xl"></i>
                            </div>
                            <div class="text-left">
                                <h1 class="text-3xl font-bold text-gray-800">Solicitudes Pendientes</h1>
                                <p class="text-gray-600 text-lg">Revisa y aprueba las solicitudes de candidatura</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-800 rounded-full font-semibold">
                                <i class="fas fa-users mr-2"></i>
                                {{ $pendingCandidates->total() }} Solicitudes
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de Solicitudes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pendingCandidates as $candidate)
                <div class="bg-white card-shadow rounded-2xl p-6 border border-orange-200 hover:border-orange-300 transition duration-300">
                    <!-- Header del Candidato -->
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-orange-400 to-red-400 flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg">
                                {{ $candidate->initials() }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 text-lg">{{ $candidate->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $candidate->email }}</p>
                        </div>
                    </div>

                    <!-- Información Básica -->
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Posición:</span>
                            <span class="text-sm font-semibold text-gray-800">
                                {{ $candidate->candidateProfile->desired_position ?? 'No especificada' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Educación:</span>
                            <span class="text-sm text-gray-800">
                                {{ $candidate->candidateProfile->education_level ?? 'No especificado' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Registrado:</span>
                            <span class="text-sm text-gray-800">
                                {{ $candidate->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.candidate-approval', $candidate) }}" 
                           class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                            <i class="fas fa-eye mr-2"></i>
                            Revisar
                        </a>
                     
<a href="{{ route('interviewer.candidate.show', $candidate) }}" 
   target="_blank"
   class="bg-gray-600 text-white px-3 py-2 rounded text-sm hover:bg-gray-700">
    Ver Perfil
</a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <div class="w-24 h-24 bg-gradient-to-r from-green-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-green-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay solicitudes pendientes</h3>
                    <p class="text-gray-500">Todas las solicitudes han sido procesadas.</p>
                </div>
                @endforelse
            </div>

            <!-- Paginación -->
            @if($pendingCandidates->hasPages())
            <div class="mt-8">
                {{ $pendingCandidates->links() }}
            </div>
            @endif

        </div>
    </div>
</body>
</html>