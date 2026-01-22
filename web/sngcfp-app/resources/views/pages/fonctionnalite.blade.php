<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SNGP-BAD - Plateforme Intégrée</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html { scroll-behavior: smooth; }
        .font-montserrat { font-family: 'Figtree', sans-serif; font-weight: 800; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-[#F4F7F6]">

    @include('components.header')

    <main>
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-[#27AE60] font-bold uppercase tracking-[0.2em] text-xs">Innovation & Digitalisation</span>
                    <h1 class="text-4xl font-extrabold text-[#1B4F72] mt-4 mb-6 font-montserrat uppercase tracking-tight">
                        Direction des Systèmes d'Informations
                    </h1>
                    <p class="text-gray-600 max-w-4xl mx-auto leading-relaxed italic text-lg">
                        La DSID assure la conception, le déploiement et la sécurité du <strong>SNGP-BAD</strong>, 
                        garantissant une gestion transparente, une traçabilité totale et une efficacité accrue des projets financés par la BAD.
                    </p>
                    <div class="h-1.5 w-24 bg-[#27AE60] mx-auto mt-8 rounded-full"></div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-[#1B4F72]">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center"
                     x-data="{ 
                        shown: false,
                        counts: { projets: 0, budget: 0, satisfaction: 0 },
                        targets: { projets: 150, budget: 450, satisfaction: 100 },
                        startCounter() {
                            let duration = 2000; 
                            Object.keys(this.targets).forEach(key => {
                                let start = 0;
                                let end = this.targets[key];
                                let interval = duration / end;
                                let timer = setInterval(() => {
                                    if (this.counts[key] < end) {
                                        this.counts[key]++;
                                    } else {
                                        clearInterval(timer);
                                    }
                                }, interval);
                            });
                        }
                     }"
                     x-intersect.once="shown = true; startCounter()">
                    
                    <div class="p-8 rounded-2xl border border-white/10 bg-white/5 transition-all hover:bg-white/10">
                        <div class="text-[#27AE60] text-5xl font-black mb-2" x-text="counts.projets + '+'">0+</div>
                        <div class="text-white text-xs font-bold uppercase tracking-[0.2em]">Projets Gérés</div>
                    </div>

                    <div class="p-8 rounded-2xl bg-white shadow-xl transform -translate-y-4">
                        <div class="text-[#1B4F72] text-5xl font-black mb-2" x-text="counts.budget + 'M'">0M</div>
                        <div class="text-gray-500 text-xs font-bold uppercase tracking-[0.2em]">Budget Global (FCFA)</div>
                    </div>

                    <div class="p-8 rounded-2xl border border-white/10 bg-white/5 transition-all hover:bg-white/10">
                        <div class="text-[#27AE60] text-5xl font-black mb-2" x-text="counts.satisfaction + '%'">0%</div>
                        <div class="text-white text-xs font-bold uppercase tracking-[0.2em]">Traçabilité & Audit</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="fonctionnalites" class="py-24">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-2xl font-bold text-[#1B4F72] uppercase italic">Fonctionnalités du Système</h2>
                    <div class="h-1 w-16 bg-[#27AE60] mx-auto mt-3 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-xl border-l-4 border-[#1B4F72] shadow-sm hover:shadow-md transition-all group">
                        <h3 class="font-bold text-[#1B4F72] mb-2 uppercase text-sm group-hover:text-[#27AE60]">Authentification & Profils</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Gestion sécurisée des utilisateurs et contrôle d'accès basé sur les rôles (RBAC).</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border-l-4 border-[#1B4F72] shadow-sm hover:shadow-md transition-all group">
                        <h3 class="font-bold text-[#1B4F72] mb-2 uppercase text-sm group-hover:text-[#27AE60]">Gestion Comptable</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Système complet en partie double pour une rigueur fiduciaire absolue.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border-l-4 border-[#1B4F72] shadow-sm hover:shadow-md transition-all group">
                        <h3 class="font-bold text-[#1B4F72] mb-2 uppercase text-sm group-hover:text-[#27AE60]">Reporting BAD</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Génération automatisée des rapports officiels conformes aux exigences du bailleur.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border-l-4 border-[#1B4F72] shadow-sm hover:shadow-md transition-all group">
                        <h3 class="font-bold text-[#1B4F72] mb-2 uppercase text-sm group-hover:text-[#27AE60]">Passation de Marchés</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Suivi digitalisé du cycle de vie des appels d'offres et des contrats.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border-l-4 border-[#1B4F72] shadow-sm hover:shadow-md transition-all group">
                        <h3 class="font-bold text-[#1B4F72] mb-2 uppercase text-sm group-hover:text-[#27AE60]">Engagements & Paiements</h3>
                        <p class="text-gray-600 text-xs leading-relaxed">Workflow complet pour les demandes de paiement direct et de remboursement.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border-l-4 border-[#27AE60] shadow-sm hover:shadow-md transition-all bg-green-50/30">
                        <h3 class="font-bold text-[#27AE60] mb-2 uppercase text-sm">Piste d'Audit</h3>
                        <p class="text-gray-600 text-xs leading-relaxed font-semibold italic text-[#1B4F72]">Traçabilité historique inviolable de chaque action effectuée sur la plateforme.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('components.footer')

</body>
</html>