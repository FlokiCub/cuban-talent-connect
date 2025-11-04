<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuban Talent Connect - Registro de Candidatos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .step-content {
            display: none;
        }
        .step-content.active {
            display: block;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="bg-white card-shadow rounded-2xl p-6 mb-6 border border-blue-200">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">
                        Cuban Talent Connect
                    </h1>
                    <p class="text-lg text-gray-700">Registra tu perfil para oportunidades en la industria hotelera de Cuba</p>
                    
                    @auth
                    <div class="mt-4 p-4 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-xl border border-blue-300">
                        <p class="text-blue-800 font-medium">
                            <i class="fas fa-user-check mr-2"></i>
                            <strong>Estás registrándote como candidato con tu cuenta:</strong><br>
                            <span class="text-blue-900">{{ $user->name }}</span> 
                            <span class="text-blue-700">({{ $user->email }})</span>
                        </p>
                    </div>
                    <div>
   
</div>
                    @endauth
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8 bg-white card-shadow rounded-2xl p-6 border border-blue-200">
                <div class="flex justify-between mb-4">
                    @foreach($steps as $index => $step)
                        <div class="text-center">
                            <div class="w-8 h-8 rounded-full step-indicator bg-gray-300 text-gray-600 flex items-center justify-center mx-auto mb-2 font-bold"
                                 data-step="{{ $index }}">
                                {{ $index + 1 }}
                            </div>
                            <span class="text-sm font-medium text-gray-500 step-label">
                                {{ ucfirst($step) }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full transition-all duration-500 ease-out progress-bar" 
                         style="width: 25%"></div>
                </div>
            </div>

            <!-- Mensajes de Error -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <div>
                            <strong>Por favor corrige los siguientes errores:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulario -->
            <form id="registrationForm" action="{{ route('candidate.register.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

                
              <!-- Paso 1: Información Personal -->
<div id="step-0" class="step-content active bg-white card-shadow rounded-2xl p-8 border border-blue-200">
    <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-4">
            <i class="fas fa-user text-white text-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Paso 1: Información Personal</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo *</label>
            <div class="p-3 bg-blue-50 rounded-xl border border-blue-200">
                <strong class="text-blue-900">{{ $user->name }}</strong>
            </div>
            <input type="hidden" name="name" value="{{ $user->name }}">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
            <div class="p-3 bg-blue-50 rounded-xl border border-blue-200">
                <strong class="text-blue-900">{{ $user->email }}</strong>
            </div>
        </div>

        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Teléfono *</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                   placeholder="Ej: +53 5xxx xxxx" required>
        </div>

        <!-- Campo de nacionalidad agregado aquí -->
        <div>
            <label for="nationality" class="block text-sm font-semibold text-gray-700 mb-2">Nacionalidad *</label>
            <select name="nationality" id="nationality" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                    required>
                <option value="">Selecciona tu nacionalidad...</option>
                <option value="cubana" {{ old('nationality', 'cubana') == 'cubana' ? 'selected' : '' }}>Cubana</option>
                <option value="extranjera" {{ old('nationality') == 'extranjera' ? 'selected' : '' }}>Extranjera</option>
            </select>
            @error('nationality')
                <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Botones de Navegación -->
    <div class="mt-8 flex justify-end items-center pt-6 border-t border-gray-200">
        <button type="button" onclick="nextStep(1)" 
                class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-300 font-semibold flex items-center">
            Siguiente
            <i class="fas fa-arrow-right ml-3"></i>
        </button>
    </div>
</div>
                <!-- Paso 2: Información Profesional -->
                <div id="step-1" class="step-content bg-white card-shadow rounded-2xl p-8 border border-blue-200">
                    <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-briefcase text-white text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Paso 2: Información Profesional</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Nacimiento *</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       required>
                            </div>

                            <div>
                                <label for="education_level" class="block text-sm font-semibold text-gray-700 mb-2">Nivel Educativo *</label>
                                <select name="education_level" id="education_level" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                        required>
                                    <option value="">Selecciona tu nivel educativo...</option>
                                    <option value="Secundaria Básica" {{ old('education_level') == 'Secundaria Básica' ? 'selected' : '' }}>Secundaria Básica</option>
                                    <option value="Técnico Medio" {{ old('education_level') == 'Técnico Medio' ? 'selected' : '' }}>Técnico Medio</option>
                                    <option value="Preuniversitario" {{ old('education_level') == 'Preuniversitario' ? 'selected' : '' }}>Preuniversitario</option>
                                    <option value="Universitario" {{ old('education_level') == 'Universitario' ? 'selected' : '' }}>Universitario</option>
                                    <option value="Master" {{ old('education_level') == 'Master' ? 'selected' : '' }}>Master</option>
                                    <option value="Doctorado" {{ old('education_level') == 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="desired_position" class="block text-sm font-semibold text-gray-700 mb-2">Posición Deseada *</label>
                            <select name="desired_position" id="desired_position" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                    required>
                                <option value="">Selecciona una posición...</option>
                                <option value="recepcionista" {{ old('desired_position') == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                                <option value="camarero" {{ old('desired_position') == 'camarero' ? 'selected' : '' }}>Camarero/Mesero</option>
                                <option value="cocinero" {{ old('desired_position') == 'cocinero' ? 'selected' : '' }}>Cocinero</option>
                                <option value="ayudante_cocina" {{ old('desired_position') == 'ayudante_cocina' ? 'selected' : '' }}>Ayudante de Cocina</option>
                                <option value="limpieza" {{ old('desired_position') == 'limpieza' ? 'selected' : '' }}>Personal de Limpieza</option>
                                <option value="gobernanta" {{ old('desired_position') == 'gobernanta' ? 'selected' : '' }}>Gobernanta</option>
                                <option value="gerente" {{ old('desired_position') == 'gerente' ? 'selected' : '' }}>Gerente</option>
                                <option value="subgerente" {{ old('desired_position') == 'subgerente' ? 'selected' : '' }}>Subgerente</option>
                                <option value="bartender" {{ old('desired_position') == 'bartender' ? 'selected' : '' }}>Bartender</option>
                                <option value="seguridad" {{ old('desired_position') == 'seguridad' ? 'selected' : '' }}>Seguridad</option>
                                <option value="animacion" {{ old('desired_position') == 'animacion' ? 'selected' : '' }}>Animación</option>
                                <option value="conserje" {{ old('desired_position') == 'conserje' ? 'selected' : '' }}>Conserje</option>
                                <option value="lavanderia" {{ old('desired_position') == 'lavanderia' ? 'selected' : '' }}>Lavandería</option>
                            </select>
                        </div>

                        <div>
                            <label for="work_experience" class="block text-sm font-semibold text-gray-700 mb-2">Experiencia Laboral *</label>
                            <textarea name="work_experience" id="work_experience" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      placeholder="Describe tu experiencia laboral en hoteles, restaurantes, turismo o servicio al cliente..."
                                      required>{{ old('work_experience') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="languages" class="block text-sm font-semibold text-gray-700 mb-2">Idiomas que dominas</label>
                                <input type="text" name="languages" id="languages" value="{{ old('languages') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       placeholder="Ej: Español, Inglés básico, Francés intermedio">
                            </div>

                            <div>
                                <label for="skills" class="block text-sm font-semibold text-gray-700 mb-2">Habilidades profesionales</label>
                                <input type="text" name="skills" id="skills" value="{{ old('skills') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       placeholder="Ej: Atención al cliente, Trabajo en equipo, Cocina internacional">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="desired_salary" class="block text-sm font-semibold text-gray-700 mb-2">Salario Deseado (opcional)</label>
                                <input type="number" name="desired_salary" id="desired_salary" value="{{ old('desired_salary') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       placeholder="Ej: 15000">
                            </div>

                            <div>
                                <label for="cv" class="block text-sm font-semibold text-gray-700 mb-2">Curriculum Vitae *</label>
                                <input type="file" name="cv" id="cv" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                       accept=".pdf,.doc,.docx" required>
                            </div>
                        </div>

                        <div>
                            <label for="about_me" class="block text-sm font-semibold text-gray-700 mb-2">Sobre Mí (opcional)</label>
                            <textarea name="about_me" id="about_me" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                      placeholder="Cuéntanos sobre tus objetivos profesionales, intereses...">{{ old('about_me') }}</textarea>
                        </div>
                    </div>

                    <!-- Botones de Navegación -->
                    <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                        <button type="button" onclick="nextStep(0)" 
                                class="px-8 py-4 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition duration-300 font-semibold flex items-center">
                            <i class="fas fa-arrow-left mr-3"></i>
                            Anterior
                        </button>

                        <button type="button" onclick="nextStep(2)" 
                                class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-300 font-semibold flex items-center">
                            Siguiente
                            <i class="fas fa-arrow-right ml-3"></i>
                        </button>
                    </div>
                </div>

<!-- Paso 3: Preguntas -->
<div id="step-2" class="step-content bg-white card-shadow rounded-2xl p-8 border border-blue-200">
    <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-4">
            <i class="fas fa-question-circle text-white text-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Paso 3: Preguntas Adicionales</h2>
    </div>
    
    <div class="space-y-8">
        @foreach($questions as $question)
        <div class="p-6 bg-white border border-gray-200 rounded-xl question-container">
            <label class="block text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-question text-blue-500 mr-2"></i>
                {{ $question->question_text }}
                @if($question->is_required)
                    <span class="text-red-500">*</span>
                @endif
            </label>
            
            @if($question->question_type === 'select' && $question->options)
                <select name="answers[{{ $question->id }}]" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        @if($question->is_required) required @endif>
                    <option value="">Selecciona una opción...</option>
                    @foreach($question->options as $option)
                        <option value="{{ $option }}" 
                            {{ old("answers.{$question->id}") == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
            
            @elseif($question->question_type === 'text')
                @if($question->id == 4) <!-- ¿Qué idiomas hablas y a qué nivel? -->
                    <div class="bg-blue-50 p-4 rounded-lg mb-4">
                        <p class="text-blue-700 text-sm mb-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Ejemplo: Español (nativo), Inglés (intermedio), Francés (básico)
                        </p>
                    </div>
                @endif
                
                <textarea name="answers[{{ $question->id }}]" 
                          rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                          placeholder="Escribe tu respuesta aquí..."
                          @if($question->is_required) required @endif>{{ old("answers.{$question->id}") }}</textarea>
            
            @else
                <!-- Por defecto, campo de texto -->
                <input type="text" 
                       name="answers[{{ $question->id }}]"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Escribe tu respuesta aquí..."
                       value="{{ old("answers.{$question->id}") }}"
                       @if($question->is_required) required @endif>
            @endif
            
            @error("answers.{$question->id}")
                <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span>
            @enderror
        </div>
        @endforeach
    </div>

    <!-- Botones de Navegación -->
    <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
        <button type="button" onclick="nextStep(1)" 
                class="px-8 py-4 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition duration-300 font-semibold flex items-center">
            <i class="fas fa-arrow-left mr-3"></i>
            Anterior
        </button>

        <button type="button" onclick="nextStep(3)" 
                class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-300 font-semibold flex items-center">
            Siguiente
            <i class="fas fa-arrow-right ml-3"></i>
        </button>
    </div>
</div>

                <!-- Paso 4: Revisión -->
                <div id="step-3" class="step-content bg-white card-shadow rounded-2xl p-8 border border-blue-200">
                    <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-clipboard-check text-white text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Paso 4: Revisión</h2>
                    </div>
                    
                    <div class="p-6 bg-yellow-50 border border-yellow-300 rounded-2xl mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mr-4"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-yellow-800 mb-2">¡Revisa tu información!</h3>
                                <div class="text-yellow-700">
                                    <p>Por favor, revisa cuidadosamente toda tu información antes de enviar.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Navegación -->
                    <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                        <button type="button" onclick="nextStep(2)" 
                                class="px-8 py-4 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition duration-300 font-semibold flex items-center">
                            <i class="fas fa-arrow-left mr-3"></i>
                            Anterior
                        </button>

                        <button type="submit" 
                                class="px-10 py-4 bg-green-600 text-white rounded-xl hover:bg-green-700 transition duration-300 font-semibold flex items-center">
                            <i class="fas fa-paper-plane mr-3"></i>
                            Enviar Solicitud
                        </button>
                    </div>
                </div>
            </form>

            <!-- Información adicional -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>¿Eres un entrevistador? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition duration-200">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

<!-- JavaScript para el wizard -->
<script>
    let currentStep = 0;
    const totalSteps = 4;

    // Función para cambiar de paso con validación
    function nextStep(step) {
        // Validar paso actual antes de continuar
        if (step > currentStep && !validateStep(currentStep)) {
            return;
        }
        
        // Ocultar paso actual
        document.getElementById(`step-${currentStep}`).classList.remove('active');
        
        // Mostrar nuevo paso
        document.getElementById(`step-${step}`).classList.add('active');
        
        // Actualizar currentStep
        currentStep = step;
        
        // Actualizar progreso
        updateProgress();
    }

    // Función para actualizar la barra de progreso
    function updateProgress() {
        const progress = ((currentStep + 1) / totalSteps) * 100;
        document.querySelector('.progress-bar').style.width = `${progress}%`;
        
        // Actualizar indicadores de pasos
        document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
            if (index <= currentStep) {
                indicator.classList.remove('bg-gray-300', 'text-gray-600');
                indicator.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-purple-500', 'text-white');
            } else {
                indicator.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-purple-500', 'text-white');
                indicator.classList.add('bg-gray-300', 'text-gray-600');
            }
        });
        
        // Actualizar labels
        document.querySelectorAll('.step-label').forEach((label, index) => {
            if (index <= currentStep) {
                label.classList.remove('text-gray-500');
                label.classList.add('text-blue-600');
            } else {
                label.classList.remove('text-blue-600');
                label.classList.add('text-gray-500');
            }
        });
    }

    // Función de validación por pasos
    function validateStep(step) {
        let isValid = true;
        let firstError = null;
        
        if (step === 0) { // Validar paso 1 (Información Personal)
            const nationality = document.getElementById('nationality');
            const phone = document.getElementById('phone');
            
            if (!nationality || !nationality.value) {
                alert('Por favor, selecciona tu nacionalidad');
                if (nationality) nationality.focus();
                isValid = false;
            }
            
            if (!phone || !phone.value.trim()) {
                alert('Por favor, ingresa tu número de teléfono');
                if (phone) phone.focus();
                isValid = false;
            }
        }
        
        if (step === 1) { // Validar paso 2 (Información Profesional)
            const birthDate = document.getElementById('birth_date');
            const educationLevel = document.getElementById('education_level');
            const workExperience = document.getElementById('work_experience');
            const desiredPosition = document.getElementById('desired_position');
            const cv = document.getElementById('cv');
            
            if (!birthDate || !birthDate.value) {
                alert('Por favor, ingresa tu fecha de nacimiento');
                if (birthDate) birthDate.focus();
                isValid = false;
            }
            
            if (!educationLevel || !educationLevel.value) {
                alert('Por favor, selecciona tu nivel educativo');
                if (educationLevel) educationLevel.focus();
                isValid = false;
            }
            
            if (!workExperience || !workExperience.value.trim()) {
                alert('Por favor, describe tu experiencia laboral');
                if (workExperience) workExperience.focus();
                isValid = false;
            }
            
            if (!desiredPosition || !desiredPosition.value) {
                alert('Por favor, selecciona una posición deseada');
                if (desiredPosition) desiredPosition.focus();
                isValid = false;
            }
            
            if (!cv || !cv.value) {
                alert('Por favor, selecciona tu archivo CV');
                if (cv) cv.focus();
                isValid = false;
            }
        }
        
        if (step === 2) { // Validar paso 3 (Preguntas)
            const questions = document.querySelectorAll('.question-container');
            
            questions.forEach(question => {
                const requiredInput = question.querySelector('input[required], select[required], textarea[required]');
                if (requiredInput && !requiredInput.value.trim()) {
                    isValid = false;
                    if (!firstError) {
                        firstError = requiredInput;
                    }
                    // Resaltar pregunta con error
                    question.style.borderColor = '#ef4444';
                    question.style.backgroundColor = '#fef2f2';
                } else {
                    // Quitar resaltado si está correcto
                    question.style.borderColor = '';
                    question.style.backgroundColor = '';
                }
            });
            
            if (!isValid) {
                alert('Por favor, responde todas las preguntas requeridas');
                if (firstError) {
                    firstError.focus();
                    // Scroll a la primera pregunta con error
                    firstError.closest('.question-container').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                }
            }
        }
        
        return isValid;
    }

    // Manejar campos condicionales para familia (si existen)
    function setupConditionalFields() {
        const travelTypeRadios = document.querySelectorAll('input[name="travel_type"]');
        const familyDetails = document.getElementById('family-details');
        
        if (travelTypeRadios.length > 0 && familyDetails) {
            function toggleFamilyDetails() {
                const selectedValue = document.querySelector('input[name="travel_type"]:checked');
                if (selectedValue && selectedValue.value === 'familia') {
                    familyDetails.style.display = 'block';
                } else {
                    familyDetails.style.display = 'none';
                }
            }
            
            travelTypeRadios.forEach(radio => {
                radio.addEventListener('change', toggleFamilyDetails);
            });
            
            // Ejecutar al cargar la página
            toggleFamilyDetails();
        }
    }

    // Validación antes de enviar el formulario
    function setupFormValidation() {
        const form = document.getElementById('registrationForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Validar todos los pasos antes de enviar
                let allValid = true;
                
                for (let i = 0; i < totalSteps - 1; i++) {
                    if (!validateStep(i)) {
                        allValid = false;
                        // Ir al primer paso con error
                        nextStep(i);
                        break;
                    }
                }
                
                if (!allValid) {
                    e.preventDefault();
                    alert('Por favor, completa todos los campos requeridos antes de enviar el formulario.');
                } else {
                    // Mostrar mensaje de carga
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i> Enviando...';
                        submitBtn.disabled = true;
                    }
                }
            });
        }
    }

    // Inicializar todo cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
        setupConditionalFields();
        setupFormValidation();
        
        // Agregar validación en tiempo real para campos requeridos
        const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '';
                }
            });
        });
    });
</script>
</body>
</html>