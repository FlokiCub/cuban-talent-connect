<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <!-- Font Awesome para los íconos -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="min-h-screen bg-gray-50">
        <!-- Navegación Superior Personalizada -->
        <nav class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-hotel text-white text-lg"></i>
                            </div>
                            <span class="text-2xl font-bold text-gray-800">
                                Cuban Talent Connect
                            </span>
                        </a>
                    </div>

                    <!-- Navigation Links - Centrado -->
                    <div class="hidden md:flex items-center space-x-1">
                        <!-- Enlace de Registro siempre visible -->
                        <a href="{{ route('candidate.register') }}" 
                           class="flex items-center space-x-2 px-6 py-3 rounded-xl text-sm font-semibold transition duration-200 
                                  {{ request()->routeIs('candidate.register') ? 'bg-blue-100 text-blue-700 border border-blue-300' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                            <i class="fas fa-user-plus {{ request()->routeIs('candidate.register') ? 'text-blue-600' : 'text-blue-500' }}"></i>
                            <span>Registrarse como Candidato</span>
                        </a>
                        
                        @auth
                            @if(auth()->user()->isInterviewer() || auth()->user()->isAdmin())
                                <a href="{{ route('interviewer.dashboard') }}" 
                                   class="flex items-center space-x-2 px-6 py-3 rounded-xl text-sm font-semibold transition duration-200 
                                          {{ request()->routeIs('interviewer.dashboard') ? 'bg-green-100 text-green-700 border border-green-300' : 'text-gray-700 hover:text-green-600 hover:bg-green-50' }}">
                                    <i class="fas fa-tachometer-alt {{ request()->routeIs('interviewer.dashboard') ? 'text-green-600' : 'text-green-500' }}"></i>
                                    <span>Dashboard Entrevistador</span>
                                </a>
                            @endif

                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center space-x-2 px-6 py-3 rounded-xl text-sm font-semibold transition duration-200 
                                      {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-700 border border-purple-300' : 'text-gray-700 hover:text-purple-600 hover:bg-purple-50' }}">
                                <i class="fas fa-home {{ request()->routeIs('dashboard') ? 'text-purple-600' : 'text-purple-500' }}"></i>
                                <span>Dashboard</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Right Side - User Menu -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <div class="flex items-center space-x-3 bg-gray-50 px-4 py-2 rounded-xl border border-gray-200">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-800">
                                    @if(auth()->user()->isInterviewer())
                                        <span class="text-blue-600">Entrevistador</span>
                                    @elseif(auth()->user()->isCandidate())
                                        <span class="text-green-600">Candidato</span>
                                    @else
                                        <span class="text-purple-600">Usuario</span>
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Dropdown permanente -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="flex items-center text-gray-600 hover:text-blue-600 focus:outline-none transition duration-200">
                                    <div class="w-10 h-10 bg-gray-100 hover:bg-blue-100 rounded-xl flex items-center justify-center border border-gray-200 hover:border-blue-300">
                                        <i class="fas fa-chevron-down text-gray-500"></i>
                                    </div>
                                </button>
                                
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     @click.away="open = false"
                                     class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-200 py-2 z-50">
                                    
                                    <!-- Información del usuario -->
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                                    </div>

                                    <!-- Perfil -->
                                    <a href="{{ route('profile.edit') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition duration-150">
                                        <i class="fas fa-user-edit text-blue-500 w-5"></i>
                                        <span>Mi Perfil</span>
                                    </a>

                                    <!-- Configuración -->
                                    <a href="{{ route('profile.edit') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition duration-150">
                                        <i class="fas fa-cog text-blue-500 w-5"></i>
                                        <span>Configuración</span>
                                    </a>

                                    <!-- Logout -->
                                    <form method="POST" action="{{ route('logout') }}" class="w-full border-t border-gray-100 mt-1">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center space-x-3 w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition duration-150">
                                            <i class="fas fa-sign-out-alt text-red-500 w-5"></i>
                                            <span>Cerrar Sesión</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Enlaces para usuarios no autenticados -->
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('login') }}" 
                                   class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 px-4 py-2 rounded-xl text-sm font-semibold transition duration-200 hover:bg-blue-50">
                                    <i class="fas fa-sign-in-alt text-blue-500"></i>
                                    <span>Iniciar Sesión</span>
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white hover:from-blue-700 hover:to-purple-700 px-6 py-3 rounded-xl text-sm font-semibold transition duration-200 shadow-md hover:shadow-lg">
                                    <i class="fas fa-user-tie"></i>
                                    <span>Entrevistador</span>
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden border-t border-gray-200 pt-4 pb-2">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('candidate.register') }}" 
                           class="flex items-center justify-center space-x-2 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 
                                  {{ request()->routeIs('candidate.register') ? 'bg-blue-100 text-blue-700 border border-blue-300' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                            <i class="fas fa-user-plus {{ request()->routeIs('candidate.register') ? 'text-blue-600' : 'text-blue-500' }}"></i>
                            <span>Registro Candidato</span>
                        </a>
                        
                        @auth
                            @if(auth()->user()->isInterviewer() || auth()->user()->isAdmin())
                                <a href="{{ route('interviewer.dashboard') }}" 
                                   class="flex items-center justify-center space-x-2 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 
                                          {{ request()->routeIs('interviewer.dashboard') ? 'bg-green-100 text-green-700 border border-green-300' : 'text-gray-700 hover:text-green-600 hover:bg-green-50' }}">
                                    <i class="fas fa-tachometer-alt {{ request()->routeIs('interviewer.dashboard') ? 'text-green-600' : 'text-green-500' }}"></i>
                                    <span>Dashboard</span>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" 
                                   class="flex items-center justify-center space-x-2 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 
                                          {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-700 border border-purple-300' : 'text-gray-700 hover:text-purple-600 hover:bg-purple-50' }}">
                                    <i class="fas fa-home {{ request()->routeIs('dashboard') ? 'text-purple-600' : 'text-purple-500' }}"></i>
                                    <span>Dashboard</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="flex items-center justify-center space-x-2 px-4 py-3 rounded-xl text-sm font-semibold transition duration-200 
                                      {{ request()->routeIs('login') ? 'bg-blue-100 text-blue-700 border border-blue-300' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                                <i class="fas fa-sign-in-alt {{ request()->routeIs('login') ? 'text-blue-600' : 'text-blue-500' }}"></i>
                                <span>Iniciar Sesión</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido Principal -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- AlpineJS para el dropdown -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        @fluxScripts
    </body>
</html>