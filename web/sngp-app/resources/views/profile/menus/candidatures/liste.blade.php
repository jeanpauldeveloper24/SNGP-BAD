<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto">

                    <!-- En-tête -->
                    <div class="mb-8 border-b border-gray-200 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-3xl font-bold tracking-tight text-gray-900">Registre des Candidatures</h2>
                            <p class="mt-2 text-sm text-gray-600">
                                Espace d'arbitrage et d'évaluation des offres techniques et financières par le Comité d'Analyse.
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center rounded-md bg-cyan-50 px-3 py-2 text-xs font-bold text-cyan-700 ring-1 ring-inset ring-cyan-700/10 uppercase tracking-wider">
                                Supervision UGP
                            </span>
                        </div>
                    </div>

                    <!-- Notification Flash -->
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-600 rounded-r-xl shadow-sm text-xs text-emerald-800 font-medium">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Conteneur Principal / Tableau -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        @if($candidatures->isEmpty())
                        <div class="p-12 text-center">
                            <div class="text-4xl mb-3">📥</div>
                            <p class="text-sm font-medium text-gray-500">Aucune candidature n'a encore été déposée sur le portail.</p>
                        </div>
                        @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-left text-xs">
                                <thead class="bg-gray-50 text-gray-400 uppercase font-semibold tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4">Soumissionnaire / RCCM</th>
                                        <th class="px-6 py-4">Marché Visé & Enveloppe</th>
                                        <th class="px-6 py-4">Offre Financière</th>
                                        <th class="px-6 py-4">Statut Système</th>
                                        <th class="px-6 py-4 text-right">Actions Decisionnelles</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                                    @foreach($candidatures as $candidature)
                                    <tr class="hover:bg-gray-50/80 transition">

                                        <!-- Soumissionnaire -->
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900 text-sm">{{ $candidature->nom_candidat }}</div>
                                            <div class="text-[10px] font-mono text-gray-400 mt-0.5">{{ $candidature->numero_registre_commerce }}</div>
                                        </td>

                                        <!-- Marché Visé -->
                                        <td class="px-6 py-4 max-w-xs">
                                            <div class="truncate text-gray-950" title="{{ $candidature->market->objet ?? 'Marché inconnu' }}">
                                                {{ $candidature->market->objet ?? 'Marché inconnu' }}
                                            </div>
                                            <div class="text-[10px] font-mono font-bold text-cyan-700 mt-0.5">
                                                Max alloué : {{ number_format($candidature->market->besoin_financier_fcfa ?? 0, 0, ',', ' ') }} CFA
                                                <span class="text-gray-400 font-normal">({{ number_format($candidature->market->besoin_financier, 0, ',', ' ') }} {{ $candidature->market->devise }})</span>
                                            </div>
                                        </td>

                                        <!-- Offre Financière -->
                                        <td class="px-6 py-4 font-mono font-bold text-sm">
                                            {{ number_format($candidature->proposition_financiere, 0, ',', ' ') }} CFA
                                        </td>

                                        <!-- Statut -->
                                        <td class="px-6 py-4">
                                            @if($candidature->status === 'Rejeté Automatiquement')
                                            <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-xs font-bold text-red-700 ring-1 ring-inset ring-red-600/10">
                                                🛑 Éliminé d'office
                                            </span>
                                            @elseif($candidature->status === 'Accepté')
                                            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                                ✅ Validé / Attribué
                                            </span>
                                            @else
                                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700 ring-1 ring-inset ring-amber-600/10 animate-pulse">
                                                ⏳ En attente d'analyse
                                            </span>
                                            @endif
                                        </td>

                                        <!-- Actions Decisionnelles (Modal Alpine.js) -->
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end space-x-2" x-data="{ openModal: false }">

                                                @if($candidature->status === 'Rejeté Automatiquement')
                                                <span class="text-[11px] text-red-500 italic font-normal max-w-xs block text-right" title="{{ $candidature->motif_statut }}">
                                                    {{ Str::limit($candidature->motif_statut, 45) }}
                                                </span>
                                                @else
                                                <button @click="openModal = true" class="rounded-lg bg-gray-900 hover:bg-gray-800 text-white px-3 py-1.5 font-bold transition uppercase tracking-wider text-[10px]">
                                                    Évaluer l'offre →
                                                </button>
                                                @endif

                                                <!-- Fenêtre Modale d'évaluation -->
                                                <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                                                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                                        <div @click.away="openModal = false" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">

                                                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                                                <h3 class="text-sm font-bold text-gray-900 uppercase">Analyse du dossier : {{ $candidature->nom_candidat }}</h3>
                                                                <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 font-bold">&times;</button>
                                                            </div>

                                                            <form action="{{ route('menus.candidatures.arbitrer', $candidature->id) }}" method="POST" class="p-6 space-y-4">
                                                                @csrf

                                                                <div>
                                                                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Mémoire Technique du Soumissionnaire</h4>
                                                                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-gray-800 text-xs font-normal leading-relaxed max-h-60 overflow-y-auto">
                                                                        @php
                                                                        $items = is_string($candidature->proposition_technique)
                                                                        ? json_decode($candidature->proposition_technique, true)
                                                                        : $candidature->proposition_technique;
                                                                        @endphp

                                                                        @if(is_array($items) && count($items) > 0)
                                                                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden bg-white">
                                                                            <thead class="bg-gray-100 font-semibold text-gray-600 text-[11px] uppercase">
                                                                                <tr>
                                                                                    <th class="px-3 py-2 text-left">Désignation</th>
                                                                                    <th class="px-3 py-2 text-right">Quantité</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="divide-y divide-gray-100">
                                                                                @foreach($items as $item)
                                                                                <tr class="hover:bg-gray-50">
                                                                                    <td class="px-3 py-2 text-gray-900 font-medium">{{ $item['designation'] ?? '-' }}</td>
                                                                                    <td class="px-3 py-2 text-right font-bold text-indigo-600 font-mono">{{ $item['quantite'] ?? '-' }}</td>
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                        @else
                                                                        <!-- Fallback au cas où ce n'est pas un JSON structuré -->
                                                                        <p class="whitespace-pre-line text-gray-700">{{ $candidature->proposition_technique }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                                                                    <div class="text-left">
                                                                        <label class="block text-[11px] font-semibold text-gray-700 uppercase">Sentence du Comité</label>
                                                                        <select name="status" class="mt-1 block w-full rounded-lg border-gray-300 text-xs font-bold" required>
                                                                            <option value="Accepté">Adjuger le marché (Accepter)</option>
                                                                            <option value="Rejeté">Rejeter la candidature</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="text-left">
                                                                        <label class="block text-[11px] font-semibold text-gray-700 uppercase">Observations / Motif (Si rejet)</label>
                                                                        <input type="text" name="motif_statut" placeholder="ex: Note technique insuffisante..." class="mt-1 block w-full rounded-lg border-gray-300 text-xs">
                                                                    </div>
                                                                </div>

                                                                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                                                                    <button type="button" @click="openModal = false" class="rounded-lg border border-gray-300 bg-white py-2 px-4 font-bold text-gray-700 hover:bg-gray-50 uppercase tracking-wider text-[10px]">
                                                                        Fermer
                                                                    </button>
                                                                    <button type="submit" class="rounded-lg bg-emerald-600 py-2 px-5 font-bold text-white hover:bg-emerald-700 uppercase tracking-wider text-[10px]">
                                                                        Valider le Verdict
                                                                    </button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>