<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Présentation DSID - SNGP-BAD</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-[#F4F7F6]">

    @include('components.header')

    <main class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-[#1B4F72] mb-4 font-montserrat">
                    Direction des Systèmes d'Informations et de Digitalisation
                </h2>
                <p class="text-gray-600 max-w-4xl mx-auto leading-relaxed italic text-lg">
                    La DSID est au cœur de la transformation numérique. Elle assure la conception, le déploiement et la sécurité 
                    du <strong>SNGP-BAD</strong>, garantissant une gestion transparente et efficace des projets en Côte d'Ivoire.
                </p>
            </div>

            <div class="text-center mb-12">
                <span class="text-[#27AE60] font-bold uppercase tracking-[0.2em] text-xs">Organigramme Projet</span>
                <h2 class="text-2xl font-bold text-[#1B4F72] mt-2 italic">Équipe de Direction et d'Exécution</h2>
                <div class="h-1 w-24 bg-[#27AE60] mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="flex flex-col items-center space-y-12">
                
                <div class="w-full flex justify-center">
                    <x-team-card :level="1" name="Toto Jean Paul" role="Directeur DSID" />
                </div>

                <div class="w-full flex flex-row flex-wrap justify-center gap-8">
                    <x-team-card :level="2" name="Koffi Kouadio Marc" role="Directeur Adjoint Technique" />
                    <x-team-card :level="2" name="Konan Amenan Lucie" role="Directrice Adjointe Administrative" />
                </div>

                <div class="w-full flex flex-row flex-wrap justify-center gap-6">
                    <x-team-card :level="3" name="Traoré Bakary" role="Chef Dépt. Digitalisation" />
                    <x-team-card :level="3" name="Soro Gnenema" role="Chef Dépt. Infrastructure" />
                    <x-team-card :level="3" name="Diabaté Fatoumata" role="Chef Dépt. Sécurité" />
                </div>

                @for ($l = 4; $l <= 7; $l++)
                    <div class="w-full flex flex-row flex-wrap justify-center gap-4">
                        @for ($c = 1; $c <= $l; $c++)
                            <x-team-card 
                                :level="$l" 
                                name="Membre {{ $l }}.{{ $c }}" 
                                role="Poste Niveau {{ $l }}" 
                            />
                        @endfor
                    </div>
                @endfor

            </div>
        </div>
    </main>

    @include('components.footer')

</body>
</html>