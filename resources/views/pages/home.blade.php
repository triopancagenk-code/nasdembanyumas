@extends('layouts.app')

@section('title', 'Partai NasDem – Bersatu Berjuang Menang')

@section('content')

{{-- ========================================================
     HERO BANNER & SLIDER (EXACT OFFICIAL partainasdem.id)
     ======================================================== --}}
<section class="hero-section hero-slider">

    @foreach($content['hero_slides'] ?? [] as $slide)
    <!-- Slide {{ $loop->iteration }} -->
    <div class="hero-slide {{ $loop->first ? 'active' : '' }}"
         data-eyebrow="{{ $slide['eyebrow'] ?? '' }}"
         data-title="{{ $slide['title'] ?? '' }}"
         data-desc="{{ $slide['desc'] ?? '' }}"
         data-url="{{ $slide['url'] ?? '#' }}"
         data-btn-text="{{ $slide['button_text'] ?? 'Gabung Sekarang' }}"
         data-btn-url="{{ $slide['button_url'] ?? 'https://digital.partainasdem.id/v1/daftar' }}"
         style="background-image: url('{{ asset(ltrim($slide['image'] ?? 'images/suryapaloh.jpg', '/')) }}');">
    </div>
    @endforeach

    <!-- Ambient Gradient Overlay -->
    <div class="hero-gradient"></div>

    <!-- Header Navbar (Positioned Inside Hero) -->
    @include('layouts.navigation')

    <!-- Hero Headline & Content -->
    <div class="hero-content">
        <div class="eyebrow" id="heroEyebrow" data-editable="hero.eyebrow">{{ $content['hero_slides'][0]['eyebrow'] ?? 'Bersama Mewujudkan' }}</div>

        @php
            $firstTitle = $content['hero_slides'][0]['title'] ?? 'INDONESIA|MAJU|& BERKEADILAN';
            $titleParts = explode('|', $firstTitle);
        @endphp
        <h1 id="heroTitle">
            @if(count($titleParts) >= 3)
                {{ $titleParts[0] }}<br>
                <span>{{ $titleParts[1] }}</span><br>
                {{ $titleParts[2] }}
            @else
                {{ $firstTitle }}
            @endif
        </h1>

        <p id="heroDesc" data-editable="hero.desc">
            {{ $content['hero_slides'][0]['desc'] ?? '' }}
        </p>

        <div class="hero-buttons">
            <a href="{{ $content['hero_slides'][0]['button_url'] ?? 'https://digital.partainasdem.id/v1/daftar' }}" target="_blank" class="btn-yellow" id="heroMainBtn" data-editable="hero.button_text">
                {{ $content['hero_slides'][0]['button_text'] ?? 'Gabung Sekarang' }}
            </a>

            <a href="{{ $content['hero_slides'][0]['video_url'] ?? 'https://www.youtube.com/@officialnasdem' }}" target="_blank" class="btn-outline btn-with-icon">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5v14l11-7z"></path>
                </svg>
                Tonton Video
            </a>
        </div>
    </div>

    <!-- Hero Slider Dots -->
    <div class="hero-slider-dots">
        @foreach($content['hero_slides'] ?? [] as $slide)
        <button class="hero-dot {{ $loop->first ? 'active' : '' }}" type="button" aria-label="Slide {{ $loop->iteration }}"></button>
        @endforeach
    </div>

</section>

{{-- ========================================================
     VALUES SECTION (4 PILAR NASDEM)
     ======================================================== --}}
<section class="values-section">
    @php
        $icons = [
            '<path d="M4 5h16M4 12h16M4 19h16" stroke="currentColor" stroke-width="2.3" stroke-linecap="round"/>',
            '<path d="M12 3v18M5 7h14M7 7l-3 7h6L7 7ZM17 7l-3 7h6l-3-7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
            '<path d="M5 19L19 5M9 5h10v10" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"/>',
            '<path d="M12 21s-7-4.5-9.2-9A5.4 5.4 0 0 1 12 6a5.4 5.4 0 0 1 9.2 6c-2.2 4.5-9.2 9-9.2 9Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>'
        ];
    @endphp

    @foreach($content['values'] ?? [] as $idx => $val)
    <div class="value-item">
        <div class="value-icon">
            <svg viewBox="0 0 24 24" fill="none">
                {!! $icons[$idx % count($icons)] !!}
            </svg>
        </div>
        <h3 data-editable="values.{{ $idx }}.title">{{ $val['title'] ?? '' }}</h3>
        <p data-editable="values.{{ $idx }}.desc">{{ $val['desc'] ?? '' }}</p>
    </div>
    @endforeach
