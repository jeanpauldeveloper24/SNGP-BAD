<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SNGP-BAD | Soumission de Candidature</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F4F7F6] text-[#2C3E50] antialiased min-h-screen flex flex-col justify-between">

    @include('components.header')

    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-8">

            <!-- En-tête de la page -->
            <div class="text-center max-w-3xl mx-auto mb-8">
                <span class="inline-flex items-center rounded-full bg-cyan-50 px-3 py-1 text-xs font-bold text-cyan-700 uppercase tracking-widest ring-1 ring-inset ring-cyan-700/20">
                    Dépôt d'Offre en Ligne
                </span>
                <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Formulaire de Soumission
                </h1>
                <p class="mt-2 text-sm text-gray-500">
                    Conformément aux exigences de la Réglementation des Marchés Publics, veuillez fournir vos documents d'habilitation légale ainsi que votre offre financière.
                </p>
            </div>

            <!-- Détails du marché & Besoins requis -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                <div class="border-b border-gray-100 pb-4">
                    <span class="text-[11px] font-mono font-bold text-cyan-700 uppercase">
                        Code : {{ $marche->code_marche }}
                    </span>
                    <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $marche->nom }}</h2>
                </div>

                <!-- Tableau indicatif des besoins matériels du marché -->
                <div>
                    <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Besoins techniques requis pour ce marché :</h3>
                    @php
                        $besoins = is_string($marche->besoins_materiels) ? json_decode($marche->besoins_materiels, true) : $marche->besoins_materiels;
                    @endphp

                    @if(!empty($besoins) && is_array($besoins))
                    <div class="overflow-x-auto border border-gray-100 rounded-xl">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs uppercase bg-gray-50 text-gray-700 font-bold">
                                <tr>
                                    <th class="p-3">Désignation / Spécification</th>
                                    <th class="p-3 text-right">Quantité Exigée</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($besoins as $index => $item)
                                <tr>
                                    <td class="p-3 font-medium text-gray-800">
                                        {{ $item['designation'] ?? $item['nom'] ?? 'Élément #' . ($index + 1) }}
                                    </td>
                                    <td class="p-3 text-right font-bold text-cyan-700">
                                        {{ $item['quantite'] ?? 1 }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-xs text-gray-500 italic">Aucun détail matériel spécifique répertorié.</p>
                    @endif
                </div>
            </div>

            <!-- Messages d'alerte / Erreurs de validation -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">Veuillez corriger les erreurs ci-dessous :</h3>
                            <ul class="mt-2 text-xs text-red-700 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulaire de Candidature -->
            <form action="{{ route('pages.marche.postuler', $marche->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="marche_id" value="{{ $marche->id }}">

                <!-- 1. Identité de l'Opérateur Économique -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2">1. Identité de l'Entreprise</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nom_candidat" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Raison Sociale / Nom de l'Entreprise <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nom_candidat"
                                name="nom_candidat"
                                value="{{ old('nom_candidat') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700 text-sm"
                                placeholder="Ex: Ivoire Prestations SARL"
                                required />
                        </div>

                        <div>
                            <label for="email_candidat" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Adresse E-mail Officielle <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                name="email_candidat"
                                id="email_candidat"
                                value="{{ old('email_candidat') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700 text-sm"
                                placeholder="contact@entreprise.ci"
                                required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="numero_registre_commerce" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Numéro RCCM <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="numero_registre_commerce"
                                name="numero_registre_commerce"
                                value="{{ old('numero_registre_commerce') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700 text-sm"
                                placeholder="Ex: CI-ABJ-03-2023-B12-00000"
                                required />
                        </div>
                    </div>
                </div>

                <!-- 2. Pièces Justificatives Légales et Réglementaires -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2">2. Documents d'Habilitation Réglementaires</h2>
                    <p class="text-xs text-gray-500 mb-4">Téléversez vos pièces officielles en format PDF (Taille max : 10 Mo par document).</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_rccm" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Déclaration RCCM <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="file_rccm" name="file_rccm" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" required />
                        </div>

                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_acte_constitution" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Acte de Constitution <span class="text-gray-400 font-normal">(Optionnel)</span>
                            </label>
                            <input type="file" id="file_acte_constitution" name="file_acte_constitution" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" />
                        </div>

                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_dfe" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 DFE <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="file_dfe" name="file_dfe" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" required />
                        </div>

                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_arf" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 ARF / Quitus Fiscal <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="file_arf" name="file_arf" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" required />
                        </div>

                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_cnps" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Attestation CNPS <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="file_cnps" name="file_cnps" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" required />
                        </div>

                        <div class="p-4 border border-gray-200 rounded-xl bg-gray-50/50 space-y-1">
                            <label for="file_attestation_bancaire" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                📄 Attestation Bancaire <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="file_attestation_bancaire" name="file_attestation_bancaire" accept=".pdf" class="block w-full text-xs text-gray-500 pt-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 cursor-pointer" required />
                        </div>
                    </div>
                </div>

                <!-- 3. Proposition Financière (Unique saisie du candidat) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                    <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2">3. Offre Financière Globale</h2>

                    <div>
                        <label for="proposition_financiere" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                            Montant Total Proposé TTC (FCFA) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="proposition_financiere"
                            name="proposition_financiere"
                            step="0.01"
                            value="{{ old('proposition_financiere') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:border-cyan-700 font-bold text-lg text-emerald-700"
                            placeholder="Ex: 8500000"
                            required />
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-2">
                    <a href="{{ url()->previous() }}" class="text-xs font-bold text-cyan-700 hover:text-cyan-900 uppercase tracking-wider">
                        ← Retour
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center rounded-lg bg-cyan-700 hover:bg-cyan-800 px-6 py-3 text-xs font-bold text-white shadow-sm transition uppercase tracking-wider cursor-pointer">
                        Enregistrer / Transmettre la Candidature →
                    </button>
                </div>
            </form>

        </div>
    </main>

    @include('components.footer')

</body>

</html>