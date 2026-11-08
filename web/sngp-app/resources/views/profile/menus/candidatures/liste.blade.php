<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- En-tête de la page -->
            <div class="mb-8 border-b border-gray-200 pb-5 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                        Liste des Candidatures
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Suivi des soumissions d'entreprises et arbitrage des marchés publics.
                    </p>
                </div>

                <!-- Badge indiquant le rôle connecté -->
                <div class="mt-4 md:mt-0 flex items-center space-x-2">
                    <span class="text-xs text-gray-500">Connecté en tant que :</span>
                    <span class="px-3 py-1 bg-cyan-50 text-cyan-800 text-xs font-bold rounded-full border border-cyan-200">
                        {{ Auth::user()->role->label ?? 'Utilisateur' }}
                    </span>
                </div>
            </div>

            <!-- Tableau des candidatures -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-[#1B4F72]">Dossiers soumis</h3>
                        <p class="text-xs text-gray-500">Examen des offres techniques et financières des prestataires</p>
                    </div>

                    @if(Auth::user()->role->name === 'comite_technique')
                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full border border-amber-200">
                        Mode Arbitrage Activé
                    </span>
                    @else
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full border border-gray-200">
                        Mode Consultation
                    </span>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Candidat / Entreprise</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date de soumission</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Offre Financière</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Statut Marché</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @forelse($candidatures as $candidature)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    {{ $candidature->nom_candidat }} <br>
                                    <span class="text-xs text-gray-500 font-normal">{{ $candidature->email-candidat }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    {{ $candidature->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-gray-700">
                                    {{ number_format($candidature->proposition_financiere ?? 0, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($candidature->statut_marche === 'tributaire')
                                    <span class="px-2.5 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-md">
                                        Attributaire
                                    </span>
                                    @elseif($candidature->statut_marche === 'rejeté')
                                    <span class="px-2.5 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-md">
                                        Rejeté
                                    </span>
                                    @else
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-md">
                                        En attente
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">

                                    {{-- 1. BOUTON DE CONSULTATION DU DOSSIER (Sécurisé avec l'opérateur nullsafe) --}}
                                    <a href="{{ route('pages.candidature-form', $candidature->market?->id ?? $candidature->market_id) }}"
                                        class="text-gray-600 hover:text-gray-900 bg-gray-100 px-3 py-1.5 rounded-lg transition text-xs">
                                        Voir l'offre
                                    </a>

                                    {{-- 2. BOUTON / MODALE RÉSERVÉ AU COMITÉ TECHNIQUE --}}
                                    @if(Auth::user()->role->name === 'comite_technique')
                                    <button type="button"
                                        onclick="openEvaluationModal('{{ $candidature->id }}', '{{ addslashes($candidature->company_name ?? $candidature->name) }}', '{{ $candidature->statut_candidature }}', '{{ $candidature->statut_marche }}', '{{ addslashes($candidature->motif_statut ?? '') }}')"
                                        class="text-white bg-[#27AE60] hover:bg-green-700 px-3 py-1.5 rounded-lg transition text-xs font-bold shadow-sm">
                                        Arbitrer / Évaluer
                                    </button>
                                    @endif

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">
                                    Aucune candidature enregistrée pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- FENÊTRE MODALE D'ÉVALUATION (Comité Technique uniquement) -->
    <div id="evaluationModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden transform transition-all">

            <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#1B4F72]" id="modalCandidateTitle">Évaluation de la candidature</h3>
                <button type="button" onclick="closeEvaluationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Formulaire relié à la méthode evaluer -->
            <form id="evaluationForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Statut de la Candidature</label>
                    <select name="statut_candidature" id="modalStatutCandidature" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                        <option value="accepté">Accepté (Conforme)</option>
                        <option value="refusé">Refusé (Non conforme)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Statut du Marché (Attribution)</label>
                    <select name="statut_marche" id="modalStatutMarche" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" required>
                        <option value="en attente">En attente</option>
                        <option value="tributaire">Tributaire (Attributaire retenu)</option>
                        <option value="rejeté">Rejeté</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Motif / Commentaire de l'arbitrage</label>
                    <textarea name="motif_statut" id="modalMotif" rows="3" class="w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" placeholder="Précisez le motif de la décision..."></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEvaluationModal()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#27AE60] text-white text-sm font-bold rounded-lg hover:bg-green-700 shadow-sm transition">
                        Enregistrer la décision
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Scripts pour manipuler la modale -->
    <script>
        function openEvaluationModal(id, candidateName, statutCandidature, statutMarche, motif) {
            const modal = document.getElementById('evaluationModal');
            const form = document.getElementById('evaluationForm');
            const title = document.getElementById('modalCandidateTitle');

            // Mettre à jour l'action du formulaire avec l'URL exacte de la route d'évaluation
            form.action = `/candidatures/${id}/evaluer`;

            title.innerText = `Arbitrage : ${candidateName}`;
            document.getElementById('modalStatutCandidature').value = statutCandidature || 'accepté';
            document.getElementById('modalStatutMarche').value = statutMarche || 'en attente';
            document.getElementById('modalMotif').value = motif || '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEvaluationModal() {
            const modal = document.getElementById('evaluationModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>