</section>

{{-- ========================================================
     NEWS SECTION (DINAMIS DARI ADMIN PUBLIKASI)
     ======================================================== --}}
<section class="news-section" id="berita">
    <div class="section-head">
        <h2 data-editable="news_section.title">{{ $content['news_section']['title'] ?? 'Update Berita' }}</h2>
        <div style="display: flex; align-items: center; gap: 12px;">
            @auth
                @if(auth()->user()->isAdmin())
                <div class="admin-news-add-btn-wrap">
                    <a href="{{ route('admin.berita') }}" class="admin-btn admin-btn-primary" style="font-size: 11px; padding: 6px 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                        <span>⚙️ Kelola Berita Admin</span>
                    </a>
                </div>
                @endif
            @endauth
            <a href="{{ route('berita') }}" style="font-weight: 800; font-size: 14px; color: var(--yellow); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                <span>Lihat Semua Berita</span>
                <span>→</span>
            </a>
        </div>
    </div>

    <div class="news-list">
        @if(isset($latestNews) && $latestNews->isNotEmpty())
            @foreach($latestNews as $news)
            <article class="news-item" style="transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <a href="{{ route('berita.detail', $news->slug) }}" class="news-thumb" style="position: relative; display: block; overflow: hidden; border-radius: 8px;">
                    <img src="{{ $news->image_url }}" alt="{{ $news->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <span style="position: absolute; top: 10px; left: 10px; background: rgba(0, 19, 51, 0.85); color: #ffb700; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 4px; backdrop-filter: blur(4px); text-transform: uppercase;">
                        {{ $news->category }}
                    </span>
                </a>
                <div class="news-info">
                    <h3 style="margin-top: 4px;">
                        <a href="{{ route('berita.detail', $news->slug) }}" style="color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 700; line-height: 1.4;">
                            {{ $news->title }}
                        </a>
                    </h3>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 6px;">
                        <span style="color: #94a3b8; font-size: 12px;">{{ $news->published_at ? $news->published_at->translatedFormat('d M Y') : '' }}</span>
                        <a href="{{ route('berita.detail', $news->slug) }}" style="color: #ffb700; font-size: 12px; font-weight: 700; text-decoration: none;">Baca →</a>
                    </div>
                </div>
            </article>
            @endforeach
        @else
            @foreach($content['news_section']['items'] ?? [] as $item)
            <article class="news-item">
                <a href="{{ route('berita') }}" class="news-thumb">
                    <img src="{{ asset(ltrim($item['image'] ?? 'images/congress.jpg', '/')) }}" alt="{{ $item['title'] ?? '' }}">
                </a>
                <div class="news-info">
                    <h3>
                        <a href="{{ route('berita') }}">
                            {{ $item['title'] ?? '' }}
                        </a>
                    </h3>
                    <span>{{ $item['date'] ?? '' }}</span>
                </div>
            </article>
            @endforeach
        @endif
    </div>
</section>

{{-- ========================================================
     ABOUT SECTION
     ======================================================== --}}
<section class="about-section" id="profil">
    <div class="about-content">
        <div class="section-label" data-editable="about.label">{{ $content['about']['label'] ?? 'Tentang Kami' }}</div>
        <h2 data-editable="about.title">{!! $content['about']['title'] ?? 'Partai <span>NasDem</span>' !!}</h2>
        <p data-editable="about.desc">
            {{ $content['about']['desc'] ?? '' }}
        </p>
        <a href="{{ $content['about']['button_url'] ?? '#profil' }}" class="btn-outline" data-editable="about.button_text">{{ $content['about']['button_text'] ?? 'Pelajari Lebih Lanjut' }}</a>
    </div>
</section>

{{-- ========================================================
     CTA SECTION
     ======================================================== --}}
<section class="cta-section" style="display: block; background: #001333; text-align: center; padding: 60px 20px;">
    <h2 style="font-size: 32px; font-weight: 900; margin-bottom: 24px;" data-editable="cta.title">
        {!! nl2br(e($content['cta']['title'] ?? "Bergabunglah bersama kami\nmenjadi bagian dari perubahan!")) !!}
    </h2>
    <a href="{{ $content['cta']['button_url'] ?? 'https://digital.partainasdem.id/v1/daftar' }}" target="_blank" class="btn-yellow" data-editable="cta.button_text">
        {{ $content['cta']['button_text'] ?? 'Gabung Sekarang' }}
    </a>
</section>

@endsection
