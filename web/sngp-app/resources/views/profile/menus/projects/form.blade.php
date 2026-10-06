<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-8">
            
            {{-- Entête du Formulaire --}}
            <div class="border-b border-gray-200 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                        {{ isset($project) && $project->exists ? 'Édition du Projet : ' . $project->code : 'Nouveau Projet d\'Investissement' }}
                    </h2>
                    <p class="mt-1 text-xs text-gray-600">
                        {{ isset($project) && $project->exists ? 'Modifier les paramètres et la structure du projet.' : 'Renseignez les informations générales. Si le code est laissé vide, il sera automatiquement généré.' }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('profile.menus.projects.list') }}" class="inline-flex items-center text-xs font-semibold text-gray-600 hover:text-gray-900">
                        ← Retour à la liste
                    </a>
                </div>
            </div>

            {{-- Formulaire unique pour Création ou Édition --}}
            <form action="{{ isset($project) && $project->exists ? route('projects.update', $project->id) : route('projects.store') }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($project) && $project->exists)
                    @method('PUT')
                @endif

                {{-- SECTION 1 : Identification & Classification --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b pb-2 flex items-center gap-2">
                        <span>📌</span> 1. Identification & Classification du Projet
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Code Projet (Personnalisable ou Automatique) --}}
                        <div>
                            <label for="code" class="block text-xs font-semibold text-gray-700 uppercase">
                                Code du Projet 
                                <span class="text-gray-400 font-normal">(Laisser vide pour génération auto)</span>
                            </label>
                            <input type="text" 
                                   name="code" 
                                   id="code" 
                                   value="{{ old('code', $project->code ?? '') }}" 
                                   placeholder="Ex: PROJ-BAD-001 ou laissé vide..." 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-mono font-bold text-cyan-900">
                            @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Nom du Projet --}}
                        <div>
                            <label for="nom" class="block text-xs font-semibold text-gray-700 uppercase">
                                Intitulé du Projet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nom" 
                                   id="nom" 
                                   value="{{ old('nom', $project->nom ?? '') }}" 
                                   required 
                                   placeholder="Ex: Projet d'extension du réseau électrique" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                            @error('nom') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Secteur d'Activité --}}
                        <div>
                            <label for="secteur_activite" class="block text-xs font-semibold text-gray-700 uppercase">
                                Secteur d'Activité <span class="text-red-500">*</span>
                            </label>
                            <select name="secteur_activite" id="secteur_activite" class="mt-1 block w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700" required>
                                <option value="" disabled {{ old('secteur_activite', $project->secteur_activite ?? '') == '' ? 'selected' : '' }}>-- Sélectionner un secteur --</option>
                                <option value="btp" {{ old('secteur_activite', $project->secteur_activite ?? '') == 'btp' ? 'selected' : '' }}>🚧 1. Bâtiment & Travaux Publics (BTP)</option>
                                <option value="sante" {{ old('secteur_activite', $project->secteur_activite ?? '') == 'sante' ? 'selected' : '' }}>🏥 2. Santé publique</option>
                                <option value="education" {{ old('secteur_activite', $project->secteur_activite ?? '') == 'education' ? 'selected' : '' }}>🎓 3. Éducation & Formation</option>
                                <option value="energie" {{ old('secteur_activite', $project->secteur_activite ?? '') == 'energie' ? 'selected' : '' }}>⚡ 4. Énergie, Eau & Assainissement</option>
                                <option value="tic" {{ old('secteur_activite', $project->secteur_activite ?? '') == 'tic' ? 'selected' : '' }}>💻 5. TIC & Numérique</option>
                                <option value="agriculture" {{ old('secteur_activite', $project->secteur_activite ?? '') == 'agriculture' ? 'selected' : '' }}>🚜 6. Agriculture & Halieutique</option>
                                <option value="transport" {{ old('secteur_activite', $project->secteur_activite ?? '') == 'transport' ? 'selected' : '' }}>🚗 7. Transports & Sécurité</option>
                            </select>
                            @error('secteur_activite') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Catégorie --}}
                        <div>
                            <label for="categorie" class="block text-xs font-semibold text-gray-700 uppercase">
                                Catégorie <span class="text-red-500">*</span>
                            </label>
                            <select name="categorie" id="categorie" class="mt-1 block w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700" required>
                                <option value="" disabled {{ old('categorie', $project->categorie ?? '') == '' ? 'selected' : '' }}>-- Sélectionner une catégorie --</option>
                                <option value="travaux" {{ old('categorie', $project->categorie ?? '') == 'travaux' ? 'selected' : '' }}>Travaux (TRV)</option>
                                <option value="fournitures" {{ old('categorie', $project->categorie ?? '') == 'fournitures' ? 'selected' : '' }}>Fournitures (FRN)</option>
                                <option value="services_courants" {{ old('categorie', $project->categorie ?? '') == 'services_courants' ? 'selected' : '' }}>Services courants (SVC)</option>
                                <option value="prestations_intellectuelles" {{ old('categorie', $project->categorie ?? '') == 'prestations_intellectuelles' ? 'selected' : '' }}>Prestations intellectuelles (INT)</option>
                            </select>
                            @error('categorie') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label for="description" class="block text-xs font-semibold text-gray-700 uppercase">Description du projet</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs" placeholder="Objectifs et portée globale du projet...">{{ old('description', $project->description ?? '') }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- SECTION 2 : Localisation Administrative --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b pb-2 flex items-center gap-2">
                        <span>🗺️</span> 2. Localisation Administrative Principale
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Région --}}
                        <div>
                            <label for="region" class="block text-xs font-semibold text-gray-700 uppercase">Région <span class="text-red-500">*</span></label>
                            <input type="text" name="region" id="region" value="{{ old('region', $project->region ?? '') }}" required placeholder="Ex: Poro" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                            @error('region') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Département --}}
                        <div>
                            <label for="departement" class="block text-xs font-semibold text-gray-700 uppercase">Département</label>
                            <input type="text" name="departement" id="departement" value="{{ old('departement', $project->departement ?? '') }}" placeholder="Ex: Korhogo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                            @error('departement') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Commune --}}
                        <div>
                            <label for="commune" class="block text-xs font-semibold text-gray-700 uppercase">Commune <span class="text-red-500">*</span></label>
                            <input type="text" name="commune" id="commune" value="{{ old('commune', $project->commune ?? '') }}" required placeholder="Ex: Korhogo Ville" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                            @error('commune') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Ville / Agglomération --}}
                        <div>
                            <label for="ville" class="block text-xs font-semibold text-gray-700 uppercase">Ville / Agglomération</label>
                            <input type="text" name="ville" id="ville" value="{{ old('ville', $project->ville ?? '') }}" placeholder="Ex: Korhogo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                            @error('ville') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

                {{-- SECTION 3 : Cadrage Financier & Calendrier --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6" x-data="{
                    budget: {{ old('budget_initial', $project->budget_initial ?? 0) }},
                    currency: '{{ old('budget_devise', $project->budget_devise ?? 'XOF') }}',
                    exchangeRate: {{ old('taux_change', $project->taux_change ?? 1) }},
                    pctBailleur: {{ old('pourcentage_bailleur', $project->pourcentage_bailleur ?? 80) }},
                    pctEtat: {{ old('pourcentage_etat', $project->pourcentage_etat ?? 20) }},
                    
                    // Taux par défaut vers le XOF (FCFA)
                    rates: {
                        'XOF': 1,
                        'USD': {{ $usdToXof ?? 605.20 }},
                        'EUR': 655.957
                    },

                    updateCurrency() {
                        this.exchangeRate = this.rates[this.currency] || 1;
                    },

                    get counterValueRaw() {
                        return (parseFloat(this.budget) || 0) * (parseFloat(this.exchangeRate) || 1);
                    },

                    get counterValue() {
                        return this.counterValueRaw.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    },

                    get finBailleur() {
                        return (this.counterValueRaw * ((parseFloat(this.pctBailleur) || 0) / 100)).toFixed(2);
                    },

                    get finEtat() {
                        return (this.counterValueRaw * ((parseFloat(this.pctEtat) || 0) / 100)).toFixed(2);
                    }
                }">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b pb-2 flex items-center gap-2">
                        <span>💰</span> 3. Enveloppe Budgétaire & Calendrier
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        {{-- Budget Initial --}}
                        <div>
                            <label for="budget_initial" class="block text-xs font-semibold text-gray-700 uppercase">Budget Initial <span class="text-red-500">*</span></label>
                            <input type="number" step="any" name="budget_initial" id="budget_initial" x-model="budget" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs font-bold">
                            @error('budget_initial') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Devise --}}
                        <div>
                            <label for="budget_devise" class="block text-xs font-semibold text-gray-700 uppercase">Devise <span class="text-red-500">*</span></label>
                            <select name="budget_devise" id="budget_devise" x-model="currency" x-on:change="updateCurrency()" class="mt-1 block w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700" required>
                                <option value="XOF">XOF (FCFA)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="USD">USD ($)</option>
                            </select>
                            @error('budget_devise') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Taux de Change --}}
                        <div>
                            <label for="taux_change" class="block text-xs font-semibold text-gray-700 uppercase">Taux de Change (vers XOF)</label>
                            <input type="number" step="any" name="taux_change" id="taux_change" x-model="exchangeRate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                            @error('taux_change') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Pourcentage Bailleur --}}
                        <div>
                            <label for="pourcentage_bailleur" class="block text-xs font-semibold text-gray-700 uppercase">% Part Bailleur</label>
                            <input type="number" step="0.01" name="pourcentage_bailleur" id="pourcentage_bailleur" x-model="pctBailleur" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                            <input type="hidden" name="financement_bailleur" :value="finBailleur">
                        </div>

                        {{-- Pourcentage État --}}
                        <div>
                            <label for="pourcentage_etat" class="block text-xs font-semibold text-gray-700 uppercase">% Part État</label>
                            <input type="number" step="0.01" name="pourcentage_etat" id="pourcentage_etat" x-model="pctEtat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                            <input type="hidden" name="financement_etat" :value="finEtat">
                        </div>

                        {{-- Contre-valeur Totale en XOF --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase">Contre-valeur Totale (XOF)</label>
                            <div class="mt-1 px-3 py-2 rounded-md border border-gray-200 bg-gray-50 text-emerald-700 font-bold text-xs" x-text="counterValue + ' XOF'">
                                0,00 XOF
                            </div>
                            <input type="hidden" name="budget_value" :value="counterValueRaw">
                        </div>

                        {{-- Date Démarrage --}}
                        <div>
                            <label for="start_date" class="block text-xs font-semibold text-gray-700 uppercase">Date de début</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($project->start_date) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                        </div>

                        {{-- Date Fin --}}
                        <div>
                            <label for="end_date" class="block text-xs font-semibold text-gray-700 uppercase">Date de fin prévisionnelle</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($project->end_date) && $project->end_date ? $project->end_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-700 focus:ring-cyan-700 text-xs">
                        </div>

                    </div>
                </div>

                {{-- SECTION 4 : Composantes / Modules --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4" x-data="{
                    modules: {{ json_encode(old('modules', isset($project) && $project->modules->isNotEmpty() ?$project->modules : [['number' => 1, 'description' => '', 'besoin_financier' => 0, 'duree' => '12 mois']])) }},
                    addModule() {
                        this.modules.push({ number: this.modules.length + 1, description: '', besoin_financier: 0, duree: '12 mois' });
                    },
                    removeModule(index) {
                        if (this.modules.length > 1) {
                            this.modules.splice(index, 1);
                        }
                    }
                }">
                    <div class="flex items-center justify-between border-b pb-2">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                            <span>⚙️</span> 4. Composantes / Modules
                        </h3>
                        <button type="button" @click="addModule()" class="text-xs bg-cyan-50 text-cyan-700 border border-cyan-200 px-3 py-1.5 rounded-md hover:bg-cyan-100 font-bold uppercase">
                            + Ajouter une composante
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(module, index) in modules" :key="index">
                            <div class="flex flex-col md:flex-row items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="w-full md:w-16">
                                    <label class="block text-[10px] font-bold uppercase text-gray-500">N°</label>
                                    <input type="text" :name="`modules[${index}][number]`" x-model="module.number" required class="w-full text-xs rounded border-gray-300">
                                </div>
                                <div class="w-full md:flex-1">
                                    <label class="block text-[10px] font-bold uppercase text-gray-500">Description de la composante</label>
                                    <input type="text" :name="`modules[${index}][description]`" x-model="module.description" required placeholder="Ex: Travaux de génie civil" class="w-full text-xs rounded border-gray-300">
                                </div>
                                <div class="w-full md:w-36">
                                    <label class="block text-[10px] font-bold uppercase text-gray-500">Besoin Financier</label>
                                    <input type="number" step="any" :name="`modules[${index}][besoin_financier]`" x-model="module.besoin_financier" required class="w-full text-xs rounded border-gray-300">
                                </div>
                                <div class="w-full md:w-28">
                                    <label class="block text-[10px] font-bold uppercase text-gray-500">Durée</label>
                                    <input type="text" :name="`modules[${index}][duree]`" x-model="module.duree" required class="w-full text-xs rounded border-gray-300">
                                </div>
                                <div class="pt-3">
                                    <button type="button" @click="removeModule(index)" class="text-red-500 hover:text-red-700 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Boutons d'action --}}
                <div class="flex items-center justify-end space-x-4 pt-4">
                    <a href="{{ route('profile.menus.projects.list') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-xs font-bold text-gray-700 hover:bg-gray-50 uppercase">
                        Annuler
                    </a>
                    <button type="submit" class="rounded-md bg-cyan-700 py-2.5 px-6 text-xs font-bold text-white hover:bg-cyan-800 uppercase shadow-sm">
                        {{ isset($project) &&$project->exists ? 'Mettre à jour le projet' : 'Enregistrer le Projet' }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>