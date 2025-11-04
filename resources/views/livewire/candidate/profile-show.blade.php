{{-- resources/views/candidate/profile-show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header del Perfil -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="bg-blue-600 px-6 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-20 w-20 rounded-full bg-white flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-2xl">
                                {{ $candidate->initials() }}
                            </span>
                        </div>
                        <div class="ml-6">
                            <h1 class="text-2xl font-bold text-white">{{ $candidate->name }}</h1>
                            <p class="text-blue-100">{{ $candidate->email }} • {{ $candidate->phone }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500 text-white">
                            {{ $candidate->candidateProfile->desired_position ?? 'No especificado' }}
                        </span>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $candidate->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $candidate->is_active ? 'Disponible' : 'No disponible' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Perfil -->
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Columna Izquierda: Información Personal y Profesional -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Información Personal -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Información Personal</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Fecha de Nacimiento</label>
                                    <p class="text-gray-800">{{ $candidate->candidateProfile->birth_date ? \Carbon\Carbon::parse($candidate->candidateProfile->birth_date)->format('d/m/Y') : 'No especificado' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nacionalidad</label>
                                    <p class="text-gray-800">{{ $candidate->candidateProfile->nationality ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nivel Educativo</label>
                                    <p class="text-gray-800">{{ $candidate->candidateProfile->education_level ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Salario Deseado</label>
                                    <p class="text-gray-800">
                                        {{ $candidate->candidateProfile->desired_salary ? '$' . number_format($candidate->candidateProfile->desired_salary, 2) : 'No especificado' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Experiencia Laboral -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Experiencia Laboral</h2>
                            <p class="text-gray-800 whitespace-pre-line">{{ $candidate->candidateProfile->work_experience ?? 'No especificada' }}</p>
                        </div>

                        <!-- Habilidades e Idiomas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Idiomas -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Idiomas</h2>
                                @if($candidate->candidateProfile->languages && count($candidate->candidateProfile->languages) > 0)
                                    <div class="space-y-2">
                                        @foreach($candidate->candidateProfile->languages as $language)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $language }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 text-sm">No especificado</p>
                                @endif
                            </div>

                            <!-- Habilidades -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Habilidades</h2>
                                @if($candidate->candidateProfile->skills && count($candidate->candidateProfile->skills) > 0)
                                    <div class="space-y-2">
                                        @foreach($candidate->candidateProfile->skills as $skill)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 text-sm">No especificado</p>
                                @endif
                            </div>
                        </div>

                        <!-- Respuestas a Preguntas -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Respuestas del Candidato</h2>
                            <div class="space-y-4">
                                @forelse($candidate->answers as $answer)
                                    <div class="border-l-4 border-blue-500 pl-4">
                                        <h3 class="font-medium text-gray-800">{{ $answer->question->question_text }}</h3>
                                        <p class="text-gray-600 mt-1">{{ $answer->answer }}</p>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm">El candidato no ha respondido preguntas adicionales.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Información de Contacto y Acciones -->
                    <div class="space-y-6">
                        <!-- Información de Contacto -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Información de Contacto</h2>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-gray-800">{{ $candidate->email }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-gray-800">{{ $candidate->phone ?? 'No especificado' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- CV -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Curriculum Vitae</h2>
                            @if($candidate->candidateProfile->cv_path)
                                <a href="{{ asset('storage/' . $candidate->candidateProfile->cv_path) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Descargar CV
                                </a>
                            @else
                                <p class="text-gray-500 text-sm">No hay CV disponible</p>
                            @endif
                        </div>

                        <!-- Sobre Mí -->
                        @if($candidate->candidateProfile->about_me)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Sobre Mí</h2>
                            <p class="text-gray-800 whitespace-pre-line">{{ $candidate->candidateProfile->about_me }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Navegación -->
        <div class="mt-6 flex justify-between">
            <a href="{{ route('interviewer.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-200">
                ← Volver al Listado
            </a>
            
            @if(auth()->user()->isInterviewer())
            <div class="space-x-3">
                <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Seleccionar
                </button>
                <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Contactar
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection