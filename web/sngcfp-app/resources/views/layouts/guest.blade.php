<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700|figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#F4F7F6]">
        <div class="min-h-screen flex">
            
            <div class="hidden lg:flex lg:w-1/2 relative bg-[#1B4F72] items-center justify-center p-12">
                <div class="absolute inset-0 z-0 opacity-40 bg-cover bg-center" 
                     style="background-image: url('{{ asset('images/split_back.png') }}');">
                </div>
                
                <div class="absolute inset-0 z-10 bg-gradient-to-b from-[#1B4F72]/60 to-[#1B4F72]/90"></div>

                <div class="relative z-20 text-white max-w-lg">
                    <h1 class="text-5xl font-bold font-montserrat mb-6 leading-tight uppercase tracking-tighter">
                        SNGCFP-BAD
                    </h1>
                    <div class="h-1.5 w-24 bg-[#27AE60] mb-8 rounded-full"></div>
                    <p class="text-xl font-light italic leading-relaxed border-l-4 border-white/30 pl-6">
                        Système National de Gestion des Projets financés par la Banque Africaine de Développement.
                    </p>
                    <p class="mt-12 text-sm font-medium tracking-widest text-white/60 uppercase">
                        République de Côte d'Ivoire
                    </p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50">
                <div class="mb-8">
    <a href="/">
        {{-- On appelle votre composant avec le type 'app' ou 'dsid' selon votre préférence --}}
        <x-application-logo type="app" class="w-24 h-auto shadow-sm" />
    </a>
</div>

                <div class="w-full sm:max-w-md bg-white px-8 py-10 shadow-2xl rounded-2xl border border-gray-100">
                    {{ $slot }}
                </div>
                
                <p class="mt-8 text-xs text-gray-400 font-inter">
                    © 2026 SNGP-BAD — Tous droits réservés.
                </p>
            </div>

        </div>
    </body>
</html>