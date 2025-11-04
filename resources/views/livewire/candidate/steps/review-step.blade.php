<div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
    <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mr-4">
            <i class="fas fa-clipboard-check text-white text-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Revisa tu Información</h2>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Información Personal -->
        <div class="space-y-6">
            <h3 class="text-xl font-semibold text-gray-800 border-b-2 border-blue-200 pb-3 flex items-center">
                <i class="fas fa-user-circle text-blue-500 mr-3"></i>
                Información Personal
            </h3>
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                <strong class="text-blue-700 block mb-1">Nombre:</strong>
                <p class="text-gray-800 text-lg">{{ $formData['name'] }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                <strong class="text-blue-700 block mb-1">Email:</strong>
                <p class="text-gray-800 text-lg">{{ $formData['email'] }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                <strong class="text-blue-700 block mb-1">Teléfono:</strong>
                <p class="text-gray-800 text-lg">{{ $formData['phone'] }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                <strong class="text-blue-700 block mb-1">Fecha de Nacimiento:</strong>
                <p class="text-gray-800 text-lg">
                    @if($formData['birth_date'])
                        {{ \Carbon\Carbon::parse($formData['birth_date'])->format('d/m/Y') }}
                    @else
                        <span class="text-red-500">No especificada</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Información Profesional -->
        <div class="space-y-6">
            <h3 class="text-xl font-semibold text-gray-800 border-b-2 border-green-200 pb-3 flex items-center">
                <i class="fas fa-briefcase text-green-500 mr-3"></i>
                Información Profesional
            </h3>
            <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                <strong class="text-green-700 block mb-1">Posición Deseada:</strong>
                <p class="text-gray-800 text-lg">{{ $formData['desired_position'] ?: 'No especificada' }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                <strong class="text-green-700 block mb-1">Nivel Educativo:</strong>
                <p class="text-gray-800 text-lg">{{ $formData['education_level'] ?: 'No especificado' }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                <strong class="text-green-700 block mb-1">Idiomas:</strong>
                <p class="text-gray-800 text-lg">{{ $formData['languages'] ?: 'No especificados' }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                <strong class="text-green-700 block mb-1">Habilidades:</strong>
                <p class="text-gray-800 text-lg">{{ $formData['skills'] ?: 'No especificadas' }}</p>
            </div>
            @if($formData['desired_salary'])
            <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                <strong class="text-green-700 block mb-1">Salario Deseado:</strong>
                <p class="text-gray-800 text-lg">${{ number_format($formData['desired_salary'], 2) }} CUP</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Experiencia Laboral -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 border-b-2 border-purple-200 pb-3 mb-4 flex items-center">
            <i class="fas fa-history text-purple-500 mr-3"></i>
            Experiencia Laboral
        </h3>
        <div class="bg-purple-50 p-6 rounded-xl border border-purple-200">
            <p class="text-gray-800 whitespace-pre-line text-lg leading-relaxed">
                {{ $formData['work_experience'] ?: 'No especificada' }}
            </p>
        </div>
    </div>

    <!-- Sobre Mí -->
    @if($formData['about_me'])
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 border-b-2 border-indigo-200 pb-3 mb-4 flex items-center">
            <i class="fas fa-star text-indigo-500 mr-3"></i>
            Sobre Mí
        </h3>
        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200">
            <p class="text-gray-800 whitespace-pre-line text-lg leading-relaxed">{{ $formData['about_me'] }}</p>
        </div>
    </div>
    @endif

    <!-- Respuestas a Preguntas -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 border-b-2 border-orange-200 pb-3 mb-4 flex items-center">
            <i class="fas fa-comments text-orange-500 mr-3"></i>
            Respuestas a Preguntas
        </h3>
        <div class="space-y-4">
            @foreach($questions as $question)
                @if(isset($formData['answers'][$question->id]) && !empty($formData['answers'][$question->id]))
                <div class="bg-orange-50 p-5 rounded-xl border border-orange-200">
                    <strong class="text-orange-700 block mb-2 text-lg">{{ $question->question_text }}</strong>
                    <p class="text-gray-800 text-lg">{{ $formData['answers'][$question->id] }}</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Alerta Importante -->
    <div class="p-6 bg-yellow-50 border border-yellow-300 rounded-2xl mb-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mr-4"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">¡Importante!</h3>
                <div class="text-yellow-700 text-lg">
                    <p>
                        Por favor, revisa cuidadosamente toda tu información antes de enviar. 
                        Una vez enviado el formulario, no podrás modificar estos datos. 
                        Los entrevistadores de hoteles podrán ver esta información cuando evalúen tu perfil.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de Navegación -->
    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
        <button type="button" wire:click="previous" 
                class="px-8 py-4 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition duration-300 font-semibold flex items-center">
            <i class="fas fa-arrow-left mr-3"></i>
            Anterior
        </button>

        <button type="button" wire:click="submit" 
                class="px-10 py-4 bg-green-600 text-white rounded-xl hover:bg-green-700 transition duration-300 font-semibold flex items-center">
            <i class="fas fa-paper-plane mr-3"></i>
            Enviar Solicitud
        </button>
    </div>
</div>