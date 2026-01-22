@props(['type' => 'app'])

@php
    $logos = [
        'dsid' => ['src' => 'images/logo-dsid.jpg',    'alt' => 'Logo DSID'],
        'bad'  => ['src' => 'images/logo-bad.png',     'alt' => 'Logo BAD'],
        'ci'   => ['src' => 'images/armoirie-ci.png',  'alt' => 'Armoiries Côte d\'Ivoire'],
        'app'  => ['src' => 'images/logo-app.png',     'alt' => 'Logo Application'],
    ];

    $selected = $logos[$type] ?? $logos['app'];
    
    // On génère l'URL asset
    $url = asset($selected['src']);
@endphp

{{-- On utilise object-contain pour éviter que le logo soit déformé si on change les classes de taille --}}
<img src="{{ $url }}" 
     alt="{{ $selected['alt'] }}" 
     {{ $attributes->merge(['class' => 'h-10 w-auto object-contain']) }}
     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($selected['alt']) }}&color=1B4F72&background=F4F7F6'">