<x-guest-layout>
    <div class="w-full">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-[#F4F7F6] rounded-full mb-4 shadow-sm border border-gray-100">
                <svg class="w-10 h-10 text-[#1B4F72]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-[#2C3E50] font-montserrat uppercase tracking-tight">Connexion</h2>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="relative">
                <x-text-input id="email" 
                    class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#2E86C1] focus:ring-[#2E86C1] rounded-lg shadow-sm font-inter" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    placeholder="Adresse e-mail" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="relative mt-4">
                <x-text-input id="password" 
                    class="block w-full pl-4 pr-10 py-3 border-gray-300 focus:border-[#2E86C1] focus:ring-[#2E86C1] rounded-lg shadow-sm font-inter"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                    placeholder="Mot de passe" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#1B4F72] shadow-sm focus:ring-[#1B4F72]" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-[#2E86C1] hover:text-[#1B4F72] hover:underline transition-colors font-medium" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <div class="mt-8 text-center">
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-[#1B4F72] hover:bg-[#2E86C1] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1B4F72] transition-all duration-200">
                    Se Connecter
                </button>
                
                <p class="mt-4 text-sm text-gray-600">
                    Vous n'avez pas de compte ? 
                    <a href="{{ route('register') }}" class="text-[#2E86C1] font-bold hover:text-[#1B4F72] transition-colors">
                        Enregistrez-vous
                    </a>
                </p>
            </div>
        </form>

        <div class="mt-10 pt-6 border-t border-gray-100 flex justify-center items-center">
            <a href="{{ url('/presentation') }}" class="text-sm font-medium text-gray-500 hover:text-[#1B4F72] flex items-center gap-1 transition-colors group">
                <span>Consulter la Présentation</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</x-guest-layout>