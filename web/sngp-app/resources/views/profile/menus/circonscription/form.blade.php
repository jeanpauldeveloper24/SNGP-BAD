<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($circonscription) ? __('Modifier la Circonscription') : __('Ajouter une Circonscription') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- En-tête de page -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                        {{ isset($circonscription) ? 'Édition de Circonscription' : 'Nouvelle Circonscription Administrative' }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Gestion du découpage territorial et rattachement hiérarchique au réseau national.
                    </p>
                </div>
                <div>
                    <a href="{{ route('profile.menus.circonscription.list') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition uppercase tracking-wider">
                        ← Retour au découpage
                    </a>
                </div>
            </div>

            <!-- Affichage des erreurs de validation -->
            @if ($errors->any())
                <div class="mb-6 rounded-md bg-red-50 p-4 border-l-4 border-red-600">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-red-600 font-bold">⚠️</span>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Des erreurs sont survenues dans votre formulaire :</h3>
                            <ul class="mt-2 list-disc list-inside text-xs text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ isset($circonscription) ? route('profile.menus.circonscription.update', $circonscription->id) : route('profile.menus.circonscription.store') }}" method="POST">
                @csrf
                @if(isset($circonscription))
                    @method('PUT')
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8 p-6 space-y-6">
                    <div class="border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-900">Caractéristiques Territoriales</h3>
                        <p class="text-xs text-gray-500">Renseignez le nom, la typologie administrative et l'entité parente.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Nom de la circonscription -->
                        <div class="md:col-span-2">
                            <label for="nom" class="block text-xs font-bold uppercase text-gray-700 tracking-wider mb-2">
                                Nom de la Circonscription <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $circonscription->nom ?? '') }}" placeholder="Ex: Bélier, Yamoussoukro, Bouaké..." required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                        </div>

                        <!-- Code Officiel -->
                        <div>
                            <label for="code_officiel" class="block text-xs font-bold uppercase text-gray-700 tracking-wider mb-2">
                                Code Officiel / INS (Optionnel)
                            </label>
                            <input type="text" name="code_officiel" id="code_officiel" value="{{ old('code_officiel', $circonscription->code_officiel ?? '') }}" placeholder="Ex: REG-01, DEP-04"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm font-mono">
                        </div>

                        <!-- Type de circonscription -->
                        <div>
                            <label for="type" class="block text-xs font-bold uppercase text-gray-700 tracking-wider mb-2">
                                Niveau / Type Administratif <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                                <option value="" disabled {{ !isset($circonscription) ? 'selected' : '' }}>-- Sélectionner un niveau --</option>
                                <option value="district_autonome" {{ old('type', $circonscription->type ?? '') == 'district_autonome' ? 'selected' : '' }}>District Autonome / District</option>
                                <option value="region" {{ old('type', $circonscription->type ?? '') == 'region' ? 'selected' : '' }}>Région</option>
                                <option value="departement" {{ old('type', $circonscription->type ?? '') == 'departement' ? 'selected' : '' }}>Département</option>
                                <option value="sous_prefecture" {{ old('type', $circonscription->type ?? '') == 'sous_prefecture' ? 'selected' : '' }}>Sous-Préfecture</option>
                                <option value="commune" {{ old('type', $circonscription->type ?? '') == 'commune' ? 'selected' : '' }}>Commune</option>
                            </select>
                        </div>

                        <!-- Chef-Lieu -->
                        <div>
                            <label for="chef_lieu" class="block text-xs font-bold uppercase text-gray-700 tracking-wider mb-2">
                                Chef-Lieu (Optionnel)
                            </label>
                            <input type="text" name="chef_lieu" id="chef_lieu" value="{{ old('chef_lieu', $circonscription->chef_lieu ?? '') }}" placeholder="Ex: Toumodi, Korhogo..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                        </div>

                        <!-- Circonscription Parente (Parent ID) -->
                        <div>
                            <label for="parent_id" class="block text-xs font-bold uppercase text-gray-700 tracking-wider mb-2">
                                Rattachement Hiérarchique (Parent)
                            </label>
                            <select name="parent_id" id="parent_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                                <option value="">-- Aucun (Entité Racine / District) --</option>
                                @foreach($parents as $parent)
                                    @if(!isset($circonscription) || $circonscription->id !== $parent->id)
                                        <option value="{{ $parent->id }}" 
                                            data-type="{{ $parent->type }}"
                                            {{ old('parent_id', $circonscription->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                            [{{ strtoupper(str_replace('_', ' ', $parent->type)) }}] {{ $parent->nom }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Laissez vide s'il s'agit d'un District principal de niveau 1.</p>
                        </div>

                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('profile.menus.circonscription.list') }}" class="px-5 py-2.5 rounded-md border border-gray-300 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition uppercase tracking-wider">
                        💾 {{ isset($circonscription) ? 'Mettre à jour la Circonscription' : 'Enregistrer la Circonscription' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>