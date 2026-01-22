<x-app-layout>
    <div class="lg:ml-64 transition-all duration-300">
        <header class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center px-8 justify-between">
            <h2 class="font-montserrat font-bold text-xl text-[#1B4F72] uppercase tracking-wide">
                {{ __('platforme web') }}
            </h2>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-500 italic">Connecté en tant que {{ Auth::user()->name }}</span>
                <div class="h-8 w-8 rounded-full bg-[#27AE60] flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <main class="p-8 bg-[#F4F7F6] min-h-[calc(100-4rem)]">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-[#27AE60]">
                        <p class="text-sm text-gray-500 font-medium">Budget Global</p>
                        <p class="text-2xl font-bold text-[#1B4F72] font-montserrat">450 000 000 FCFA</p>
                    </div>
                    </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 p-6">
                    <p class="text-[#2C3E50] font-inter">{{ __("Bienvenue dans votre espace de gestion transactionnelle.") }}</p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>