<!-- Botones de Navegación -->
<div class="mt-8 flex justify-between items-center bg-white p-6 rounded-2xl card-shadow border border-blue-200">
    @if($currentStep > 0)
        <button type="button" wire:click="previousStep" 
                class="px-8 py-4 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition duration-300 font-semibold flex items-center">
            <i class="fas fa-arrow-left mr-3"></i>
            Anterior
        </button>
    @else
        <div></div>
    @endif

    @if($currentStep < count($steps) - 1)
        <button type="button" wire:click="nextStep" 
                class="px-8 py-4 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition duration-300 font-semibold flex items-center">
            Siguiente
            <i class="fas fa-arrow-right ml-3"></i>
        </button>
    @else
        <button type="submit" 
                class="px-10 py-4 bg-green-600 text-white rounded-xl hover:bg-green-700 transition duration-300 font-semibold flex items-center">
            <i class="fas fa-paper-plane mr-3"></i>
            Enviar Solicitud
        </button>
    @endif
</div>