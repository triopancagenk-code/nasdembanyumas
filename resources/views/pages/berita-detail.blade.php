@extends('layouts.app')

@section('title', $article->title . ' – Partai NasDem Banyumas')

@section('content')

{{-- Article Top Navigation / Breadcrumbs --}}
<div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 110px 20px 35px; border-bottom: 3px solid #ffb700;">
    <div style="max-width: 900px; margin: 0 auto;">
        {{-- Breadcrumb --}}
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #94a3b8; margin-bottom: 16px; flex-wrap: wrap;">
            <a href="{{ route('home') }}" style="color: #cbd5e1; text-decoration: none;">Beranda</a>
            <span>/</span>
            <a href="{{ route('berita') }}" style="color: #cbd5e1; text-decoration: none;">Berita</a>
            <span>/</span>
            <a href="{{ route('berita', ['category' => $article->category]) }}" style="color: #ffb700; text-decoration: none; font-weight: 700;">{{ $article->category }}</a>
        </div>

        {{-- Category Badge & Metadata --}}
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; flex-wrap: wrap;">
            <span style="background: #ffb700; color: #001333; font-size: 11.5px; font-weight: 900; padding: 4px 12px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.8px;">
                {{ $article->category }}
            </span>
            <span style="color: #cbd5e1; font-size: 13.5px;">
                🗓️ {{ $article->published_at ? $article->published_at->translatedFormat('l, d F Y') : '' }}
            </span>
            <span style="color: #94a3b8; font-size: 13.5px;">•</span>
            <span style="color: #cbd5e1; font-size: 13.5px;">
                👁️ {{ number_format($article->views_count) }} kali dibaca
            </span>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.berita', ['q' => $article->title]) }}" style="background: rgba(255, 183, 0, 0.2); color: #ffb700; border: 1px solid #ffb700; font-size: 11.5px; font-weight: 800; padding: 3px 10px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                        <span>✏️ Edit di Admin</span>
                    </a>
                @endif
            @endauth
        </div>

        {{-- Headline Title --}}
        <h1 style="font-size: 34px; font-weight: 900; color: #ffffff; line-height: 1.35; margin: 0 0 18px 0;">
            {{ $article->title }}
        </h1>

        {{-- Author Signature --}}
        <div style="display: flex; align-items: center; gap: 10px; color: #cbd5e1; font-size: 13.5px;">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: #ffb700; color: #001333; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 14px;">
                ✍️
            </div>
            <div>
                Oleh <strong style="color: #ffffff;">{{ $article->author_name }}</strong> – DPD Partai NasDem Kabupaten Banyumas
            </div>
        </div>
    </div>
</div>

