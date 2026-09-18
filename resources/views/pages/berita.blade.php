@extends('layouts.app')

@section('title', 'Kabar & Berita Terkini – Partai NasDem Banyumas')

@section('content')

{{-- Header Banner --}}
<div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 120px 20px 50px; text-align: center; border-bottom: 3px solid #ffb700;">
    <div style="max-width: 950px; margin: 0 auto;">
        <span style="display: inline-block; background: rgba(255, 183, 0, 0.15); color: #ffb700; font-size: 12px; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; padding: 6px 16px; border-radius: 20px; margin-bottom: 16px; border: 1px solid rgba(255, 183, 0, 0.4);">
            INFORMASI &amp; KEGIATAN RESMI
        </span>
        <h1 style="font-size: 38px; font-weight: 900; color: #ffffff; margin: 0 0 16px 0;">
            Kabar &amp; Berita <span style="color: #ffb700;">Partai NasDem</span>
        </h1>
        <p style="font-size: 16px; color: #cbd5e1; max-width: 680px; margin: 0 auto 26px; line-height: 1.6;">
            Liputan resmi kegiatan partai, aksi sosial peduli masyarakat, konsolidasi 27 kecamatan, pandangan fraksi di DPRD Banyumas, dan kabar restorasi perubahan.
        </p>

        <!-- Search Bar -->
        <form action="{{ route('berita') }}" method="GET" style="max-width: 540px; margin: 0 auto; display: flex; gap: 8px;">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita, topik, kegiatan..." style="flex: 1; padding: 13px 20px; border-radius: 30px; border: 1.5px solid rgba(255,255,255,0.25); background: rgba(255,255,255,0.08); color: #ffffff; font-size: 14.5px; outline: none; backdrop-filter: blur(8px);">
            <button type="submit" class="btn-yellow" style="padding: 13px 26px; border-radius: 30px; font-weight: 800; border: none; cursor: pointer; white-space: nowrap; box-shadow: 0 4px 15px rgba(255, 183, 0, 0.35);">
                🔍 Cari
            </button>
        </form>
    </div>
</div>

