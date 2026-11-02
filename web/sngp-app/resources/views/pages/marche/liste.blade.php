<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SNGP-BAD | Appels d'Offres</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F4F7F6] text-[#2C3E50] antialiased min-h-screen flex flex-col justify-between">

    @include('components.header')

    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="inline-flex items-center rounded-full bg-cyan-50 px-3 py-1 text-xs font-bold text-cyan-700 uppercase tracking-widest ring-1 ring-inset ring-cyan-700/20">
                    Portail National de Transparence
                </span>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                    Appels d'Offres & Marchés Ouverts
                </h1>
                <p class="mt-3 text-base text-gray-500">
                    Système National de Gestion des Projets (SNGCFP). Consultez les opportunités et soumettez vos propositions avant la clôture des registres.
                </p>
            </div>

            @if($markets->isEmpty())
            <div class="text-center bg-white rounded-xl shadow-sm border border-gray-100 p-16 max-w-2xl mx-auto">
                <div class="text-5xl mb-4">🗂️</div>
                <h3 class="text-lg font-bold text-gray-900">Aucun appel d'offres disponible</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Il n'y a actuellement aucun marché ouvert aux candidatures ou les dates limites de dépôt sont toutes dépassées.
                </p>
                <div class="mt-6">
                    <a href="/" class="text-xs font-bold text-cyan-700 hover:text-cyan-900 uppercase tracking-wider">
                        ← Retour à l'accueil
                    </a>
                </div>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($markets as $marche)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all flex flex-col justify-between overflow-hidden relative">

                    @php
                    $joursRestants = \Carbon\Carbon::now()->diffInDays($marche->candidature_end_date, false);
                    @endphp
                    <div class="absolute top-4 right-4">
                        @if($joursRestants <= 3)
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-bold text-red-700 ring-1 ring-inset ring-red-600/20 animate-pulse">
                            ⏳ J-{{ $joursRestants }} avant clôture
                            </span>
                            @else
                            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                ⏳ {{ $joursRestants }} jours restants
                            </span>
                            @endif
                    </div>

                    <div class="p-6 pt-8">
                        <div class="flex items-center space-x-2 text-[11px] font-mono font-bold text-gray-400 uppercase">
                            <span>Réf: AAO-{{ $marche->id }}</span>
                            <span>•</span>
                            <span class="text-cyan-700">Projet: {{ $marche->project->code ?? 'N/A' }}</span>
                        </div>

                        <h3 class="mt-3 text-base font-bold text-gray-900 line-clamp-2 min-h-[3rem]" title="{{ $marche->objet }}">
                            {{ $marche->objet }}
                        </h3>

                        <div class="mt-6 space-y-2 border-t border-gray-100 pt-4 text-xs">
                            <div class="flex justify-between text-gray-600">
                                <span class="text-gray-400">Ouverture des dépôts :</span>
                                <span class="font-medium font-mono">{{ \Carbon\Carbon::parse($marche->candidature_start_date)->format('d F Y') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-900 font-bold">
                                <span class="text-gray-400 font-normal">Date limite de rigueur :</span>
                                <span class="text-red-600 font-mono">{{ \Carbon\Carbon::parse($marche->candidature_end_date)->format('d F Y à H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">
                            Statut: <span class="text-amber-600 font-bold">{{ $marche->status }}</span>
                        </span>
                        <a href="{{ route('pages.candidature-form', $marche->id) }}" class="inline-flex items-center rounded-lg bg-cyan-700 hover:bg-cyan-800 px-3.5 py-2 text-xs font-bold text-white shadow-sm transition uppercase tracking-wider">
                            Soumissionner →
                        </a>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- Liens de pagination -->
            <div class="mt-10">
                {{ $markets->links() }}
            </div>
            @endif

        </div>
    </main>

    @include('components.footer')

</body>

</html>