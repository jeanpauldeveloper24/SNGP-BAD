<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Découpage Administratif (Circonscriptions)') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- En-tête de page -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Circonscriptions Administratives</h2>
                    <p class="mt-2 text-sm text-gray-600">Arborescence et gestion des subdivisions territoriales de Côte d'Ivoire.</p>
                </div>
                
                @if(Auth::user()->hasRole('administrateur_systeme'))
                    <div>
                        <a href="{{ route('profile.menus.circonscription.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition uppercase tracking-wider">
                            ➕ Nouvelle Circonscription
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

            <!-- Tableau d'affichage des Circonscriptions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Code INS / Officiel</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nom de la Circonscription</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Niveau Administrative</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Chef-Lieu</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rattachement (Parent)</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($circonscriptions as $circo)
                            <tr class="hover:bg-gray-50/50 transition">
                                <!-- Code Officiel -->
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-mono font-bold text-cyan-700">
                                    {{ $circo->code_officiel ?? 'N/A' }}
                                </td>

                                <!-- Nom -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $circo->nom }}
                                </td>

                                <!-- Type / Niveau avec Badges Distincts -->
                                <td class="px-6 py-4 whitespace-nowrap text-xs">
                                    <span class="px-2.5 py-1 text-xs rounded-full uppercase font-bold 
                                        @if($circo->type == 'district_autonome') bg-purple-50 text-purple-700 ring-1 ring-purple-600/10 
                                        @elseif($circo->type == 'region') bg-blue-50 text-blue-700 ring-1 ring-blue-600/10 
                                        @elseif($circo->type == 'departement') bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10 
                                        @elseif($circo->type == 'sous_prefecture') bg-amber-50 text-amber-700 ring-1 ring-amber-600/10 
                                        @else bg-gray-100 text-gray-700 ring-1 ring-gray-600/10 @endif">
                                        {{ str_replace('_', ' ', $circo->type) }}
                                    </span>
                                </td>

                                <!-- Chef-Lieu -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $circo->chef_lieu ?? '-' }}
                                </td>

                                <!-- Parent -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($circo->parent)
                                        <span class="font-medium text-gray-700">{{ $circo->parent->nom }}</span>
                                        <span class="text-xs text-gray-400">({{ str_replace('_', ' ', $circo->parent->type) }})</span>
                                    @else
                                        <span class="text-xs italic text-gray-400">Racine / Niveau National</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('profile.menus.circonscription.edit', $circo->id) }}" class="text-cyan-700 hover:text-cyan-900 font-bold">
                                        ✏️ Éditer
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                    Aucune circonscription enregistrée dans le système. Avez-vous exécuté les seeders ?
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($circonscriptions->hasPages())
                <div class="mt-6">
                    {{ $circonscriptions->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>