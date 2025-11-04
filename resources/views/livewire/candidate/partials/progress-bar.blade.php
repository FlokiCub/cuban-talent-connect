<!-- Progress Bar -->
<div class="mb-8 bg-white card-shadow rounded-2xl p-6 border border-blue-200">
    <div class="flex justify-between mb-4">
        @foreach($steps as $index => $step)
            <div class="text-center">
                <div class="w-8 h-8 rounded-full {{ $index <= $currentStep ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white' : 'bg-gray-300 text-gray-600' }} flex items-center justify-center mx-auto mb-2 font-bold">
                    {{ $index + 1 }}
                </div>
                <span class="text-sm font-medium {{ $index <= $currentStep ? 'text-blue-600' : 'text-gray-500' }}">
                    {{ ucfirst($step) }}
                </span>
            </div>
        @endforeach
    </div>
    <div class="w-full bg-gray-200 rounded-full h-3">
        @php
            $total = count($steps);
            $progress = $total > 0 ? (($currentStep + 1) / $total) * 100 : 0;
        @endphp
        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full transition-all duration-500 ease-out" 
             style="width: {{ $progress }}%"></div>
    </div>
</div>