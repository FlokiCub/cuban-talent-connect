<div class="bg-white card-shadow rounded-2xl p-8 border border-blue-200">
    <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-4">
            <i class="fas fa-user text-white text-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Información Personal</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo *</label>
            <div class="p-3 bg-blue-50 rounded-xl border border-blue-200">
                <strong class="text-blue-900">{{ auth()->user()->name }}</strong>
            </div>
            <input type="hidden" wire:model="name" value="{{ auth()->user()->name }}">
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
            <div class="p-3 bg-blue-50 rounded-xl border border-blue-200">
                <strong class="text-blue-900">{{ auth()->user()->email }}</strong>
            </div>
            <input type="hidden" wire:model="email" value="{{ auth()->user()->email }}">
        </div>

        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Teléfono *</label>
            <input type="tel" wire:model="phone" id="phone" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                   placeholder="Ej: +53 5xxx xxxx">
            @error('phone') 
                <span class="text-red-600 text-sm mt-2 block flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                </span> 
            @enderror
        </div>
    </div>

    <!-- Botones de Navegación -->
    <div class="mt-8 flex justify-end items-center pt-6 border-t border-gray-200">
        <button type="button" wire:click="next" 
                class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-300 font-semibold flex items-center">
            Siguiente
            <i class="fas fa-arrow-right ml-3"></i>
        </button>
    </div>
</div>