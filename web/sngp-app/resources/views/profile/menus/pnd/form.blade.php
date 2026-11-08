<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($pndVersion) ? __('Modifier la Version PND') : __('Créer une Version PND') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- En-tête de page -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between border-b border-gray-200 pb-5 gap-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                        {{ isset($pndVersion) ? 'Édition du PND' : 'Nouvelle Version du PND' }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Configuration du cadre stratégique et des piliers fondamentaux de développement.
                    </p>
                </div>
                <div>
                    <a href="{{ route('profile.menus.pnd.list') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition uppercase tracking-wider">
                        ← Retour à la liste
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

            <form action="{{ isset($pndVersion) ? route('profile.menus.pnd.update', $pndVersion->id) : route('profile.menus.pnd.store') }}" method="POST">
                @csrf
                @if(isset($pndVersion))
                    @method('PUT')
                @endif

                <!-- Section 1 : Informations Générales de la Version -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6 p-6 space-y-6">
                    <div class="border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-900">1. Paramètres de la Version PND</h3>
                        <p class="text-xs text-gray-500">Définissez le libellé, la période de validité et le statut d'activation.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Intitulé / Nom de la Version -->
                        <div class="md:col-span-2">
                            <label for="version" class="block text-xs font-bold uppercase text-gray-700 tracking-wider mb-2">
                                Intitulé de la Version <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="version" id="version" value="{{ old('version', $pndVersion->version ?? 'PND 2026-2030') }}" placeholder="Ex: PND 2026-2030" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                        </div>

                        <!-- Date de Début -->
                        <div>
                            <label for="start_date" class="block text-xs font-bold uppercase text-gray-700 tracking-wider mb-2">
                                Date de Début <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($pndVersion) ? \Carbon\Carbon::parse($pndVersion->start_date)->format('Y-m-d') : '2026-01-01') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                        </div>

                        <!-- Date de Fin -->
                        <div>
                            <label for="end_date" class="block text-xs font-bold uppercase text-gray-700 tracking-wider mb-2">
                                Date de Fin <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($pndVersion) ? \Carbon\Carbon::parse($pndVersion->end_date)->format('Y-m-d') : '2030-12-31') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm">
                        </div>

                        <!-- Statut -->
                        <div class="flex items-center justify-between md:col-span-2 pt-2 bg-gray-50/50 p-4 rounded-lg border border-gray-100">
                            <div>
                                <label for="is_active" class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $pndVersion->is_active ?? true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-cyan-700 shadow-sm focus:ring-cyan-500 h-4 w-4">
                                    <span class="ml-2 text-sm font-semibold text-gray-800">Définir comme Version Active</span>
                                </label>
                                <p class="text-xs text-gray-500 ml-6 mt-0.5">Une seule version peut être active à la fois pour les nouveaux projets.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2 : Configuration Dynamique des Piliers Stratégiques -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8 p-6">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">2. Piliers Stratégiques</h3>
                            <p class="text-xs text-gray-500">Ajoutez, modifiez ou supprimez les piliers stratégiques associés à ce PND.</p>
                        </div>
                        <button type="button" id="add-pilier-btn" class="inline-flex items-center gap-1 px-3 py-2 bg-cyan-700 text-white text-xs font-bold rounded-md hover:bg-cyan-800 transition shadow-sm">
                            ➕ Ajouter un pilier
                        </button>
                    </div>

                    @php
                        $defaultPiliers = [
                            (object)['id' => null, 'numero' => 1, 'libelle' => "Paix, sécurité et stabilité durables"],
                            (object)['id' => null, 'numero' => 2, 'libelle' => "Moderniser l'agriculture, sécuriser la tenure foncière rurale, augmenter la productivité et renforcer les chaînes de valeur agricoles"],
                            (object)['id' => null, 'numero' => 3, 'libelle' => "Promouvoir l'investissement privé et les champions nationaux, et réduire l'informalité"],
                            (object)['id' => null, 'numero' => 4, 'libelle' => "Développer le capital humain et les compétences, et créer des emplois décents"],
                            (object)['id' => null, 'numero' => 5, 'libelle' => "Développer des infrastructures stratégiques et des pôles économiques régionaux ; transition écologique, résilience climatique et économie circulaire"],
                            (object)['id' => null, 'numero' => 6, 'libelle' => "Promouvoir la bonne gouvernance et moderniser l'État"]
                        ];

                        $piliersList = isset($pndVersion) && $pndVersion->piliers->count() > 0 
                            ? $pndVersion->piliers 
                            : $defaultPiliers;
                    @endphp

                    <div id="piliers-container" class="space-y-4">
                        @foreach($piliersList as $index => $pilier)
                            <div class="pilier-item p-4 rounded-lg bg-gray-50 border border-gray-200 flex flex-col md:flex-row gap-4 items-start md:items-center relative">
                                <div class="flex-shrink-0 flex items-center gap-2">
                                    <span class="w-9 h-9 rounded-full bg-cyan-700 text-white flex items-center justify-center font-bold text-sm numero-badge">
                                        {{ $pilier->numero ?? $index + 1 }}
                                    </span>
                                    <input type="hidden" name="piliers[{{ $index }}][numero]" value="{{ $pilier->numero ?? $index + 1 }}" class="input-numero">
                                    @if(isset($pilier->id))
                                        <input type="hidden" name="piliers[{{ $index }}][id]" value="{{ $pilier->id }}">
                                    @endif
                                </div>
                                <div class="w-full">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Libellé du Pilier <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="piliers[{{ $index }}][libelle]" rows="2" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"
                                        placeholder="Description officielle du pilier">{{ $pilier->libelle }}</textarea>
                                </div>
                                <button type="button" class="remove-pilier text-red-500 hover:text-red-700 font-bold text-sm px-2 py-1 self-end md:self-center transition" title="Supprimer ce pilier">
                                    ❌
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('profile.menus.pnd.list') }}" class="px-5 py-2.5 rounded-md border border-gray-300 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-emerald-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition uppercase tracking-wider">
                        💾 {{ isset($pndVersion) ? 'Mettre à jour le PND' : 'Enregistrer le PND' }}
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Script JavaScript pour la gestion dynamique des piliers -->
    @push('scripts')
    <script>
        document.getElementById('add-pilier-btn').addEventListener('click', function() {
            let container = document.getElementById('piliers-container');
            let index = container.querySelectorAll('.pilier-item').length;
            
            let html = `
                <div class="pilier-item p-4 rounded-lg bg-gray-50 border border-gray-200 flex flex-col md:flex-row gap-4 items-start md:items-center relative">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <span class="w-9 h-9 rounded-full bg-cyan-700 text-white flex items-center justify-center font-bold text-sm numero-badge">
                            ${index + 1}
                        </span>
                        <input type="hidden" name="piliers[${index}][numero]" value="${index + 1}" class="input-numero">
                    </div>
                    <div class="w-full">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Libellé du Pilier <span class="text-red-500">*</span>
                        </label>
                        <textarea name="piliers[${index}][libelle]" rows="2" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 text-sm"
                            placeholder="Description officielle du pilier"></textarea>
                    </div>
                    <button type="button" class="remove-pilier text-red-500 hover:text-red-700 font-bold text-sm px-2 py-1 self-end md:self-center transition" title="Supprimer ce pilier">
                        ❌
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-pilier')) {
                let item = e.target.closest('.pilier-item');
                let container = document.getElementById('piliers-container');
                
                // Empêcher de supprimer s'il ne reste qu'un seul pilier
                if (container.querySelectorAll('.pilier-item').length <= 1) {
                    alert('Le PND doit contenir au moins un pilier stratégique.');
                    return;
                }

                item.remove();
                
                // Réindexer les numéros et les noms d'attributs name="piliers[X][...]"
                document.querySelectorAll('.pilier-item').forEach((el, idx) => {
                    el.querySelector('.numero-badge').innerText = idx + 1;
                    el.querySelector('.input-numero').value = idx + 1;
                    el.querySelector('textarea').name = `piliers[${idx}][libelle]`;
                    el.querySelector('.input-numero').name = `piliers[${idx}][numero]`;
                    
                    let idInput = el.querySelector('input[type="hidden"][name*="[id]"]');
                    if (idInput) {
                        idInput.name = `piliers[${idx}][id]`;
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>