<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SNGP-BAD | Accueil</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F7F6] text-[#2C3E50] antialiased">

    @include('components.header')

    <section class="relative bg-cover bg-center text-white py-24" 
             style="background-image: url('/images/votre-image-bureau.png');">
        
        <div class="absolute inset-0 bg-[#1B4F72]/60"></div>

        <div class="relative max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4 font-montserrat leading-tight text-white">
                    Système National de Gestion des Projets - BAD
                </h1>
                <p class="mb-8 text-lg opacity-90 leading-relaxed text-white">
                    Pilotage transparent, traçable et sécurisé des investissements 
                    BAD en Côte d’Ivoire.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contexte') }}" class="px-6 py-3 bg-[#27AE60] hover:bg-[#219150] transition rounded-md font-semibold shadow-lg text-white">
                        Découvrir la plateforme
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-white text-[#1B4F72] hover:bg-gray-100 transition rounded-md font-semibold shadow-lg">
                        Accès rapide projets
                    </a>
                </div>
            </div>

            <div class="flex justify-center items-center space-x-8 bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20">
                <img src="/images/logo_bad.png" class="h-20 object-contain" alt="Logo BAD">
                <div class="h-16 w-px bg-white/30"></div> 
                <img src="/images/armoirie_ci.png" class="h-16 object-contain" alt="Armoiries Côte d'Ivoire">
            </div>
        </div>
    </section>

    <section id="contexte" class="py-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12 text-[#1B4F72]">Contexte & Objectifs Clés</h2>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-[#2E86C1] text-4xl mb-4">🔐</div>
                    <h3 class="font-bold text-lg mb-2">Sécurité & Traçabilité</h3>
                    <p class="text-gray-600 italic text-sm">Piste d’audit complète et données non altérables.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-[#2E86C1] text-4xl mb-4">📊</div>
                    <h3 class="font-bold text-lg mb-2">Pilotage en temps réel</h3>
                    <p class="text-gray-600 italic text-sm">Indicateurs fiables pour les décideurs institutionnels.</p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-[#2E86C1] text-4xl mb-4">🏛️</div>
                    <h3 class="font-bold text-lg mb-2">Centralisation</h3>
                    <p class="text-gray-600 italic text-sm">Une plateforme unique pour tous les projets BAD.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-xl font-bold mb-10 text-gray-400 uppercase tracking-widest">Partenaires Institutionnels</h2>
            <div class="flex flex-wrap justify-center items-center gap-12 opacity-80 grayscale hover:grayscale-0 transition duration-500">
                <img src="/images/logo_bad.png" class="h-14" alt="BAD">
                <img src="/images/armoirie_ci.png" class="h-14" alt="République de Côte d'Ivoire">
                <img src="/images/logo_dsid.jpg" class="h-14" alt="logo DSID">
            </div>
        </div>
    </section>

    @include('components.footer')

</body>
</html>