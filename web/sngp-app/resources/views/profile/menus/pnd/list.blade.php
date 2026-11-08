<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plan National de Développement (PND)') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- En-tête de page -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Plan National de Développement</h2>
                    <p class="mt-2 text-sm text-gray-600">Vue d'ensemble des cadres PND et de leurs piliers stratégiques de référence.</p>
                </div>
                
                @if(Auth::user()->hasRole('administrateur_systeme'))
                    <div>
                        <a href="{{ route('profile.menus.pnd.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition uppercase tracking-wider">
                            ➕ Nouvelle Version PND
                        </a>
                    </div>
                @endif
            </div>

            <!-- Messages de notification -->
            @if(session('success'))
                <div class="mb-6 rounded-md bg-emerald-50 p-4 border-l-4 border-emerald-600">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-emerald-600 font-bold">✅</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Etat vide -->
            @if($pndVersions->isEmpty())
                <div class="text-center bg-white rounded-xl border border-gray-200 p-12 shadow-sm">
                    <span class="text-4xl">🏛️</span>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune version PND configurée</h3>
                    <p class="mt-1 text-sm text-gray-500">Aucun cadre de développement n'est actuellement enregistré dans le système.</p>
                </div>
            @endif

            <!-- Liste des versions PND et piliers -->
            @if(!$pndVersions->isEmpty())
                <div class="space-y-8">
                    @foreach($pndVersions as $version)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            
                            <!-- Header de la Version -->
                            <div class="p-6 bg-white border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <span class="inline-flex items-center rounded-md bg-cyan-50 px-2.5 py-0.5 text-xs font-bold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider mb-2">
                                        Cadre Stratégique
                                    </span>
                                    <h3 class="text-2xl font-bold text-gray-900 leading-tight">
                                        {{ $version->version }}
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Période d'exécution : <strong>{{ \Carbon\Carbon::parse($version->start_date)->format('d/m/Y') }}</strong> au <strong>{{ \Carbon\Carbon::parse($version->end_date)->format('d/m/Y') }}</strong>
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if($version->is_active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10 whitespace-nowrap">
                                            ⏱️ Version Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 whitespace-nowrap">
                                            Archivée / Inactive
                                        </span>
                                    @endif

                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 whitespace-nowrap">
                                        {{ $version->piliers->count() }} Piliers
                                    </span>
                                </div>
                            </div>

                            <!-- Grille des Piliers Stratégiques -->
                            <div class="p-6 bg-gray-50/50">
                                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Piliers Stratégiques Définis</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($version->piliers as $pilier)
                                        <div class="bg-white p-5 rounded-lg border border-gray-100 shadow-sm flex flex-col justify-between hover:border-cyan-200 transition">
                                            <div>
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="w-8 h-8 rounded-full bg-cyan-700 text-white flex items-center justify-center font-bold text-sm">
                                                        P{{ $pilier->numero }}
                                                    </span>
                                                    <span class="text-xs font-semibold text-gray-400">Pilier {{ $pilier->numero }}</span>
                                                </div>
                                                <p class="text-sm font-medium text-gray-800 leading-snug">
                                                    {{ $pilier->libelle }}
                                                </p>
                                            </div>

                                            <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between text-xs text-gray-500">
                                                <span>Projets rattachés</span>
                                                <strong class="text-gray-900 font-bold">{{ $pilier->projects_count ?? $pilier->projects()->count() }}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Footer Card -->
                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end text-sm">
                                <span class="text-xs text-gray-500 font-medium mr-auto">
                                    Mis à jour le {{ $version->updated_at->format('d/m/Y à H:i') }}
                                </span>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>