<x-app-layout>
    <x-slot name="header">
        Tableau de bord
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 text-sm font-semibold uppercase">Budget Global Portefeuille</h3>
                <div class="p-2 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-[#1B4F72]">
                {{ number_format($projects->sum('budget_in_fcfa'), 0, ',', ' ') }} FCFA
            </p>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-green-500 font-bold mr-1">↑ Portefeuille BAD</span>
                <span>{{ $projects->count() }} Projets actifs</span>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
        <p class="text-gray-600 italic">
            Bienvenue dans votre espace de gestion transactionnelle <strong>SNGP-BAD</strong>. 
            Utilisez le menu latéral pour accéder aux différentes fonctionnalités de votre rôle : 
            <span class="text-[#27AE60] font-bold">{{ Auth::user()->role->name }}</span>.
        </p>
    </div>
</x-app-layout>