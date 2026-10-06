<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portefeuille des Projets') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Portefeuille des Projets</h2>
                    <p class="mt-2 text-sm text-gray-600">Vue d'ensemble des projets cofinancés BAD / État de Côte d'Ivoire et état d'avancement des enveloppes.</p>
                </div>
                
                @if(Auth::user()->hasRole('ugp'))
                    <div>
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition uppercase tracking-wider">
                            ➕ Initialiser un Projet
                        </a>
                    </div>
                @endif
            </div>

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

            @if($projects->isEmpty())
                <div class="text-center bg-white rounded-xl border border-gray-200 p-12 shadow-sm">
                    <span class="text-4xl">📁</span>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucun projet initialisé</h3>
                    <p class="mt-1 text-sm text-gray-500">Aucun dossier n'est actuellement enregistré dans le système.</p>
                </div>
            @endif

            @if(!$projects->isEmpty())
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    @foreach($projects as $project)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-200 overflow-hidden flex flex-col justify-between">
                            
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <span class="inline-flex items-center rounded-md bg-cyan-50 px-2.5 py-0.5 text-xs font-bold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider mb-2">
                                            {{ $project->code }}
                                        </span>
                                        <h3 class="text-xl font-bold text-gray-900 leading-tight">
                                            {{ $project->nom }}
                                        </h3>
                                    </div>
                                    
                                    @if(\Carbon\Carbon::parse($project->end_date)->isPast())
                                        <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10 whitespace-nowrap">
                                            🛑 Échu / En retard
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10 whitespace-nowrap">
                                            ⏱️ En cours
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-4 text-sm text-gray-600 line-clamp-2">
                                    {{ $project->description ?? 'Aucune description fournie pour ce projet.' }}
                                </p>

                                <div class="mt-6 grid grid-cols-2 gap-4 border-t border-gray-100 pt-4 bg-gray-50/50 -mx-6 px-6 pb-2">
                                    <div>
                                        <span class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Enveloppe Globale</span>
                                        <span class="text-lg font-bold text-cyan-700">
                                            {{ number_format($project->budget_initial, 0, ',', ' ') }} {{ $project->budget_devise }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Composantes (Modules)</span>
                                        <span class="text-lg font-bold text-gray-800">
                                            {{ $project->modules->count() }} module(s)
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4 text-xs">
                                    @php
    // Récupère les modules qui n'ont absolument aucun marché lié
    $modulesSansMarche = $project->modules->filter(fn($module) => $module->markets->isEmpty())->count();
@endphp

@if($modulesSansMarche > 0)
    <div class="p-3 bg-red-50 border border-red-100 text-red-700 rounded-xl text-xs font-medium flex items-center gap-2">
        <span>⚠️</span>
        <span>
            <strong>{{ $modulesSansMarche }}</strong> 
            {{ $modulesSansMarche > 1 ? 'composantes sans aucun marché créé' : 'composante sans aucun marché créé' }}.
        </span>
    </div>
@endif
                                </div>
                            </div>

                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between text-sm">
                                <span class="text-xs text-gray-500 font-medium">
                                    Échéance : <strong>{{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</strong>
                                </span>
                                
                                {{-- ROUTE CORRIGÉE ICI : Appelle maintenant la méthode GET du formulaire --}}
                                <a href="{{ route('projects.edit', $project->id) }}" class="inline-flex items-center font-bold text-cyan-700 hover:text-cyan-800 transition group">
                                    Consulter les détails 
                                    <span class="ml-1 transform group-hover:translate-x-1 transition-transform">→</span>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>