<div style="max-width: 900px; margin: 40px auto 80px; padding: 0 20px;">

    {{-- Main Banner Image --}}
    <div style="margin-bottom: 36px; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 36px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; background: #001333;">
        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" style="width: 100%; max-height: 500px; object-fit: cover; display: block;">
        <div style="padding: 12px 18px; background: #f8fafc; font-size: 12.5px; color: #64748b; border-top: 1px solid #e2e8f0; font-style: italic;">
            Dokumentasi resmi liputan DPD Partai NasDem Kabupaten Banyumas: {{ $article->title }}
        </div>
    </div>

    {{-- Article Lead (Excerpt) --}}
    @if($article->excerpt)
        <div style="font-size: 18px; font-weight: 600; color: #ffffff; line-height: 1.7; margin-bottom: 28px; padding-left: 18px; border-left: 4px solid #ffb700;">
            {{ $article->excerpt }}
        </div>
    @endif

    {{-- Article Body Content --}}
    <div class="article-content-body" style="font-size: 16.5px; line-height: 1.85; color: #ffffff; margin-bottom: 45px;">
        {!! $article->content !!}
    </div>

    {{-- Share Bar --}}
    <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 50px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
        <div style="font-weight: 800; color: #001333; font-size: 14.5px; display: flex; align-items: center; gap: 8px;">
            <span>📢</span>
            <span>Bagikan Berita Ini ke Media Sosial:</span>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            {{-- WhatsApp Share --}}
            <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . url()->current()) }}" target="_blank" style="background: #25d366; color: #ffffff; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <span>WhatsApp</span>
            </a>

            {{-- Facebook Share --}}
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" style="background: #1877f2; color: #ffffff; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <span>Facebook</span>
            </a>

            {{-- Twitter / X Share --}}
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" style="background: #0f1419; color: #ffffff; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <span>X / Twitter</span>
            </a>

            {{-- Copy Link --}}
            <button type="button" onclick="copyArticleUrl()" style="background: #e2e8f0; color: #1e293b; border: 1px solid #cbd5e1; padding: 8px 14px; border-radius: 6px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                <span id="copyBtnText">🔗 Salin Tautan</span>
            </button>
        </div>
    </div>

    {{-- NasDem Membership Callout --}}
    <div style="background: linear-gradient(135deg, #001333 0%, #002255 100%); border-radius: 16px; padding: 32px; color: #ffffff; margin-bottom: 60px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; border: 2px solid #ffb700;">
        <div style="max-width: 540px;">
            <span style="color: #ffb700; font-size: 12px; font-weight: 900; letter-spacing: 1.5px; text-transform: uppercase;">
                GERAKAN RESTORASI INDONESIA
            </span>
            <h3 style="font-size: 22px; font-weight: 900; margin: 6px 0 8px 0; color: #ffffff;">
                Ingin Menjadi Bagian Perubahan di Banyumas?
            </h3>
            <p style="font-size: 14px; color: #cbd5e1; margin: 0; line-height: 1.6;">
                Daftarkan diri Anda menjadi kader Partai NasDem secara mudah dan gratis melalui platform digital resmi e-KTA NasDem.
            </p>
        </div>
        <a href="https://digital.partainasdem.id/v1/daftar" target="_blank" class="btn-yellow" style="text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 900; font-size: 14px; white-space: nowrap; box-shadow: 0 4px 15px rgba(255, 183, 0, 0.4);">
            Gabung Sekarang →
        </a>
    </div>

    {{-- Related News Section --}}
    @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; border-bottom: 2px solid rgba(255, 255, 255, 0.15); padding-bottom: 12px;">
                <h3 style="font-size: 20px; font-weight: 900; color: #ffffff; margin: 0;">
                    Kabar &amp; Berita Terkait Lainnya
                </h3>
                <a href="{{ route('berita') }}" style="color: #ffb700; font-weight: 800; font-size: 13.5px; text-decoration: none;">
                    Lihat Semua Berita →
                </a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
                @foreach($relatedArticles as $rel)
                    <article style="background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column;">
                        <a href="{{ route('berita.detail', $rel->slug) }}" style="height: 160px; overflow: hidden; background: #001333; display: block;">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </a>
                        <div style="padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <span style="font-size: 11px; font-weight: 800; color: #ffb700; text-transform: uppercase;">
                                    {{ $rel->category }}
                                </span>
                                <h4 style="font-size: 15px; font-weight: 800; color: #001333; margin: 6px 0 10px 0; line-height: 1.4;">
                                    <a href="{{ route('berita.detail', $rel->slug) }}" style="color: inherit; text-decoration: none;">
                                        {{ $rel->title }}
                                    </a>
                                </h4>
                            </div>
                            <div style="font-size: 12px; color: #94a3b8; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                                <span>{{ $rel->published_at ? $rel->published_at->translatedFormat('d M Y') : '' }}</span>
                                <a href="{{ route('berita.detail', $rel->slug) }}" style="color: #001333; font-weight: 800; text-decoration: none;">Baca →</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
    function copyArticleUrl() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const btnText = document.getElementById('copyBtnText');
            btnText.textContent = '✅ Tautan Disalin!';
            setTimeout(() => {
                btnText.textContent = '🔗 Salin Tautan';
            }, 3000);
        }).catch(err => {
            alert('Gagal menyalin tautan: ' + err);
        });
    }
</script>

<style>
    .article-content-body {
        color: #ffffff !important;
    }
    .article-content-body p {
        margin-bottom: 20px;
        color: #ffffff !important;
    }
    .article-content-body strong,
    .article-content-body b {
        color: #ffffff !important;
        font-weight: 800;
    }
    .article-content-body em,
    .article-content-body i {
        color: #e2e8f0 !important;
    }
    .article-content-body h1,
    .article-content-body h2,
    .article-content-body h3,
    .article-content-body h4,
    .article-content-body h5,
    .article-content-body h6 {
        color: #ffffff !important;
        margin: 24px 0 12px 0;
    }
    .article-content-body ul,
    .article-content-body ol {
        color: #ffffff !important;
        padding-left: 24px;
        margin-bottom: 20px;
    }
    .article-content-body li {
        color: #ffffff !important;
        margin-bottom: 8px;
    }
    .article-content-body a {
        color: #ffb700 !important;
        text-decoration: underline;
    }
    .article-content-body blockquote {
        border-left: 4px solid #ffb700;
        padding-left: 16px;
        margin: 20px 0;
        color: #f1f5f9 !important;
        font-style: italic;
    }
</style>

@endsection
