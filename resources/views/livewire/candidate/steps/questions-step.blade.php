<div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
    <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-4">
            <i class="fas fa-question-circle text-white text-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Preguntas Adicionales</h2>
    </div>
    
    <div class="space-y-6">
        @foreach($questions as $question)
        <div class="border-l-4 border-purple-500 pl-6 bg-purple-50 rounded-xl p-6">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                {{ $question->question_text }}
                @if($question->is_required) <span class="text-red-500">*</span> @endif
            </label>
            
            @if($question->question_type === 'text')
                <textarea wire:model="answers.{{ $question->id }}" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                          rows="3"
                          placeholder="Escribe tu respuesta aquí..."></textarea>
            @elseif($question->question_type === 'select')
                <select wire:model="answers.{{ $question->id }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200">
                    <option value="">Selecciona una opción...</option>
                    @foreach($question->options as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            @endif
            @error('answers.' . $question->id) 
                <span class="text-red-600 text-sm mt-2 block flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                </span> 
            @enderror
        </div>
        @endforeach
    </div>

    <!-- Botones de Navegación -->
    <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
        <button type="button" wire:click="previous" 
                class="px-8 py-4 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition duration-300 font-semibold flex items-center">
            <i class="fas fa-arrow-left mr-3"></i>
            Anterior
        </button>

        <button type="button" wire:click="next" 
                class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-300 font-semibold flex items-center">
            Siguiente
            <i class="fas fa-arrow-right ml-3"></i>
        </button>
    </div>
</div>