@php
// On extrait le nom du rôle proprement pour les comparaisons
$roleName = Auth::user()->role ? strtolower(Auth::user()->role->name) : '';
@endphp

<aside x-data="{ open: true }"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-[#1B4F72] text-white transition-transform duration-300 transform lg:translate-x-0 flex flex-col shadow-2xl"
    :class="{'translate-x-0': open, '-translate-x-full': !open}">

    <div class="flex items-center px-6 h-20 bg-[#0d2a3d] shrink-0 border-b border-white/5">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <span class="font-montserrat font-bold text-xl tracking-tighter text-white">SN<span class="text-[#27AE60]">GP</span></span>
        </a>
    </div>

    <nav class="flex-1 mt-4 px-4 space-y-1 overflow-y-auto custom-scrollbar">

        <div class="space-y-1 mb-6">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="flex items-center p-3 rounded-lg transition-colors group {{ request()->routeIs('dashboard') ? 'bg-[#2E86C1] text-white' : 'text-white/70 hover:bg-[#2E86C1]/50 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="font-medium">{{ __('Tableau de bord') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')"
                class="flex items-center p-3 rounded-lg transition-colors group {{ request()->routeIs('profile.edit') ? 'bg-[#2E86C1] text-white' : 'text-white/70 hover:bg-[#2E86C1]/50 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="font-medium">{{ __('Mon Profil') }}</span>
            </x-nav-link>
        </div>

        @if(in_array($roleName, ['administrateur_systeme']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-white/40 uppercase px-3 mb-2 tracking-widest">utilisateurs du systeme</p>
            <a href="{{ route('profile.menus.users.create') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.users.create') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">formulaire des utilisateurs</span>
            </a>
            <a href="{{ route('profile.menus.users.list') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.users.list') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">liste des utilisateurs</span>
            </a>
            <a href="{{ route('menus.candidatures.liste') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('menus.candidatures.liste') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">liste des candidatures</span>
            </a>
        </div>
        @endif

        {{-- 1. SECTION GESTION FINANCIÈRE (Réservée à l'Ordonnateur, Admin, etc. - SANS l'UGP) --}}
        @if(in_array($roleName, ['ordonnateur', 'administrateur_systeme', 'comptable_nationale', 'comptable_bad']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-white/40 uppercase px-3 mb-2 tracking-widest">Gestion Financière</p>
            <a href="{{ route('menus.finances') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('menus.finances') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Finances</span>
            </a>
            <a href="{{ route('menus.paiements') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('menus.paiements') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Liste des Paiements</span>
            </a>
            <a href="{{ route('profile.menus.budget') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.budget') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Suivi Budgétaire</span>
            </a>
        </div>
        @endif

        {{-- 2. SECTION OPÉRATIONNELLE / PROJETS (Accessible à l'UGP, Admin, Ordonnateur) --}}
        @if(in_array($roleName, ['ugp', 'ordonnateur', 'administrateur_systeme']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-white/40 uppercase px-3 mb-2 tracking-widest">Pilotage Opérationnel</p>
            <a href="{{ route('profile.menus.projects.list') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.projects.list') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Liste des projets</span>
            </a>
        </div>
        @endif
        @if(in_array($roleName, ['comptable_bad', 'comptable_nationale', 'administrateur_systeme']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-[#27AE60] uppercase px-3 mb-2 tracking-widest">comptabilité</p>

            <a href="{{ route('profile.menus.comptabilite.comptabilite_financiere') }}"
                class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.comptabilite.comptabilite_financiere') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm font-medium">Comptabilité Financière</span>
            </a>

            <a href="{{ route('profile.menus.comptabilite.comptabilite_gestion') }}"
                class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.comptabilite.comptabilite_gestion') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm font-medium">Comptabilité de Gestion & Coûts</span>
            </a>

            <a href="{{ route('profile.menus.comptabilite.comptabilite_actif') }}"
                class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.comptabilite.comptabilite_actif') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm font-medium">Comptabilité de l'Actif</span>
            </a>

            <a href="{{ route('profile.menus.comptabilite.comptabilite_caisse') }}"
                class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.comptabilite.comptabilite_caisse') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm font-medium">Comptabilité de Caisse</span>
            </a>

            <a href="{{ route('profile.menus.comptabilite.comptabilite_monetaire') }}"
                class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.comptabilite.comptabilite_monetaire') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm font-medium">Marchés Monétaires & Devises</span>
            </a>
        </div>
        @endif

        @if(in_array($roleName, ['auditeur_interne', 'administrateur_systeme']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-red-400 uppercase px-3 mb-2 tracking-widest">Audit & Certification</p>

            <a href="{{ route('menus.audit') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('menus.audit') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Audit & Conformité</span>
            </a>

            {{-- Masquer ce lien UNIQUEMENT pour l'administrateur_systeme pour éviter le doublon --}}
            @if($roleName !== 'administrateur_systeme')
            <a href="{{ route('profile.menus.projects.list') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.projects.list') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Liste des projets</span>
            </a>
            @endif

            @if($roleName === 'auditeur_interne')
            <div class="pl-2 border-l border-white/10 my-2 space-y-1">
                <span class="text-[9px] font-bold text-white/30 uppercase px-3 block tracking-wider">Comptabilité Spécifique</span>

                <a href="{{ route('profile.menus.comptabilite.comptabilite_financiere') }}" class="flex items-center py-1.5 px-3 rounded text-xs text-white/60 hover:text-white {{ request()->routeIs('profile.menus.comptabilite.comptabilite_financiere') ? 'text-white font-bold' : '' }}">
                    Comptabilité Financière
                </a>
                <a href="{{ route('profile.menus.comptabilite.comptabilite_gestion') }}" class="flex items-center py-1.5 px-3 rounded text-xs text-white/60 hover:text-white {{ request()->routeIs('profile.menus.comptabilite.comptabilite_gestion') ? 'text-white font-bold' : '' }}">
                    Comptabilité de Gestion & Coûts
                </a>
                <a href="{{ route('profile.menus.comptabilite.comptabilite_actif') }}" class="flex items-center py-1.5 px-3 rounded text-xs text-white/60 hover:text-white {{ request()->routeIs('profile.menus.comptabilite.comptabilite_actif') ? 'text-white font-bold' : '' }}">
                    Comptabilité de l'Actif
                </a>
                <a href="{{ route('profile.menus.comptabilite.comptabilite_caisse') }}" class="flex items-center py-1.5 px-3 rounded text-xs text-white/60 hover:text-white {{ request()->routeIs('profile.menus.comptabilite.comptabilite_caisse') ? 'text-white font-bold' : '' }}">
                    Comptabilité de Caisse
                </a>
                <a href="{{ route('profile.menus.comptabilite.comptabilite_monetaire') }}" class="flex items-center py-1.5 px-3 rounded text-xs text-white/60 hover:text-white {{ request()->routeIs('profile.menus.comptabilite.comptabilite_monetaire') ? 'text-white font-bold' : '' }}">
                    Marchés Monétaires & Devises
                </a>
            </div>
            @endif

            @if($roleName !== 'administrateur_systeme')
            <a href="{{ route('menus.candidatures.liste') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('menus.candidatures.liste') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Liste des candidatures</span>
            </a>
            @endif

            <a href="{{ route('menus.paiements') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('menus.paiements') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Liste des paiements</span>
            </a>

            <a href="{{ route('menus.rapports') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('menus.rapports') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Rapports des travaux</span>
            </a>
        </div>
        @endif

        @if(in_array($roleName, ['ministre', 'administrateur_systeme']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-white/40 uppercase px-3 mb-2 tracking-widest">Référentiels National</p>

            <a href="{{ route('profile.menus.pnd.list') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.pnd.*') ? 'bg-[#2E86C1] text-white font-semibold' : '' }}">
                <span class="text-sm">Cadre PND 2026-2030</span>
            </a>

            <a href="{{ route('profile.menus.circonscription.list') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('profile.menus.circonscription.*') ? 'bg-[#2E86C1] text-white font-semibold' : '' }}">
                <span class="text-sm">Découpage Territorial</span>
            </a>
        </div>
        @endif

        @if(in_array($roleName, ['specialiste_marche', 'ugp', 'ordonnateur', 'administrateur_systeme']))
        <div class="mb-6">
            <p class="text-[10px] font-bold text-white/40 uppercase px-3 mb-2 tracking-widest">Marchés Publics</p>

            <a href="{{ route('passation.index') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('passation.index') || request()->routeIs('passation.edit-etape') ? 'bg-[#2E86C1] text-white font-semibold' : '' }}">
                <span class="text-sm">Suivi des DAO</span>
            </a>

            @if(in_array($roleName, ['ugp', 'comite_technique', 'ordonnateur', 'administrateur_systeme']))
            <a href="{{ route('menus.candidatures.liste') }}" class="flex items-center p-3 rounded-lg text-white/70 hover:bg-[#2E86C1] hover:text-white transition-all {{ request()->routeIs('menus.candidatures.liste') ? 'bg-[#2E86C1] text-white' : '' }}">
                <span class="text-sm">Liste des candidatures</span>
            </a>
            @endif
        </div>
        @endif

        <div class="mb-6 pt-4 border-t border-white/10">
            <p class="text-[10px] font-bold text-[#27AE60] uppercase px-3 mb-2 tracking-widest">Communication</p>
            <div class="space-y-1">
                <a href="{{ route('menus.messages') }}" class="flex items-center justify-between p-3 rounded-lg bg-white/5 text-white hover:bg-[#2E86C1] transition-all group {{ request()->routeIs('menus.messages') ? 'bg-[#2E86C1]' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span class="font-bold text-sm">Messagerie</span>
                    </div>
                    <span class="bg-[#ff4d4d] text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse shadow-sm">3</span>
                </a>

                <a href="{{ route('menus.notifications') }}" class="flex items-center justify-between p-3 rounded-lg bg-white/5 text-white hover:bg-[#2E86C1] transition-all group {{ request()->routeIs('menus.notifications') ? 'bg-[#2E86C1]' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="font-bold text-sm">Notifications</span>
                    </div>
                    <span class="bg-yellow-500 text-[10px] text-black font-black px-2 py-0.5 rounded-full shadow-sm">3</span>
                </a>
            </div>
        </div>

    </nav>

    <div class="p-4 bg-[#0d2a3d] shrink-0">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                onclick="event.preventDefault(); this.closest('form').submit();"
                class="w-full flex items-center justify-center gap-3 p-3 rounded-xl bg-[#ff4d4d] hover:bg-[#e60000] transition-all text-sm font-bold shadow-lg shadow-black/20 group">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>DÉCONNEXION</span>
            </button>
        </form>
    </div>
</aside>