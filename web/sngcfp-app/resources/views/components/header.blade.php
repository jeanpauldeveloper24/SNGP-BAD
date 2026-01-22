<header x-data="{ open: false }" class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">

            <div class="flex items-center space-x-3">
                <div class="flex items-center space-x-2">
                    <x-application-logo type="app" class="h-10 w-auto" />
                    <span class="font-bold text-xl text-[#1B4F72]">SNGP - BAD</span>
                </div>
            </div>

            <nav class="hidden md:flex space-x-6 text-sm font-medium">
                <x-nav-link :href="url('/')" :active="request()->is('/')">Accueil</x-nav-link>
                <x-nav-link :href="route('presentation')" :active="request()->routeIs('presentation')">Présentation</x-nav-link>
                <x-nav-link :href="route('fonctionnalites')" :active="request()->routeIs('fonctionnalites')">Fonctionnalités</x-nav-link>
            </nav>

            <div class="hidden md:flex items-center space-x-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">
                            <x-primary-button class="bg-[#27AE60] hover:bg-[#219150] active:bg-[#1e7d44]">
                                Dashboard
                            </x-primary-button>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <x-secondary-button>Se connecter</x-secondary-button>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">
                                <x-primary-button>S'inscrire</x-primary-button>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <div class="flex md:hidden">
                <button @click="open = ! open" class="text-gray-500 hover:text-[#1B4F72] focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-gray-50 border-t border-gray-200">
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">Accueil</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('presentation')" :active="request()->routeIs('presentation')">Présentation</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('fonctionnalites')" :active="request()->routeIs('fonctionnalites')">Fonctionnalités</x-responsive-nav-link>
        </div>
        
        <div class="pt-4 pb-6 border-t border-gray-200 px-6 space-y-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block w-full">
                        <x-primary-button class="w-full justify-center bg-[#27AE60]">
                            Tableau de Bord
                        </x-primary-button>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full">
                        <x-secondary-button class="w-full justify-center">
                            Se connecter
                        </x-secondary-button>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full">
                            <x-primary-button class="w-full justify-center">
                                S'inscrire
                            </x-primary-button>
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</header>