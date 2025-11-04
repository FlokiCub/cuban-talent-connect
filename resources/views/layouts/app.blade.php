{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                    Cuban Talent Connect
                </a>
                
                <div class="hidden md:flex space-x-8 ml-10">
                    <a href="{{ route('candidate.register') }}" 
                       class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Registrarse como Candidato
                    </a>
                    
                    @auth
                        @if(auth()->check() && (auth()->user()->isInterviewer() || auth()->user()->isAdmin()))
                            <a href="{{ route('interviewer.dashboard') }}" 
                               class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    @if(auth()->check())
                        <span class="text-gray-700 text-sm">
                            Hola, {{ auth()->user()->name ?? 'Usuario' }}
                        </span>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                Cerrar Sesión
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>