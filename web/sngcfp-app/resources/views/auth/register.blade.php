<x-guest-layout>
    <div class="w-full">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-[#F4F7F6] rounded-full mb-4 shadow-sm border border-gray-100">
                <svg class="w-10 h-10 text-[#1B4F72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-[#2C3E50] font-montserrat uppercase tracking-tight">S'inscrire</h2>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="relative">
                <x-text-input id="name" 
                    class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus 
                    placeholder="Nom & Prénoms" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="relative">
                <x-text-input id="email" 
                    class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    placeholder="Adresse e-mail" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="relative">
                <x-text-input id="password" 
                    class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password" 
                    placeholder="Mot de passe" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="relative">
                <x-text-input id="password_confirmation" 
                    class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#27AE60] focus:ring-[#27AE60] rounded-lg shadow-sm font-inter"
                    type="password"
                    name="password_confirmation" 
                    required 
                    placeholder="Confirmer mot de passe" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-8 text-center">
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-[#27AE60] hover:bg-[#219150] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#27AE60] transition-all duration-200">
                    S'inscrire
                </button>
                
                <p class="mt-4 text-sm text-gray-600">
                    Déjà inscrit ? 
                    <a href="{{ route('login') }}" class="text-[#2E86C1] font-bold hover:text-[#1B4F72] transition-colors">
                        Se connecter
                    </a>
                </p>
            </div>
        </form>

        <div class="mt-10 pt-6 border-t border-gray-100 flex justify-center items-center">
            <p class="text-xs text-gray-400 font-inter">
                © 2026 SNGP-BAD — République de Côte d'Ivoire
            </p>
        </div>
    </div>
</x-guest-layout>