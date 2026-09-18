@props([
    'size' => 'default',
    'light' => true
])

@php
    $logoSizes = [
        'sm' => ['emblem' => 'w-8 h-8', 'title' => 'text-base', 'sub' => 'text-[9px]'],
        'default' => ['emblem' => 'w-11 h-11', 'title' => 'text-xl', 'sub' => 'text-[10px]'],
        'lg' => ['emblem' => 'w-14 h-14', 'title' => 'text-2xl', 'sub' => 'text-xs'],
    ];
    $s = $logoSizes[$size] ?? $logoSizes['default'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3 select-none group']) }}>
    <!-- NasDem Emblem SVG -->
    <div class="{{ $s['emblem'] }} relative flex-shrink-0 transition-transform duration-300 group-hover:scale-105">
        <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer border / circle -->
            <circle cx="50" cy="50" r="48" fill="#0A182F" stroke="#1E3A8A" stroke-width="2"/>
            <!-- Yellow/Gold Crescent Arc (Symbolizing sunrise / prosperity) -->
            <path d="M 22 56 C 24 74 42 86 64 82 C 78 79 88 68 90 54 C 80 68 62 74 44 68 C 30 63 24 55 22 56 Z" fill="#F59E0B" />
            <path d="M 18 48 C 22 68 44 82 72 76 C 54 78 34 68 28 52 C 24 42 28 32 30 28 C 22 34 16 40 18 48 Z" fill="#FBBF24" />
            <!-- Blue Dynamic Wave Arc -->
            <path d="M 28 36 C 36 22 58 16 78 26 C 62 20 46 26 38 38 C 32 46 32 54 30 58 C 28 50 26 42 28 36 Z" fill="#2563EB" />
            <path d="M 38 34 C 48 18 72 16 88 32 C 74 24 56 26 46 38 C 40 46 38 52 38 52 C 37 46 36 38 38 34 Z" fill="#60A5FA" />
        </svg>
    </div>

    <!-- Text Label -->
    <div class="flex flex-col leading-tight">
        <div class="{{ $s['title'] }} font-black tracking-tight flex items-baseline gap-1 {{ $light ? 'text-white' : 'text-slate-900' }}">
            <span class="font-medium">Partai</span>
            <span class="font-extrabold text-white">Nas<span class="text-amber-400">Dem</span></span>
        </div>
        <span class="{{ $s['sub'] }} font-extrabold tracking-[0.18em] text-red-500 uppercase mt-0.5">
            Gerakan Perubahan
        </span>
    </div>
</div>
