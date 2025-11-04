<div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
    <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mr-4">
            <i class="fas fa-briefcase text-white text-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Información Profesional</h2>
    </div>
    
    <div class="grid grid-cols-1 gap-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Nacimiento *</label>
                <input type="date" wire:model="birth_date" id="birth_date" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('birth_date') 
                    <span class="text-red-600 text-sm mt-2 block flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                    </span> 
                @enderror
            </div>

            <div>
                <label for="education_level" class="block text-sm font-semibold text-gray-700 mb-2">Nivel Educativo *</label>
                <select wire:model="education_level" id="education_level" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">Selecciona tu nivel educativo...</option>
                    <option value="Secundaria Básica">Secundaria Básica</option>
                    <option value="Técnico Medio">Técnico Medio</option>
                    <option value="Preuniversitario">Preuniversitario</option>
                    <option value="Universitario">Universitario</option>
                    <option value="Master">Master</option>
                    <option value="Doctorado">Doctorado</option>
                </select>
                @error('education_level') 
                    <span class="text-red-600 text-sm mt-2 block flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                    </span> 
                @enderror
            </div>
        </div>

        <div>
            <label for="desired_position" class="block text-sm font-semibold text-gray-700 mb-2">Posición Deseada *</label>
            <select wire:model="desired_position" id="desired_position" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <option value="">Selecciona una posición...</option>
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
            @error('desired_position') 
                <span class="text-red-600 text-sm mt-2 block flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                </span> 
            @enderror
        </div>

        <div>
            <label for="work_experience" class="block text-sm font-semibold text-gray-700 mb-2">Experiencia Laboral *</label>
            <textarea wire:model="work_experience" id="work_experience" rows="4"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                      placeholder="Describe tu experiencia laboral en hoteles, restaurantes, turismo o servicio al cliente..."></textarea>
            @error('work_experience') 
                <span class="text-red-600 text-sm mt-2 block flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                </span> 
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="languages" class="block text-sm font-semibold text-gray-700 mb-2">Idiomas que dominas</label>
                <input type="text" wire:model="languages" id="languages" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Ej: Español, Inglés básico, Francés intermedio">
            </div>

            <div>
                <label for="skills" class="block text-sm font-semibold text-gray-700 mb-2">Habilidades profesionales</label>
                <input type="text" wire:model="skills" id="skills" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Ej: Atención al cliente, Trabajo en equipo, Cocina internacional">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="desired_salary" class="block text-sm font-semibold text-gray-700 mb-2">Salario Deseado (opcional)</label>
                <input type="number" wire:model="desired_salary" id="desired_salary" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Ej: 15000">
            </div>

            <div>
                <label for="cv" class="block text-sm font-semibold text-gray-700 mb-2">Curriculum Vitae *</label>
                <input type="file" wire:model="cv" id="cv" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                @error('cv') 
                    <span class="text-red-600 text-sm mt-2 block flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                    </span> 
                @enderror
            </div>
        </div>

        <div>
            <label for="about_me" class="block text-sm font-semibold text-gray-700 mb-2">Sobre Mí (opcional)</label>
            <textarea wire:model="about_me" id="about_me" rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                      placeholder="Cuéntanos sobre tus objetivos profesionales, intereses..."></textarea>
        </div>
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