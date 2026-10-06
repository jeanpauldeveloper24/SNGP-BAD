<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouveau marché public
        </h2>
    </x-slot>

    <div class="py-12" x-data="marcheForm(@js($projects))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Nouveau marché public</h1>
                    <p class="text-gray-600">Renseignez les informations générales, le rattachement au projet et les spécifications du marché.</p>
                </div>

                <form action="{{ route('passation.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- N° de Référence -->
                        <div>
                            <label for="reference" class="block text-sm font-medium text-gray-700">N° de Référence</label>
                            <input type="text" name="reference" id="reference" placeholder="Ex: DAO-001/PORO/2026"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <!-- Objet du marché -->
                        <div>
                            <label for="objet" class="block text-sm font-medium text-gray-700">Objet du marché <span class="text-red-500">*</span></label>
                            <input type="text" name="objet" id="objet" required placeholder="Ex: Fourniture et pose de matériel..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <!-- Projet associé -->
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Projet associé <span class="text-red-500">*</span></label>
                            <select name="project_id" id="project_id" required x-model="selectedProjectId" @change="onProjectChange"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- Sélectionner un projet --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->code }} - {{ $project->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Composante / Module -->
                        <div>
                            <label for="module_id" class="block text-sm font-medium text-gray-700">Composante / Module</label>
                            <select name="module_id" id="module_id" x-model="selectedModuleId" @change="onModuleChange"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- Sélectionner une composante --</option>
                                <template x-for="module in availableModules" :key="module.id">
                                    <option :value="module.id" x-text="module.description"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Méthode de Passation -->
                        <div>
                            <label for="methode_passation" class="block text-sm font-medium text-gray-700">Méthode de Passation</label>
                            <select name="methode_passation" id="methode_passation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- Mode de passation --</option>
                                <option value="AOI">Appel d'Offres International (AOI)</option>
                                <option value="AON">Appel d'Offres National (AON)</option>
                                <option value="AOR">Appel d'Offres Restreint</option>
                                <option value="Gré à Gré">Gré à Gré / Entente Directe</option>
                            </select>
                        </div>

                        <!-- Étape actuelle -->
                        <div>
                            <label for="etape_actuelle" class="block text-sm font-medium text-gray-700">Étape actuelle</label>
                            <select name="etape_actuelle" id="etape_actuelle"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="EXPRESSION_BESOIN">01 - Expression du besoin</option>
                                <option value="REDACTION_DAO">02 - Rédaction du DAO</option>
                                <option value="VALIDATION_DGMP">03 - Validation DGMP</option>
                                <option value="PUBLICATION_AVIS">04 - Publication de l'Avis</option>
                                <option value="RECEPTION_OFFRES">05 - Réception des offres</option>
                                <option value="OUVERTURE_PLIS">06 - Ouverture des plis</option>
                                <option value="EVALUATION_TECHNIQUE">07 - Évaluation Technique</option>
                                <option value="ATTRIBUTION_PROVISOIRE">08 - Attribution Provisoire</option>
                                <option value="SIGNATURE_CONTRAT">09 - Signature du Contrat</option>
                                <option value="ORDRE_SERVICE">10 - Ordre de Service (OS)</option>
                                <option value="PREMIER_VERSEMENT">11 - 1er versement</option>
                                <option value="EXECUTION_TRAVAUX">12 - Exécution des travaux</option>
                                <option value="SECOND_VERSEMENT">13 - 2nd versement</option>
                                <option value="RECEPTION_DEFINITIVE">14 - Réception définitive</option>
                            </select>
                        </div>

                        <!-- Montant Prévisionnel / Besoin Financier -->
                        <div>
                            <label for="montant_previsionnel" class="block text-sm font-medium text-gray-700">Montant Prévisionnel / Besoin Financier</label>
                            <input type="number" step="0.01" name="montant_previsionnel" id="montant_previsionnel" x-model="besoinFinancier"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <!-- Devise -->
                        <div>
                            <label for="devise" class="block text-sm font-medium text-gray-700">Devise</label>
                            <select name="devise" id="devise"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="USD">USD ($)</option>
                                <option value="XOF">FCFA (XOF)</option>
                                <option value="EUR">Euro (EUR)</option>
                            </select>
                        </div>

                        <!-- Statut d'Attribution -->
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700">Statut d'Attribution</label>
                            <select name="statut" id="statut"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="Non attribué">Non attribué</option>
                                <option value="En cours d'attribution">En cours d'attribution</option>
                                <option value="Attribué">Attribué</option>
                                <option value="Annulé">Annulé</option>
                            </select>
                        </div>

                        <!-- Titulaire / Prestataire Adjugé -->
                        <div>
                            <label for="prestataire_id" class="block text-sm font-medium text-gray-700">Titulaire / Prestataire Adjugé</label>
                            <select name="prestataire_id" id="prestataire_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">-- Aucun titulaire (Non attribué) --</option>
                                @foreach($prestataires as $prestataire)
                                    <option value="{{ $prestataire->id }}">{{ $prestataire->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date de Dépôt (Début) -->
                        <div>
                            <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de Dépôt (Début)</label>
                            <input type="date" name="date_debut" id="date_debut"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>

                        <!-- Date Limite Dépôt (Fin) -->
                        <div>
                            <label for="date_fin" class="block text-sm font-medium text-gray-700">Date Limite Dépôt (Fin)</label>
                            <input type="date" name="date_fin" id="date_fin"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                    </div>

                    <!-- Spécifications techniques (Formulaire Tableau JSON) -->
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-semibold text-gray-800">Spécifications techniques / Besoins matériels</label>
                            <button type="button" @click="addItem()" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-md shadow-sm">
                                + Ajouter une ligne
                            </button>
                        </div>

                        <!-- Hidden Input envoyé au Controller en JSON -->
                        <input type="hidden" name="specifications" :value="JSON.stringify(items)">

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-md">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Désignation</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Quantité</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-5/12">Spécifications</th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="item.designation" placeholder="Ex: Panneaux Solaires 550Wp"
                                                    class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="item.quantite" placeholder="Ex: 2400 unités"
                                                    class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="item.specification" placeholder="Ex: Rendement 21.3%, Garantie 25 ans"
                                                    class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                <button type="button" @click="removeItem(index)" class="text-red-600 hover:text-red-900 font-bold text-sm">
                                                    &times;
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-start space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                            Enregistrer le marché
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function marcheForm(initialProjects) {
            return {
                projects: initialProjects || [],
                selectedProjectId: '',
                selectedModuleId: '',
                availableModules: [],
                besoinFinancier: 0,
                items: [
                    { designation: '', quantite: '', specification: '' }
                ],

                addItem() {
                    this.items.push({ designation: '', quantite: '', specification: '' });
                },

                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },

                onProjectChange() {
                    const proj = this.projects.find(p => String(p.id) === String(this.selectedProjectId));
                    if (proj && proj.modules) {
                        this.availableModules = proj.modules;
                    } else {
                        this.availableModules = [];
                    }
                    this.selectedModuleId = '';
                    this.besoinFinancier = 0;
                },

                onModuleChange() {
                    const mod = this.availableModules.find(m => String(m.id) === String(this.selectedModuleId));
                    if (mod) {
                        this.besoinFinancier = mod.besoin_financier || 0;
                    } else {
                        this.besoinFinancier = 0;
                    }
                }
            };
        }
    </script>
</x-app-layout>