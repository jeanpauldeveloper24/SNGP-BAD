<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex min-h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
            
            <div class="w-64 shrink-0 shadow-xl z-20">
                @include('layouts.navigation')
            </div>

            <div class="flex-1 flex flex-col min-w-0 bg-[#F4F7F6]">
                
                @isset($header)
                    <header class="bg-white h-16 shadow-sm flex items-center px-8 border-b border-gray-200 shrink-0">
                        <div class="flex justify-between items-center w-full">
                            <h2 class="font-bold text-xl text-[#1B4F72] uppercase tracking-wide">
                                {{ $header }}
                            </h2>
                            
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500 italic">Connecté en tant que {{ Auth::user()->name }}</span>
                                <div class="w-8 h-8 rounded-full bg-[#27AE60] flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </header>
                @endisset

                <main class="flex-1 p-8 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>