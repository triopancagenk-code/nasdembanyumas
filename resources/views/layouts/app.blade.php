<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Partai NasDem – Bersatu Berjuang Menang')</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Website resmi Partai NasDem berisi berita terbaru, kegiatan partai, pengurus, visi misi, dan informasi resmi lainnya.">
    <link rel="icon" href="{{ asset('images/logo-nasdem-tsp.png') }}" type="image/png">
    
    <!-- Official Partai NasDem Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/nasdem-official.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-editor.css') }}">

    <!-- Vite Assets (Tailwind & Local App) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body>
    @include('components.admin-bar')

    @if(View::hasSection('top_bar'))
        @yield('top_bar')
    @else
        @include('layouts.top-bar')
    @endif

    @if(!request()->routeIs('home'))
        <div style="background: #001333; position: sticky; top: 0; z-index: 999; border-bottom: 2px solid #ffb700;">
            @include('layouts.navigation')
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('layouts.mobile-drawer')

    @include('layouts.footer')

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay" aria-hidden="true">
        <button class="search-close-btn" id="closeSearchBtn" type="button" aria-label="Tutup Pencarian">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
                <path d="M18 6L6 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
            </svg>
        </button>

        <div class="search-box-wrap">
            <span class="search-label">Cari Berita &amp; Informasi</span>

            <form role="search" method="get" action="#" class="search-overlay-form">
                <input type="search" name="s" placeholder="Ketik kata kunci..." autocomplete="off" required>
                <button type="submit">Cari</button>
            </form>
        </div>
    </div>

    <!-- Video Modal -->
    <div class="video-modal" id="videoModal" aria-hidden="true">
        <div class="video-modal-backdrop" id="videoModalBackdrop"></div>

        <div class="video-modal-content">
            <button class="video-modal-close" id="closeVideoModal" type="button" aria-label="Tutup Video">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
                    <path d="M18 6L6 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
                </svg>
            </button>

            <iframe
                id="videoModalFrame"
                src=""
                title="Video NasDem"
                allow="autoplay; encrypted-media; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    </div>

    <!-- Official NasDem JavaScript -->
    <script src="{{ asset('js/nasdem-main.js') }}"></script>
    <script src="{{ asset('js/admin-editor.js') }}"></script>
    @stack('scripts')
</body>
</html>