<div style="max-width: 1240px; margin: 40px auto 80px; padding: 0 20px;">

    <!-- Category Filter Pills -->
    <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 12px; margin-bottom: 30px; align-items: center;">
        <a href="{{ route('berita', request('q') ? ['q' => request('q')] : []) }}" style="text-decoration: none; padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 800; white-space: nowrap; transition: all 0.2s ease; {{ !request('category') ? 'background: #ffb700; color: #001333; box-shadow: 0 4px 12px rgba(255, 183, 0, 0.35);' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;' }}">
            Semua Berita
        </a>
        @foreach($categories as $catName => $catCount)
            <a href="{{ route('berita', array_merge(request()->except(['category', 'page']), ['category' => $catName])) }}" style="text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 800; white-space: nowrap; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 6px; {{ request('category') === $catName ? 'background: #001333; color: #ffb700; border: 1.5px solid #ffb700;' : 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;' }}">
                <span>{{ $catName }}</span>
                <span style="font-size: 11px; padding: 1px 7px; border-radius: 10px; {{ request('category') === $catName ? 'background: #ffb700; color: #001333;' : 'background: #e2e8f0; color: #64748b;' }}">
                    {{ $catCount }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Active Search / Filter Badge -->
    @if(request('q') || request('category'))
        <div style="margin-bottom: 28px; padding: 14px 20px; background: #f8fafc; border-radius: 10px; border-left: 4px solid #ffb700; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div style="font-size: 14.5px; color: #334155;">
                Menampilkan hasil
                @if(request('category'))
                    kategori <strong>"{{ request('category') }}"</strong>
                @endif
                @if(request('q'))
                    pencarian untuk <strong>"{{ request('q') }}"</strong>
                @endif
                ({{ $articles->total() }} berita ditemukan)
            </div>
            <a href="{{ route('berita') }}" style="color: #ef4444; font-weight: 800; font-size: 13.5px; text-decoration: none;">
                ✕ Hapus Filter
            </a>
        </div>
    @endif

    <!-- Featured News Highlight (Shown on Page 1 without search filter) -->
    @if(isset($featuredArticle) && $featuredArticle)
        <div style="margin-bottom: 40px; background: #ffffff; border-radius: 18px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.06); display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));">
            <div style="position: relative; min-height: 320px; background: #001333; overflow: hidden;">
                <img src="{{ $featuredArticle->image_url }}" alt="{{ $featuredArticle->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                <span style="position: absolute; top: 16px; left: 16px; background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 5px 12px; border-radius: 4px; text-transform: uppercase; letter-spacing: 1px;">
                    BERITA UTAMA
                </span>
            </div>
            <div style="padding: 36px 32px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="background: rgba(0, 19, 51, 0.08); color: #001333; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 4px;">
                            {{ $featuredArticle->category }}
                        </span>
                        <span style="font-size: 13px; color: #64748b;">
                            {{ $featuredArticle->published_at ? $featuredArticle->published_at->translatedFormat('d F Y') : '' }}
                        </span>
                    </div>
                    <h2 style="font-size: 24px; font-weight: 900; color: #001333; line-height: 1.35; margin: 0 0 14px 0;">
                        <a href="{{ route('berita.detail', $featuredArticle->slug) }}" style="color: inherit; text-decoration: none;">
                            {{ $featuredArticle->title }}
                        </a>
                    </h2>
                    <p style="font-size: 14.5px; color: #475569; line-height: 1.7; margin: 0 0 20px 0;">
                        {{ $featuredArticle->excerpt }}
                    </p>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #f1f5f9; padding-top: 18px;">
                    <div style="font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 6px;">
                        <span>✍️ {{ $featuredArticle->author_name }}</span>
                    </div>
                    <a href="{{ route('berita.detail', $featuredArticle->slug) }}" class="btn-yellow" style="text-decoration: none; padding: 10px 22px; border-radius: 8px; font-weight: 800; font-size: 13.5px; display: inline-flex; align-items: center; gap: 6px;">
                        <span>Baca Berita Lengkap</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- News Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(330px, 1fr)); gap: 28px;">
        @forelse($articles as $item)
            @if(isset($featuredArticle) && $featuredArticle && $featuredArticle->id === $item->id)
                @continue
            @endif
            <article style="background: #ffffff; border-radius: 14px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.06); border: 1.5px solid #e2e8f0; display: flex; flex-direction: column; transition: transform 0.25s ease, box-shadow 0.25s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 16px 36px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.06)';">
                <a href="{{ route('berita.detail', $item->slug) }}" style="position: relative; height: 210px; overflow: hidden; background: #001333; display: block;">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
                    <span style="position: absolute; top: 12px; left: 12px; background: rgba(0, 19, 51, 0.85); color: #ffb700; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 4px; backdrop-filter: blur(4px); text-transform: uppercase;">
                        {{ $item->category }}
                    </span>
                </a>
                <div style="padding: 24px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 12px; color: #94a3b8; margin-bottom: 10px;">
                            <span>🗓️ {{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : '' }}</span>
                            <span>👁️ {{ number_format($item->views_count) }} views</span>
                        </div>
                        <h2 style="font-size: 17.5px; font-weight: 800; color: #001333; margin: 0 0 12px 0; line-height: 1.45;">
                            <a href="{{ route('berita.detail', $item->slug) }}" style="color: inherit; text-decoration: none;">
                                {{ $item->title }}
                            </a>
                        </h2>
                        <p style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin: 0 0 18px 0;">
                            {{ Str::limit($item->excerpt, 130) }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #f1f5f9; padding-top: 14px; margin-top: 6px;">
                        <span style="font-size: 12px; color: #64748b; font-weight: 600;">
                            {{ Str::limit($item->author_name, 22) }}
                        </span>
                        <a href="{{ route('berita.detail', $item->slug) }}" style="color: #001333; font-weight: 800; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: gap 0.15s ease;" onmouseover="this.style.color='#ffb700';" onmouseout="this.style.color='#001333';">
                            <span>Baca Selengkapnya</span>
                            <span style="color: #ffb700; font-size: 16px;">→</span>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 70px 20px; background: #f8fafc; border-radius: 16px; border: 1.5px dashed #cbd5e1;">
                <span style="font-size: 52px; display: block; margin-bottom: 14px;">📰</span>
                <h3 style="font-size: 20px; font-weight: 800; color: #001333; margin: 0 0 8px 0;">Tidak Ada Berita Ditemukan</h3>
                <p style="font-size: 14.5px; color: #64748b; margin: 0 auto 20px; max-width: 500px;">
                    @if(request('q') || request('category'))
                        Tidak ada berita yang cocok dengan kata kunci atau kategori yang Anda pilih. Silakan gunakan kata kunci lain atau reset filter.
                    @else
                        Belum ada berita yang diterbitkan saat ini. Silakan kembali lagi nanti untuk informasi terkini.
                    @endif
                </p>
                <a href="{{ route('berita') }}" class="btn-yellow" style="display: inline-block; text-decoration: none; padding: 10px 24px; border-radius: 8px; font-weight: 800; font-size: 14px;">
                    Lihat Semua Berita
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div style="margin-top: 50px; display: flex; justify-content: center;">
            {{ $articles->links() }}
        </div>
    @endif

</div>

@endsection
