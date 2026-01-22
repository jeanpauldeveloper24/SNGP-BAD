<aside x-data="{ open: true }" 
    class="fixed inset-y-0 left-0 z-50 w-64 bg-[#1B4F72] text-white transition-transform duration-300 transform lg:translate-x-0 flex flex-col"
    :class="{'translate-x-0': open, '-translate-x-full': !open}">
    
    <div class="flex items-center px-6 h-20 bg-[#0d2a3d] shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo type="app" class="h-10 w-auto" />
            <span class="font-montserrat font-bold text-lg tracking-tight">SNGCFP</span>
        </a>
    </div>

    <nav class="flex-1 mt-4 px-4 space-y-1 overflow-y-auto custom-scrollbar">
        
        <div class="space-y-1 mb-6">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="flex items-center p-3 rounded-lg transition-colors group {{ request()->routeIs('dashboard') ? 'bg-[#2E86C1] text-white' : 'text-white/70 hover:bg-[#2E86C1]/50 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="font-medium">{{ __('Tableau de bord') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" 
                class="flex items-center p-3 rounded-lg transition-colors group {{ request()->routeIs('profile.edit') ? 'bg-[#2E86C1] text-white' : 'text-white/70 hover:bg-[#2E86C1]/50 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="font-medium">{{ __('Mon Profil') }}</span>
            </x-nav-link>
        </div>

        <div class="pt-2 pb-2 text-[11px] font-bold text-[#27AE60] uppercase tracking-[0.15em] px-3">
            Finances
        </div>
        <div class="space-y-1 mb-6">
            <a href="#" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all group">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <span class="font-inter">Comptabilité</span>
            </a>

            <a href="#" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all group">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span class="font-inter">Marchés Publics</span>
            </a>
        </div>

        <div class="pt-2 pb-2 text-[11px] font-bold text-[#27AE60] uppercase tracking-[0.15em] px-3">
            Analyses
        </div>
        <div class="space-y-1">
            <a href="#" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all group">
                <svg class="w-5 h-5 mr-3 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 6v-3m-9 3h12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="font-inter font-medium">Rapports BAD</span>
            </a>
        </div>
    </nav>

    <div class="p-4 bg-[#0d2a3d] shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                onclick="event.preventDefault(); this.closest('form').submit();"
                class="w-full flex items-center justify-center gap-3 p-3 rounded-xl bg-[#ff4d4d] hover:bg-[#e60000] transition-all text-sm font-bold shadow-lg shadow-black/20 group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span>DÉCONNEXION</span>
            </button>
        </form>
    </div>
</aside>