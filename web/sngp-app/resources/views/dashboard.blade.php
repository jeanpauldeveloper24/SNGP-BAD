<x-app-layout>
    <!-- Calcul PHP des pourcentages de co-financement et de l'évolution physico-financière -->
    @php
    $totalBailleur = $projects->sum('financement_bailleur');
    $totalEtat = $projects->sum('financement_etat');
    $totalGlobal = $totalBailleur + $totalEtat;

    // Si le total est à 0, on met les pourcentages à 0 au lieu de 50
    $pctBailleur = $totalGlobal > 0 ? ($totalBailleur / $totalGlobal) * 100 : 0;
    $pctEtat = $totalGlobal > 0 ? ($totalEtat / $totalGlobal) * 100 : 0;

    $tauxPhysiqueGlobal = $projects->avg('taux_execution') ?? 0;

    $totalBudgetInitial = $projects->sum('budget_in_fcfa');

    $totalPaiementsValides = \App\Models\Paiement::whereIn('project_id', $projects->pluck('id'))
    ->where('status', 'valide')
    ->sum('montant');

    $tauxFinancierGlobal = $totalBudgetInitial > 0 ? ($totalPaiementsValides / $totalBudgetInitial) * 100 : 0;
    @endphp

    <!-- On initialise Alpine qui enveloppe TOUTE la vue -->
    <div x-data="{ 
        currency: 'FCFA', 
        rates: { 
            'FCFA': 1, 
            'USD': {{ $exchangeRateUsd ?? 0.0016 }}, 
            'EUR': {{ $exchangeRateEur ?? 0.0015 }} 
        },
        symbols: { 'FCFA': 'FCFA', 'USD': '$', 'EUR': '€' },
        format(amount) {
            let converted = amount * this.rates[this.currency];
            return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(converted) + ' ' + this.symbols[this.currency];
        }
    }" class="space-y-6 p-6">

        <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-[#1B4F72]">TABLEAU DE BORD STRATÉGIQUE</h2>
                    <p class="text-xs text-gray-500">
                        @if(auth()->check() && auth()->user()->hasRole('ugp'))
                        ESPACE DE SUIVI OPÉRATIONNEL (UGP)
                        @else
                        PORTEFEUILLE GLOBAL SNGP - BAD & ÉTAT DE CÔTE D'IVOIRE
                        @endif
                    </p>
                </div>
            </div>
        </x-slot>

        <!-- Barre Partenaires Institutionnels -->
        <div class="bg-white px-6 py-3 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
            <img src="{{ asset('images/armoirie_ci.png') }}" alt="République CI" class="h-10 object-contain" />
            <div class="flex items-center gap-6">
                <img src="{{ asset('images/logo_dsid.jpg') }}" alt="DSID" class="h-8 object-contain" />
                <span class="text-gray-200">|</span>
                <img src="{{ asset('images/logo_bad.png') }}" alt="BAD" class="h-8 object-contain" />
            </div>
        </div>

        <!-- Ligne du Sélecteur de Devises interactif -->
        <div class="flex justify-between items-center bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div>
                <h4 class="font-bold text-[#1B4F72] text-xs uppercase">Sélection de la Devise d'Affichage</h4>
                <p class="text-[11px] text-gray-500">Basculez instantanément les montants du portefeuille</p>
            </div>
            <div class="flex bg-gray-100 p-1 rounded-lg border border-gray-200 text-xs font-semibold">
                <button @click="currency = 'FCFA'" :class="currency === 'FCFA' ? 'bg-[#1B4F72] text-white shadow-sm' : 'text-gray-600 hover:text-black'" class="px-3 py-1.5 rounded transition">FCFA</button>
                <button @click="currency = 'USD'" :class="currency === 'USD' ? 'bg-[#1B4F72] text-white shadow-sm' : 'text-gray-600 hover:text-black'" class="px-3 py-1.5 rounded transition">USD</button>
                <button @click="currency = 'EUR'" :class="currency === 'EUR' ? 'bg-[#1B4F72] text-white shadow-sm' : 'text-gray-600 hover:text-black'" class="px-3 py-1.5 rounded transition">EUR</button>
            </div>
        </div>

        <!-- 3 KPIs Essentiels -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Budget Global Dynamique -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-l-[#1B4F72]">
                <p class="text-xs font-bold text-gray-400 uppercase">Budget Portefeuille</p>
                <h3 class="text-2xl font-extrabold text-[#1B4F72] mt-1"
                    x-text="format({{ $projects->sum('budget_in_fcfa') ?? 0 }})">
                </h3>
                <p class="text-xs text-gray-500 mt-1">{{ $projects->count() ?? 0 }} projet(s)</p>
            </div>

            <!-- Co-Financement (Basé sur les sommes réelles) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-l-[#27AE60]">
                <p class="text-xs font-bold text-gray-400 uppercase">Co-Financement (BAD / État)</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-xl font-bold text-[#27AE60]">
                        BAD {{ number_format($pctBailleur, 0) }}%
                    </span>
                    <span class="text-sm font-semibold text-orange-500">
                        / État {{ number_format($pctEtat, 0) }}%
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Ventilation bailleur vs contrepartie</p>
            </div>

            <!-- Évolution Physico-Financière -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-l-[#2E86C1]">
                <p class="text-xs font-bold text-gray-400 uppercase">Évolution Physico-Financière</p>
                <div class="grid grid-cols-2 gap-2 mt-1">
                    <div>
                        <span class="text-[10px] text-gray-400 font-semibold uppercase">Physique</span>
                        <h3 class="text-xl font-extrabold text-[#2E86C1]">
                            {{ number_format($tauxPhysiqueGlobal, 1) }}%
                        </h3>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 font-semibold uppercase">Financier</span>
                        <h3 class="text-xl font-extrabold text-[#27AE60]">
                            {{ number_format($tauxFinancierGlobal, 1) }}%
                        </h3>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-[#2E86C1] h-1.5 rounded-full" style="width: {{ $tauxPhysiqueGlobal }}%"></div>
                    </div>
                </div>
                <div class="mt-1.5">
                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-[#27AE60] h-1.5 rounded-full" style="width: {{ $tauxFinancierGlobal }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des Projets -->
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-bold text-[#1B4F72] text-xs uppercase">Suivi des Projets de l'UGP</h4>

                @if(auth()->check() && !auth()->user()->hasRole('ugp'))
                <a href="#" class="px-3 py-1.5 bg-[#1B4F72] text-white rounded-lg text-xs font-semibold hover:bg-[#153e5c] transition">
                    + Rédiger / Valider un Bilan de Projet
                </a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-400 uppercase">
                            <th class="pb-2">Code</th>
                            <th class="pb-2">Projet</th>
                            <th class="pb-2">Région</th>
                            <th class="pb-2 text-right">Budget</th>
                            <th class="pb-2 text-center">Avancement Physique / Financier</th>
                            <th class="pb-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($projects ?? [] as $project)
                        <tr>
                            <td class="py-3 font-bold text-[#1B4F72]">{{ $project->code }}</td>
                            <td class="py-3 font-medium text-gray-800">{{ $project->nom }}</td>
                            <td class="py-3 text-gray-500">{{ $project->region ?? 'National' }}</td>
                            <!-- Budget converti dynamiquement par ligne -->
                            <td class="py-3 text-right font-bold"
                                x-text="format({{ $project->budget_in_fcfa ?? 0 }})">
                            </td>
                            <td class="py-3 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[#2E86C1]">
                                    Phy: {{ $project->taux_execution ?? 0 }}% | Fin: {{ number_format($tauxFinancierGlobal, 1) }}%
                                </span>
                            </td>
                            <td class="py-3 text-right space-x-2">
                                <a href="#" class="text-[#27AE60] font-bold hover:underline">Mettre à jour</a>

                                @if(auth()->check() && !auth()->user()->hasRole('ugp'))
                                <span class="text-gray-300">|</span>
                                <a href="#" class="text-gray-500 hover:text-gray-800">Bilan</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-400 italic">Aucun projet enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>