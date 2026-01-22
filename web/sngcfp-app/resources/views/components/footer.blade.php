<footer class="bg-[#1B4F72] text-white py-12 border-t-4 border-[#27AE60]">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 text-sm">

        <div class="space-y-4">
            <div class="flex items-center space-x-2">
                <x-application-logo type="app" class="h-8 w-auto brightness-0 invert" />
                <h4 class="font-bold text-lg tracking-tight uppercase">SNGP-BAD</h4>
            </div>
            <p class="text-blue-100 leading-relaxed opacity-80">
                Plateforme centrale de gestion, de suivi et de digitalisation des projets financés par la Banque Africaine de Développement en Côte d'Ivoire.
            </p>
        </div>

        <div>
            <h4 class="font-bold text-[#27AE60] uppercase tracking-widest text-xs mb-6">Partenaires Institutionnels</h4>
            <div class="flex items-center space-x-6 bg-white/5 p-4 rounded-lg border border-white/10 backdrop-blur-sm">
                <img src="/images/logo_bad.png" class="h-14" alt="BAD">
                <img src="/images/armoirie_ci.png" class="h-14" alt="République de Côte d'Ivoire">
                <img src="/images/logo_dsid.jpg" class="h-14" alt="logo DSID">
            </div>
        </div>

        <div class="space-y-4">
            <h4 class="font-bold text-sm uppercase tracking-[0.2em] mb-2 text-[#27AE60]">Contact & Support</h4>
            <div class="space-y-3 opacity-90">
                <p class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    localisation DSID
                </p>
                <p class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    télephone DSISD
                </p>
                <a href="mailto:contact@sngp-bad.ci" class="flex items-center gap-3 hover:text-[#27AE60] transition-colors">
                    <svg class="w-5 h-5 text-[#27AE60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    email de la DSID
                </a>
            </div>
        </div>

    </div>

    <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-white/10">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] md:text-xs uppercase tracking-widest opacity-60">
            <p>© {{ date('Y') }} SNGP-BAD — Direction des Systèmes d'Informations et de Digitalisation</p>
            <p>République de Côte d'Ivoire</p>
        </div>
    </div>
</footer>