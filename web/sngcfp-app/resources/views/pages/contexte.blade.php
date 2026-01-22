<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SNGP-BAD | Accueil</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|montserrat:700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-[#F4F7F6] text-[#2C3E50] antialiased">

    @include('components.header')

    <section class="relative bg-cover bg-center text-white py-32 flex items-center justify-center" 
         style="background-image: url('/images/votre-image-bureau.png');">
    
    <div class="absolute inset-0 bg-[#1B4F72]/75"></div>

    <div class="relative max-w-5xl mx-auto px-6 flex flex-col items-center text-center">
        
        <div class="flex justify-center items-center space-x-8 bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20">
                <img src="/images/logo_bad.png" class="h-20 object-contain" alt="Logo BAD">
                <div class="h-16 w-px bg-white/30"></div> 
                <img src="/images/armoirie_ci.png" class="h-16 object-contain" alt="Armoiries Côte d'Ivoire">
            </div>

        <div class="space-y-6">
            <h1 class="text-4xl md:text-6xl font-bold font-montserrat leading-tight text-white uppercase tracking-tight">
                Système National de Gestion des Projets
            </h1>
            <p class="text-xl md:text-2xl opacity-90 leading-relaxed max-w-3xl mx-auto">
                Une solution unique pour la gestion comptable et financière des projets BAD en Côte d’Ivoire, optimisant l'impact des ressources pour les populations.
            </p>
        </div>

    </div>
</section>

    <section id="vision" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="text-[#27AE60] font-bold uppercase tracking-widest text-sm">Justification Économique</span>
                    <h2 class="text-3xl font-bold text-[#1B4F72] font-montserrat uppercase">Une approche rationalisée</h2>
                    <p class="text-gray-600 leading-relaxed italic border-l-4 border-[#27AE60] pl-6 py-2">
                        "L'acquisition multiple de logiciels pour chaque projet n'est pas économique. Les ressources économisées servent désormais à financer des activités plus pertinentes pour les populations." — Note BAD
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Le SNGP-BAD remplace la multiplicité des outils par une <strong>plateforme souveraine</strong>, pilotée par la partie nationale, garantissant la pérennité des données et une maintenance évolutive maîtrisée.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-[#F8FAFC] p-6 rounded-2xl border border-gray-100">
                        <p class="text-[#27AE60] font-bold text-2xl mb-1">100%</p>
                        <p class="text-xs font-bold uppercase text-[#1B4F72]">Souveraineté</p>
                        <p class="text-[10px] text-gray-500 mt-2">Codes sources gérés par la partie nationale.</p>
                    </div>
                    <div class="bg-[#F8FAFC] p-6 rounded-2xl border border-gray-100">
                        <p class="text-[#1B4F72] font-bold text-2xl mb-1">Multi</p>
                        <p class="text-xs font-bold uppercase text-[#27AE60]">Devises & Langues</p>
                        <p class="text-[10px] text-gray-500 mt-2">Support complet des standards internationaux.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-[#F4F7F6]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-[#1B4F72] uppercase font-montserrat">Exigences & Caractéristiques</h2>
                <div class="w-24 h-1 bg-[#27AE60] mx-auto mt-4"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#1B4F72] hover:shadow-xl transition-all">
                    <div class="w-12 h-12 bg-[#1B4F72]/10 rounded-lg flex items-center justify-center text-2xl mb-6">🔐</div>
                    <h3 class="font-bold text-lg mb-4 text-[#1B4F72] uppercase">Sécurité Critique</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Authentification stricte, piste d'audit inviolable et impossibilité de suppression des transactions reportées.
                    </p>
                    <ul class="text-[10px] uppercase font-bold text-[#27AE60] space-y-1">
                        <li>• Contrôles Internes</li>
                        <li>• Auto-diagnostic d'intégrité</li>
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#27AE60] hover:shadow-xl transition-all">
                    <div class="w-12 h-12 bg-[#27AE60]/10 rounded-lg flex items-center justify-center text-2xl mb-6">📊</div>
                    <h3 class="font-bold text-lg mb-4 text-[#1B4F72] uppercase">Comptabilité OHADA/BAD</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Tenue en partie double conforme au système national et aux exigences spécifiques de la Banque.
                    </p>
                    <ul class="text-[10px] uppercase font-bold text-[#1B4F72] space-y-1">
                        <li>• Suivi DPD / DRF</li>
                        <li>• RGP LACI automatique</li>
                    </ul>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-[#1B4F72] hover:shadow-xl transition-all">
                    <div class="w-12 h-12 bg-[#1B4F72]/10 rounded-lg flex items-center justify-center text-2xl mb-6">🏛️</div>
                    <h3 class="font-bold text-lg mb-4 text-[#1B4F72] uppercase">Multi-Projets</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        Capacité de consolidation des comptes sur plusieurs sites et rapports périodiques multi-sources.
                    </p>
                    <ul class="text-[10px] uppercase font-bold text-[#27AE60] space-y-1">
                        <li>• Export Excel/PDF/ASCII</li>
                        <li>• Passation de marchés</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-xs font-bold mb-10 text-gray-400 uppercase tracking-[0.4em]">Partenaires Institutionnels</h2>
            <div class="flex flex-wrap justify-center items-center gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-700">
                <img src="/images/logo_bad.png" class="h-12" alt="Banque Africaine de Développement">
                <img src="/images/armoirie_ci.png" class="h-12" alt="République de Côte d'Ivoire">
                <img src="/images/logo_dsid.jpg" class="h-12 rounded" alt="Direction DSID">
            </div>
        </div>
    </section>

    @include('components.footer')

</body>
</html>