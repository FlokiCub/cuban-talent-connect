<!-- Mensajes -->
@if (session()->has('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
            {{ session('error') }}
        </div>
    </div>
@endif