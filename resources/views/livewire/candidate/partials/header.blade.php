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
                <span class="text-blue-900">{{ Auth::user()->name }}</span> 
                <span class="text-blue-700">({{ Auth::user()->email }})</span>
            </p>
        </div>
        @endauth
    </div>
</div>