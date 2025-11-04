{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                    Cuban Talent Connect
                </a>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-8 ml-10">
                    <!-- Enlace de Registro siempre visible -->
                    <a href="{{ route('candidate.register') }}" 
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Registrarse como Candidato
                    </a>
                    
                    @auth
                        @if(auth()->user()->isInterviewer() || auth()->user()->isAdmin())
                            <a href="{{ route('interviewer.dashboard') }}" 
                               class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Dashboard Entrevistador
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-gray-700 text-sm">
                        Hola, 
                        @if(auth()->user()->isInterviewer())
                            <span class="font-medium">Entrevistador: {{ auth()->user()->name }}</span>
                        @elseif(auth()->user()->isCandidate())
                            <span class="font-medium">Candidato: {{ auth()->user()->name }}</span>
                        @else
                            <span class="font-medium">{{ auth()->user()->name }}</span>
                        @endif
                    </span>
                    
                    <!-- Dropdown permanente -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center text-sm text-gray-600 hover:text-gray-900 focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <!-- Logout permanente usando el método POST de Breeze -->
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Enlaces para usuarios no autenticados -->
                    <a href="{{ route('login') }}" 
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                        Registrarse como Entrevistador
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>