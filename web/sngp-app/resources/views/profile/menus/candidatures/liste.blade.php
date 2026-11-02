<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Candidatures') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="candidatureModal()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- En-tête de section -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Liste des Candidatures</h3>
                            <p class="text-sm text-gray-500 mb-0">Consultez et gérez les soumissions pour ce marché.</p>
                        </div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-full">
                            Total : {{ $candidatures->count() }}
                        </span>
                    </div>

                    <!-- Tableau des Candidatures -->
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-gray-700 uppercase font-semibold">
                                <tr>
                                    <th class="py-3 px-4">Candidat / Entreprise</th>
                                    <th class="py-3 px-4">N° Registre (RCCM)</th>
                                    <th class="py-3 px-4">Prop. Financière</th>
                                    <th class="py-3 px-4">Statut Dossier</th>
                                    <th class="py-3 px-4">Statut Marché</th>
                                    <th class="py-3 px-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($candidatures as $candidature)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-4">
                                            <div class="font-semibold text-gray-900">{{ $candidature->nom_candidat }}</div>
                                            <div class="text-xs text-gray-500">{{ $candidature->email_candidat }}</div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="px-2.5 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded border border-gray-300">
                                                {{ $candidature->numero_registre_commerce }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="font-bold text-green-600">
                                                {{ number_format($candidature->proposition_financiere, 0, ',', ' ') }} FCFA
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($candidature->statut_candidature === 'accepté')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Accepté
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Refusé
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($candidature->statut_marche === 'tributaire')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Tributaire</span>
                                            @elseif($candidature->statut_marche === 'rejeté')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Rejeté</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">En attente</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <button type="button" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-50 border border-indigo-300 text-indigo-700 text-xs font-semibold rounded-md hover:bg-indigo-100 transition-colors"
                                                    @click="openDetails({{ json_encode($candidature) }})">
                                                Détails
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-8 text-gray-500">
                                            Aucune candidature enregistrée pour ce marché.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- Fenêtre Modale Alpine.js -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" 
             x-show="isOpen" 
             x-cloak
             style="display: none;">
            
            <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-4 overflow-hidden max-h-[90vh] flex flex-col"
                 @click.away="isOpen = false">
                
                <!-- Modal Header -->
                <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-lg">
                        Dossier de candidature : <span class="text-indigo-600" x-text="selectedCandidature?.nom_candidat"></span>
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 text-xl font-bold" @click="isOpen = false">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto flex-1" x-show="selectedCandidature">
                    <!-- Informations Générales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Email du Candidat</label>
                            <div class="font-semibold text-gray-900" x-text="selectedCandidature?.email_candidat || 'N/A'"></div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Registre de Commerce (RCCM)</label>
                            <div class="font-semibold text-gray-900" x-text="selectedCandidature?.numero_registre_commerce || 'N/A'"></div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Offre Financière</label>
                            <div class="text-lg font-bold text-green-600">
                                <span x-text="formatCurrency(selectedCandidature?.proposition_financiere)"></span> FCFA
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Statut & Evaluation</label>
                            <div class="flex gap-2">
                                <span class="px-2.5 py-0.5 rounded text-xs font-semibold text-white" 
                                      :class="selectedCandidature?.statut_candidature === 'accepté' ? 'bg-green-600' : 'bg-red-600'"
                                      x-text="selectedCandidature?.statut_candidature?.toUpperCase()"></span>
                                <span class="px-2.5 py-0.5 rounded text-xs font-semibold bg-gray-500 text-white" x-text="'Marché : ' + selectedCandidature?.statut_marche"></span>
                            </div>
                        </div>
                        <template x-if="selectedCandidature?.motif_statut">
                            <div class="col-span-2">
                                <div class="p-3 bg-blue-50 border border-blue-200 text-blue-800 rounded-md text-sm">
                                    <strong>Motif / Note :</strong> <span x-text="selectedCandidature?.motif_statut"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <hr class="my-4 border-gray-200">

                    <!-- Documents & Pièces Jointes -->
                    <h6 class="font-bold text-gray-800 mb-3">Documents Administratifs</h6>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                        <template x-for="(label, key) in documentFields" :key="key">
                            <div class="p-2 border border-gray-200 rounded flex justify-between items-center bg-gray-50">
                                <span class="text-xs text-gray-700 truncate mr-2" x-text="label"></span>
                                <template x-if="selectedCandidature && selectedCandidature[key]">
                                    <a :href="'/storage/' + selectedCandidature[key]" 
                                       target="_blank" 
                                       class="px-2.5 py-1 bg-indigo-600 text-white text-xs font-semibold rounded hover:bg-indigo-700 transition-colors">
                                        Voir
                                    </a>
                                </template>
                                <template x-if="!selectedCandidature || !selectedCandidature[key]">
                                    <span class="px-2 py-0.5 bg-gray-200 text-gray-500 text-xs rounded">Non fourni</span>
                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- Offre Technique -->
                    <template x-if="selectedCandidature?.proposition_technique && selectedCandidature?.proposition_technique.length > 0">
                        <div>
                            <h6 class="font-bold text-gray-800 mb-3">Offre Technique</h6>
                            <div class="overflow-x-auto border border-gray-200 rounded">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50 text-gray-700 font-semibold">
                                        <tr>
                                            <th class="py-2 px-3 text-left">Désignation</th>
                                            <th class="py-2 px-3 text-right">Quantité</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <template x-for="(item, index) in parseJson(selectedCandidature?.proposition_technique)" :key="index">
                                            <tr>
                                                <td class="py-2 px-3 text-gray-800" x-text="item.designation"></td>
                                                <td class="py-2 px-3 text-right font-semibold text-gray-900" x-text="item.quantite"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-3 bg-gray-50 border-t flex justify-between items-center">
                    <div>
                        <!-- Bouton conditionné au rôle Comité Technique -->
                        @can('designate-tributaire')
                            <template x-if="selectedCandidature && selectedCandidature.statut_candidature === 'accepté' && selectedCandidature.statut_marche === 'en attente'">
                                <form :action="'/marches/candidatures/' + selectedCandidature.id + '/arbitrer'" method="POST" onsubmit="return confirm('Confirmez-vous la désignation de ce candidat comme tributaire du marché ?');">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <input type="hidden" name="statut_candidature" value="accepté">
                                    <input type="hidden" name="statut_marche" value="tributaire">
                                    
                                    <button type="submit" 
                                            class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded shadow hover:bg-emerald-700 transition-colors inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Désigner comme Tributaire
                                    </button>
                                </form>
                            </template>
                        @endcan
                    </div>

                    <button type="button" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 text-xs font-semibold rounded hover:bg-gray-400 transition-colors" 
                            @click="isOpen = false">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Alpine.js -->
    <script>
        function candidatureModal() {
            return {
                isOpen: false,
                selectedCandidature: null,
                documentFields: {
                    'file_rccm': 'Registre de Commerce (RCCM)',
                    'file_acte_constitution': 'Acte de Constitution',
                    'file_dfe': 'Déclaration Fiscale d\'Existence (DFE)',
                    'file_arf': 'Attestation de Régularité Fiscale (ARF)',
                    'file_cnps': 'Attestation CNPS',
                    'file_attestation_bancaire': 'Attestation Bancaire'
                },
                openDetails(candidature) {
                    this.selectedCandidature = candidature;
                    this.isOpen = true;
                },
                formatCurrency(amount) {
                    if (!amount) return '0';
                    return new Intl.NumberFormat('fr-FR').format(amount);
                },
                parseJson(data) {
                    if (!data) return [];
                    if (typeof data === 'string') {
                        try {
                            return JSON.parse(data);
                        } catch (e) {
                            return [];
                        }
                    }
                    return data;
                }
            }
        }
    </script>
</x-app-layout>