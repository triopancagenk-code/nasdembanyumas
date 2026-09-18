@extends('layouts.app')

@section('title', 'DPD Partai NasDem Kabupaten Banyumas – Bersatu Berjuang Menang')

@section('top_bar')
<!-- ========================================================
     TOP STRIP (KOLOM ASPIRASI & SOSIAL MEDIA - PERSIS nasdemjakarta.com)
     ======================================================== -->
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 7px 32px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; font-weight: 700; position: relative; z-index: 1000; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <button type="button" onclick="openAspirasiModal()" style="background: none; border: none; color: #001333; font-weight: 800; cursor: pointer; padding: 0; font-size: 13px; text-decoration: none; transition: color 0.15s ease;" onmouseover="this.style.color='#f8bd00'" onmouseout="this.style.color='#001333'">
            Kolom Aspirasi
        </button>
    </div>

    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- Instagram -->
        <a href="https://www.instagram.com" target="_blank" aria-label="Instagram" style="width: 28px; height: 28px; border-radius: 50%; background: #001844; color: #ffffff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.15s ease, background 0.15s ease;" onmouseover="this.style.background='#f8bd00'; this.style.color='#001844'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#001844'; this.style.color='#ffffff'; this.style.transform='none';">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                <circle cx="12" cy="12" r="4"></circle>
            </svg>
        </a>
        <!-- TikTok -->
        <a href="https://www.tiktok.com" target="_blank" aria-label="TikTok" style="width: 28px; height: 28px; border-radius: 50%; background: #001844; color: #ffffff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.15s ease, background 0.15s ease;" onmouseover="this.style.background='#f8bd00'; this.style.color='#001844'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#001844'; this.style.color='#ffffff'; this.style.transform='none';">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19.6 8.7C17.9 8.7 16.4 8.2 15.2 7V16.1C15.2 20 12.3 22 9.4 22C6.3 22 3.8 19.5 3.8 16.4C3.8 13.3 6.3 10.8 9.4 10.8C9.9 10.8 10.4 10.9 10.9 11V14C10.4 13.7 9.9 13.6 9.4 13.6C7.9 13.6 6.7 14.8 6.7 16.3C6.7 17.8 7.9 19 9.4 19C11.1 19 12.2 17.7 12.2 16.1V2H15.1C15.4 4.5 17.4 6.5 19.9 6.8V8.7H19.6Z"/>
            </svg>
        </a>
        <!-- Twitter / X -->
        <a href="https://twitter.com" target="_blank" aria-label="Twitter" style="width: 28px; height: 28px; border-radius: 50%; background: #001844; color: #ffffff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.15s ease, background 0.15s ease;" onmouseover="this.style.background='#f8bd00'; this.style.color='#001844'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#001844'; this.style.color='#ffffff'; this.style.transform='none';">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.847h-7.406l-5.8-7.584-6.639 7.584H.474l8.6-9.83L0 1.153h7.594l5.243 6.932L18.901 1.153Zm-1.29 19.494h2.039L6.486 3.248H4.298L17.611 20.647Z"/>
            </svg>
        </a>
        <!-- Facebook -->
        <a href="https://facebook.com" target="_blank" aria-label="Facebook" style="width: 28px; height: 28px; border-radius: 50%; background: #001844; color: #ffffff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.15s ease, background 0.15s ease;" onmouseover="this.style.background='#f8bd00'; this.style.color='#001844'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='#001844'; this.style.color='#ffffff'; this.style.transform='none';">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                <path d="M13.5 22V12.9H16.5L17 9.4H13.5V7.2C13.5 6.2 13.8 5.5 15.2 5.5H17.1V2.3C16.8 2.3 15.8 2.2 14.6 2.2C12 2.2 10.2 3.8 10.2 6.8V9.4H7V12.9H10.2V22H13.5Z"/>
            </svg>
        </a>
    </div>
</div>
@endsection

@section('content')

<!-- ========================================================
     HERO BANNER DPD BANYUMAS (SURYA PALOH & EDRIS SANTOSO, S.E.)
     ======================================================== -->
<section style="position: relative; background: #ffffff; border-bottom: 3px solid #ffb700; overflow: hidden;">
    <div style="width: 100%; max-width: 100%; margin: 0 auto; position: relative;">
        <!-- Banner Asli DPD Banyumas: Surya Paloh & Ketua DPD Edris Santoso, S.E. -->
        <img src="{{ asset('images/dpd_hero_banner.jpg') }}?v={{ file_exists(public_path('images/dpd_hero_banner.jpg')) ? filemtime(public_path('images/dpd_hero_banner.jpg')) : time() }}" alt="Partai NasDem GERAKAN PERUBAHAN DPD BANYUMAS – Surya Paloh & EDRIS SANTOSO, S.E." style="width: 100%; height: auto; display: block; max-width: 100%;">

        <!-- Nameplate Kiri: SURYA PALOH -->
        <div class="banner-nameplate-left" style="position: absolute; bottom: 32px; left: 6%; z-index: 15;">
            <div style="background: #ffffff; color: #001844; font-weight: 900; font-size: clamp(14px, 1.8vw, 24px); padding: 8px clamp(16px, 2.5vw, 36px); border-radius: 8px 26px 8px 8px; box-shadow: 0 8px 24px rgba(0, 24, 68, 0.22); letter-spacing: 0.5px; text-transform: uppercase; border: 1px solid rgba(0,0,0,0.06); display: inline-block;">
                SURYA PALOH
            </div>
            <div>
                <div style="background: #ffb700; color: #001844; font-weight: 900; font-size: clamp(9px, 1vw, 12px); padding: 5px clamp(12px, 1.8vw, 22px); border-radius: 0 0 14px 14px; margin-top: -2px; display: inline-block; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 4px 12px rgba(0,0,0,0.12);">
                    KETUA UMUM PARTAI NASDEM
                </div>
            </div>
        </div>

        <!-- Nameplate Kanan: EDRIS SANTOSO, S.E. -->
        <div class="banner-nameplate-right" style="position: absolute; bottom: 32px; right: 6%; z-index: 15; text-align: right;">
            <div style="background: #ffffff; color: #001844; font-weight: 900; font-size: clamp(14px, 1.8vw, 24px); padding: 8px clamp(16px, 2.5vw, 36px); border-radius: 26px 8px 8px 8px; box-shadow: 0 8px 24px rgba(0, 24, 68, 0.22); letter-spacing: 0.5px; text-transform: uppercase; border: 1px solid rgba(0,0,0,0.06); display: inline-block;">
                EDRIS SANTOSO, S.E.
            </div>
            <div>
                <div style="background: #ffb700; color: #001844; font-weight: 900; font-size: clamp(9px, 1vw, 12px); padding: 5px clamp(12px, 1.8vw, 22px); border-radius: 0 0 14px 14px; margin-top: -2px; display: inline-block; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 4px 12px rgba(0,0,0,0.12);">
                    KETUA DPD PARTAI NASDEM BANYUMAS
                </div>
            </div>
        </div>

        <!-- Aksen Garis Gelombang Bawah -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 10px; background: linear-gradient(90deg, #001844 0%, #002877 50%, #ffb700 100%);"></div>
    </div>
</section>

<!-- ========================================================
     SECTION PROFIL KETUA DPD PARTAI NASDEM KABUPATEN BANYUMAS
     ======================================================== -->
<section style="background: #ffffff; padding: 70px 24px 65px; border-bottom: 1px solid #e2e8f0;">
    <div style="max-width: 1200px; margin: 0 auto;">

        <!-- 2 Kolom: Foto Ketua Kiri & Teks Kanan -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 50px; align-items: center; margin-bottom: 0;">

            <!-- Foto Ketua DPD Banyumas (EDRIS SANTOSO, S.E.) -->
            <div style="text-align: center;">
                <div style="display: inline-block; max-width: 380px; width: 100%; border-radius: 20px; overflow: hidden; box-shadow: 0 16px 40px rgba(0, 24, 68, 0.16); border: 4px solid #ffffff; outline: 3px solid #ffb700;">
                    <img src="{{ asset('images/ketua_dpd.jpg') }}" alt="EDRIS SANTOSO, S.E. – Ketua DPD Partai NasDem Kabupaten Banyumas" style="width: 100%; height: auto; display: block; object-fit: cover;">
                </div>
            </div>

            <!-- Teks Profil Ketua DPD Banyumas -->
            <div>
                <span style="background: #001844; color: #ffb700; font-size: 11px; font-weight: 900; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 10px;">
                    DPD PARTAI NASDEM BANYUMAS
                </span>
                <h2 style="font-size: 34px; font-weight: 900; color: #001844; margin: 0 0 8px 0; letter-spacing: 0.5px; text-transform: uppercase;">
                    EDRIS SANTOSO, S.E.
                </h2>
                <h4 style="font-size: 16.5px; font-weight: 800; color: #e11d48; margin: 0 0 22px 0;">
                    Ketua DPD Partai NasDem Kabupaten Banyumas
                </h4>

                <div style="font-size: 14.5px; line-height: 1.8; color: #334155; margin-bottom: 24px;">
                    <p style="margin: 0 0 14px 0;">
                        <strong>Edris Santoso, S.E.</strong> adalah tokoh penggerak dan Ketua Dewan Pimpinan Daerah (DPD) Partai NasDem Kabupaten Banyumas masa bakti 2024–2029. Beliau memimpin konsolidasi gerakan Restorasi Indonesia di seluruh 27 Kecamatan dan 331 Desa/Kelurahan se-Kabupaten Banyumas.
                    </p>
                    <p style="margin: 0 0 14px 0;">
                        Berkomitmen teguh pada prinsip <strong>Politik Tanpa Mahar</strong>, beliau senantiasa memperjuangkan peningkatan kesejahteraan petani, pengrajin lokal, pedagang pasar tradisional, UMKM, serta membuka ruang kreasi dan kepemimpinan bagi generasi muda Banyumas.
                    </p>
                    <p style="margin: 0 0 14px 0;">
                        Di bawah kepemimpinannya, DPD Partai NasDem Kabupaten Banyumas aktif mengawal program-program kerakyatan melalui Fraksi NasDem di DPRD Kabupaten Banyumas, menggalang aksi sosial ambulans gratis, serta menghadirkan keterbukaan informasi publik yang nyata bagi seluruh warga Banyumas.
                    </p>
                </div>

                <!-- 3 Social Circle Icons (Instagram, Facebook, Twitter) -->
                <div style="display: flex; gap: 10px;">
                    <a href="https://instagram.com" target="_blank" aria-label="Instagram" style="width: 36px; height: 36px; border-radius: 50%; background: #001844; color: #ffffff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.15s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='none'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                            <circle cx="12" cy="12" r="4"></circle>
                        </svg>
                    </a>
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook" style="width: 36px; height: 36px; border-radius: 50%; background: #001844; color: #ffffff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.15s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='none'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13.5 22V12.9H16.5L17 9.4H13.5V7.2C13.5 6.2 13.8 5.5 15.2 5.5H17.1V2.3C16.8 2.3 15.8 2.2 14.6 2.2C12 2.2 10.2 3.8 10.2 6.8V9.4H7V12.9H10.2V22H13.5Z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com" target="_blank" aria-label="Twitter" style="width: 36px; height: 36px; border-radius: 50%; background: #001844; color: #ffffff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.15s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='none'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.847h-7.406l-5.8-7.584-6.639 7.584H.474l8.6-9.83L0 1.153h7.594l5.243 6.932L18.901 1.153Zm-1.29 19.494h2.039L6.486 3.248H4.298L17.611 20.647Z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================
     SECTION MENGENAL LEBIH DEKAT ANGGOTA DEWAN & TOKOH NASDEM BANYUMAS (LATAR KUNING EMAS)
     ======================================================== -->
<section style="background: #ffb700; padding: 75px 24px 80px;">
    <div style="max-width: 1300px; margin: 0 auto;">

        <!-- Section Title Header -->
        <div style="text-align: center; margin-bottom: 45px;">
            <p style="font-size: 15px; font-weight: 800; letter-spacing: 2.5px; color: #001844; margin: 0 0 6px 0; text-transform: uppercase;">
                MENGENAL LEBIH DEKAT
            </p>
            <h2 style="font-size: 32px; font-weight: 900; color: #001844; margin: 0 0 16px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                ANGGOTA DEWAN &amp; PENGURUS DPD NASDEM BANYUMAS
            </h2>
            <div style="width: 60px; height: 3.5px; background: #001844; margin: 0 auto 30px;"></div>

            <!-- Filter Category Tabs -->
            <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 35px;">
                <button type="button" onclick="filterDpdCategory('all')" id="tabDpdAll" class="dpd-filter-btn active" style="background: #001844; color: #ffb700; border: none; padding: 8px 18px; border-radius: 20px; font-size: 12.5px; font-weight: 800; cursor: pointer; transition: all 0.15s ease;">
                    Semua Pengurus ({{ $officers->count() }})
                </button>
                <button type="button" onclick="filterDpdCategory('inti')" id="tabDpdInti" class="dpd-filter-btn" style="background: rgba(0, 24, 68, 0.12); color: #001844; border: 1.5px solid #001844; padding: 8px 18px; border-radius: 20px; font-size: 12.5px; font-weight: 800; cursor: pointer; transition: all 0.15s ease;">
                    Pengurus Inti &amp; Badan ({{ $intiOfficers->count() }})
                </button>
                <button type="button" onclick="filterDpdCategory('bidang')" id="tabDpdBidang" class="dpd-filter-btn" style="background: rgba(0, 24, 68, 0.12); color: #001844; border: 1.5px solid #001844; padding: 8px 18px; border-radius: 20px; font-size: 12.5px; font-weight: 800; cursor: pointer; transition: all 0.15s ease;">
                    Wakil Ketua Bidang ({{ $bidangOfficers->count() }})
                </button>
            </div>
        </div>

        <!-- Grid Tokoh & Anggota Dewan / Pengurus DPD Banyumas -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 22px;" id="dpdOfficersGrid">
            @forelse($officers as $officer)
            <div class="dpd-card-item" data-category="{{ $officer->category }}" style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 24px rgba(0, 24, 68, 0.12); text-align: center; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s ease;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='none'">
                <div style="background: #001844; height: 260px; overflow: hidden; position: relative;">
                    <img src="{{ asset(ltrim($officer->photo ?: 'images/default_avatar.svg', '/')) }}" alt="{{ $officer->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <span style="position: absolute; top: 10px; right: 10px; background: {{ $officer->category === 'inti' ? '#e11d48' : '#0284c7' }}; color: #ffffff; font-size: 10px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $officer->category === 'inti' ? 'Pengurus Inti' : 'Wakil Ketua Bidang' }}
                    </span>
                </div>
                <div style="padding: 18px 14px 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3 style="font-size: 15px; font-weight: 900; color: #001844; margin: 0 0 6px 0; line-height: 1.3; min-height: 20px;">
                            {{ $officer->name }}
                        </h3>
                        <p style="font-size: 12px; font-weight: 800; color: #e11d48; margin: 0 0 8px 0; text-transform: uppercase;">
                            {{ $officer->title }}
                        </p>
                        <p style="font-size: 11.5px; color: #64748b; margin: 0 0 12px 0; line-height: 1.4;">
                            SK: {{ $officer->sk_number ?: '-' }}<br>
                            @if($officer->phone)
                                📞 {{ $officer->phone }}
                            @endif
                        </p>
                    </div>

                    <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 6px;">
                        <a href="https://instagram.com" target="_blank" aria-label="Instagram" style="width: 30px; height: 30px; border-radius: 50%; background: #001844; color: #ffffff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                                <circle cx="12" cy="12" r="4"></circle>
                            </svg>
                        </a>

                        @auth
                            @if(auth()->user()->isAdmin())
                            <button type="button" onclick="openEditDpdModal({{ $officer->id }}, '{{ addslashes($officer->name ?? '') }}', '{{ addslashes($officer->title) }}', '{{ addslashes($officer->category) }}', '{{ addslashes($officer->phone ?? '') }}', '{{ addslashes($officer->sk_number ?? '') }}', '{{ addslashes($officer->photo ?? '') }}', '{{ addslashes($officer->status) }}')" style="background: #ffb700; color: #001844; border: none; padding: 5px 12px; border-radius: 4px; font-size: 11px; font-weight: 900; cursor: pointer;">
                                ✏️ Edit
                            </button>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #ffffff; border-radius: 12px;">
                <p style="color: #64748b; font-weight: 700; margin: 0;">Data pengurus belum tersedia.</p>
            </div>
            @endforelse
        </div>

    </div>
</section>

<!-- ========================================================
     SECTION PUBLIKASI / BERITA DPD BANYUMAS (LATAR BIRU TUA KEREN)
     ======================================================== -->
<section style="background: #0a2880; color: #ffffff; padding: 75px 24px 80px;">
    <div style="max-width: 1300px; margin: 0 auto;">

        <!-- 3 Kolom Kategori Berita -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 35px;">

            <!-- Kolom 1: RUBRIK TERBARU -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid rgba(255,255,255,0.2); padding-bottom: 12px; margin-bottom: 22px;">
                    <h3 style="font-size: 18px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                        RUBRIK<br>TERBARU
                    </h3>
                    <a href="{{ route('berita') }}" class="btn-yellow" style="padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        Selengkapnya →
                    </a>
                </div>

                <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); color: #001844;">
                    <div style="height: 220px; overflow: hidden;">
                        <img src="{{ asset('images/news_2.jpg') }}" alt="Berita DPD NasDem Banyumas" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 22px 20px 24px;">
                        <h4 style="font-size: 15.5px; font-weight: 800; margin: 0 0 12px 0; line-height: 1.5; color: #001844;">
                            DPD NasDem Banyumas Rapatkan Barisan, Siapkan Konsolidasi Kader di 27 Kecamatan
                        </h4>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                            by Tim Media DPD Banyumas | September 14, 2026
                        </div>
                    </div>
                </div>

                <!-- Carousel Dots -->
                <div style="display: flex; justify-content: center; gap: 6px; margin-top: 18px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #ffffff;"></span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4);"></span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4);"></span>
                </div>
            </div>

            <!-- Kolom 2: KABAR DPD BANYUMAS -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid rgba(255,255,255,0.2); padding-bottom: 12px; margin-bottom: 22px;">
                    <h3 style="font-size: 18px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                        KABAR<br>DPD BANYUMAS
                    </h3>
                    <a href="{{ route('berita') }}" class="btn-yellow" style="padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        Selengkapnya →
                    </a>
                </div>

                <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); color: #001844;">
                    <div style="height: 220px; overflow: hidden;">
                        <img src="{{ asset('images/news_1.jpg') }}" alt="Berita DPD Banyumas" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 22px 20px 24px;">
                        <h4 style="font-size: 15.5px; font-weight: 800; margin: 0 0 12px 0; line-height: 1.5; color: #001844;">
                            Ketua DPD Edris Santoso Tegaskan Komitmen Politik Tanpa Mahar dan Bela Wong Cilik
                        </h4>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                            by Tim Media DPD Banyumas | September 10, 2026
                        </div>
                    </div>
                </div>

                <!-- Carousel Dots -->
                <div style="display: flex; justify-content: center; gap: 6px; margin-top: 18px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #ffffff;"></span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4);"></span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4);"></span>
                </div>
            </div>

            <!-- Kolom 3: KABAR FRAKSI DPRD BANYUMAS -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid rgba(255,255,255,0.2); padding-bottom: 12px; margin-bottom: 22px;">
                    <h3 style="font-size: 18px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                        KABAR<br>FRAKSI DPRD
                    </h3>
                    <a href="{{ route('berita') }}" class="btn-yellow" style="padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        Selengkapnya →
                    </a>
                </div>

                <div style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); color: #001844;">
                    <div style="height: 220px; overflow: hidden;">
                        <img src="{{ asset('images/news_3.jpg') }}" alt="Kabar Fraksi NasDem Banyumas" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 22px 20px 24px;">
                        <h4 style="font-size: 15.5px; font-weight: 800; margin: 0 0 12px 0; line-height: 1.5; color: #001844;">
                            Fraksi NasDem DPRD Banyumas Kawal Anggaran Pembangunan Jalan Desa dan Irigasi Pertanian
                        </h4>
                        <div style="font-size: 12px; color: #64748b; font-weight: 600;">
                            by Fraksi NasDem Banyumas | September 6, 2026
                        </div>
                    </div>
                </div>

                <!-- Carousel Dots -->
                <div style="display: flex; justify-content: center; gap: 6px; margin-top: 18px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #ffffff;"></span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4);"></span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.4);"></span>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================
     SECTION PPID NASDEM BANYUMAS & GABUNG NASDEM / SOSIAL MEDIA
     ======================================================== -->
<section style="background: #ffffff; padding: 75px 24px 75px;">
    <div style="max-width: 1150px; margin: 0 auto;">

        <!-- Title PPID NASDEM BANYUMAS -->
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 26px; font-weight: 900; color: #001844; margin: 0; text-transform: uppercase;">
                PPID <span style="border-bottom: 3px solid #001844; padding-bottom: 4px;">NASDEM BANYUMAS</span>
            </h2>
        </div>

        <!-- 3 Kartu Berborder Biru -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 60px;">

            <!-- Card 1: Daftar Informasi Publik -->
            <div style="border: 2px solid #002266; border-radius: 14px; padding: 28px 20px; text-align: center; background: #ffffff; box-shadow: 0 4px 14px rgba(0,0,0,0.03);">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: #ffb700; color: #001844; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 22px;">
                    ☰
                </div>
                <h4 style="font-size: 15.5px; font-weight: 900; color: #001844; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    DAFTAR INFORMASI PUBLIK
                </h4>
            </div>

            <!-- Card 2: Laporan PPID -->
            <div style="border: 2px solid #002266; border-radius: 14px; padding: 28px 20px; text-align: center; background: #ffffff; box-shadow: 0 4px 14px rgba(0,0,0,0.03);">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: #ffb700; color: #001844; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 22px;">
                    📖
                </div>
                <h4 style="font-size: 15.5px; font-weight: 900; color: #001844; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    LAPORAN PPID
                </h4>
            </div>

            <!-- Card 3: Tata Cara Pengajuan -->
            <div style="border: 2px solid #002266; border-radius: 14px; padding: 28px 20px; text-align: center; background: #ffffff; box-shadow: 0 4px 14px rgba(0,0,0,0.03);">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: #ffb700; color: #001844; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 22px;">
                    ✏️
                </div>
                <h4 style="font-size: 15.5px; font-weight: 900; color: #001844; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    TATA CARA PENGAJUAN
                </h4>
            </div>

        </div>

        <!-- 2 Kolom: GABUNG NASDEM & SOSIAL MEDIA -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 45px; align-items: flex-start;">

            <!-- Kiri: GABUNG NASDEM -->
            <div>
                <h3 style="font-size: 20px; font-weight: 900; color: #001844; margin: 0 0 16px 0; text-transform: uppercase;">
                    <span style="border-bottom: 3px solid #ffb700; padding-bottom: 4px;">GABUNG</span> NASDEM BANYUMAS
                </h3>
                <p style="font-size: 14.5px; line-height: 1.7; color: #334155; margin: 0 0 20px 0;">
                    Partai NasDem Kabupaten Banyumas mengajak seluruh lapisan masyarakat untuk menjadi bagian dalam Gerakan Restorasi Indonesia di Banyumas. Mari bergabung bersama kami !
                </p>
                <a href="https://digital.partainasdem.id" target="_blank" class="btn-yellow" style="padding: 10px 24px; border-radius: 20px; font-size: 13px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    GABUNG SEKARANG →
                </a>
            </div>

            <!-- Kanan: SOSIAL MEDIA -->
            <div>
                <h3 style="font-size: 20px; font-weight: 900; color: #001844; margin: 0 0 20px 0; text-transform: uppercase;">
                    <span style="border-bottom: 3px solid #ffb700; padding-bottom: 4px;">SOSIAL</span> MEDIA
                </h3>
                <div>
                    <a href="https://www.instagram.com" target="_blank" style="background: #2563eb; color: #ffffff; padding: 10px 20px; border-radius: 6px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background 0.15s ease;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                            <circle cx="12" cy="12" r="4"></circle>
                        </svg>
                        Follow on Instagram
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">

<style>
    /* Paksa warna tulisan/text pada seluruh input form modal menjadi hitam solid */
    #editDpdModal input,
    #editDpdModal select,
    #editDpdModal textarea,
    #editDpdModal .admin-form-control,
    .admin-form-control {
        color: #000000 !important;
        background-color: #ffffff !important;
        -webkit-text-fill-color: #000000 !important;
        font-weight: 600 !important;
    }

    #editDpdModal input:focus,
    #editDpdModal select:focus,
    #editDpdModal textarea:focus {
        color: #000000 !important;
        background-color: #ffffff !important;
        -webkit-text-fill-color: #000000 !important;
    }

    #editDpdModal select option {
        color: #000000 !important;
        background-color: #ffffff !important;
    }

    #editDpdModal label {
        color: #1e293b !important;
        font-weight: 800 !important;
    }

    /* Cropper modal buttons */
    .crop-ratio-btn {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 800;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #001844;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .crop-ratio-btn:hover {
        border-color: #001844;
    }

    .crop-ratio-btn.active {
        background: #001844 !important;
        color: #ffb700 !important;
        border-color: #001844 !important;
    }
</style>

<!-- ========================================================
     MODAL EDIT PENGURUS DPD BANYUMAS (POV ADMIN)
     ======================================================== -->
<div id="editDpdModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeEditDpdModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 24, 68, 0.85); backdrop-filter: blur(4px);"></div>
    <div style="position: relative; background: #ffffff; border-radius: 14px; max-width: 540px; width: 100%; overflow: hidden; z-index: 2; box-shadow: 0 20px 40px rgba(0,0,0,0.5); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; max-height: 92vh; display: flex; flex-direction: column;">
        <div style="background: #001844; color: #ffffff; padding: 16px 20px; border-bottom: 2px solid #ffb700; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16.5px; font-weight: 800; color: #ffffff;" id="editDpdModalTitle">✏️ Edit Pengurus DPD</h3>
            <button type="button" onclick="closeEditDpdModal()" style="background: none; border: none; color: #cbd5e1; font-size: 22px; cursor: pointer;">&times;</button>
        </div>
        <form id="editDpdForm" onsubmit="submitDpdEdit(event)" style="padding: 22px; overflow-y: auto;">
            <input type="hidden" id="editDpdId">
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Nama Lengkap &amp; Gelar</label>
                <input type="text" id="editDpdName" class="admin-form-control" placeholder="Contoh: Drs. H. Ahmad Fauzi, M.Si.">
            </div>
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Jabatan / Struktur *</label>
                <input type="text" id="editDpdTitle" class="admin-form-control" required placeholder="Contoh: Wakil Ketua">
            </div>
            <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Kategori Pengurus</label>
                    <select id="editDpdCategory" class="admin-form-control">
                        <option value="inti">Pengurus Inti &amp; Badan</option>
                        <option value="bidang">Wakil Ketua Bidang</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Status</label>
                    <select id="editDpdStatus" class="admin-form-control">
                        <option value="Aktif">Aktif</option>
                        <option value="Cuti">Cuti</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Nomor SK Kepengurusan</label>
                    <input type="text" id="editDpdSk" class="admin-form-control" placeholder="Contoh: SK-DPP/ND/014/2024">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Nomor Telepon / WhatsApp</label>
                    <input type="text" id="editDpdPhone" class="admin-form-control" placeholder="0812-xxxx-xxxx">
                </div>
            </div>

            <!-- Bagian Unggah & Crop Foto -->
            <div style="margin-bottom: 16px; background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 10px; padding: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #001844; margin-bottom: 8px;">
                    Foto Profil Pengurus
                </label>
                
                <div style="display: flex; align-items: center; gap: 16px;">
                    <!-- Preview Foto -->
                    <div style="width: 74px; height: 92px; border-radius: 8px; overflow: hidden; background: #001844; border: 2px solid #ffb700; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.12);">
                        <img id="editDpdPhotoPreview" src="{{ asset('images/default_avatar.svg') }}" alt="Preview Foto" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <!-- Tombol Unggah & Crop -->
                    <div style="flex: 1;">
                        <input type="file" id="dpdPhotoFileInput" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="handleDpdPhotoSelected(event)">
                        
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 6px;">
                            <button type="button" onclick="document.getElementById('dpdPhotoFileInput').click()" style="background: #001844; color: #ffb700; border: 1.5px solid #ffb700; padding: 7px 14px; border-radius: 6px; font-size: 12px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease;" onmouseover="this.style.background='#ffb700'; this.style.color='#001844';" onmouseout="this.style.background='#001844'; this.style.color='#ffb700';">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                Unggah &amp; Crop Foto
                            </button>
                            <button type="button" id="btnCropExisting" onclick="cropExistingPhoto()" style="background: #ffffff; color: #001844; border: 1.5px solid #cbd5e1; padding: 7px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                ✂️ Sesuaikan Crop
                            </button>
                            <button type="button" id="btnRemovePhoto" onclick="removeDpdPhoto()" style="background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1.5px solid rgba(239, 68, 68, 0.3); padding: 7px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; transition: all 0.15s ease;" onmouseover="this.style.background='#dc2626'; this.style.color='#ffffff';" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#dc2626';">
                                🗑️ Hapus Foto
                            </button>
                        </div>
                        
                        <div style="font-size: 11px; color: #64748b; line-height: 1.4;">
                            Mendukung format JPG, PNG, WEBP. Anda bisa memotong/crop foto secara bebas sesuai keinginan.
                        </div>
                    </div>
                </div>

                <!-- Input Path Foto Tersembunyi (Disimpan ke DB) -->
                <input type="hidden" id="editDpdPhoto">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 14px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                <button type="button" onclick="closeEditDpdModal()" class="admin-btn admin-btn-light">Batal</button>
                <button type="submit" id="btnSaveDpd" class="admin-btn admin-btn-save">Simpan Pengurus DPD</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     MODAL CROP FOTO PENGURUS (INTERAKTIF & SESUAI KEINGINAN SENDIRI)
     ======================================================== -->
<div id="dpdCropModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 100000; align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
    <div onclick="closeDpdCropModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 15, 45, 0.88); backdrop-filter: blur(5px);"></div>
    
    <div style="position: relative; background: #ffffff; border-radius: 14px; max-width: 680px; width: 100%; overflow: hidden; z-index: 3; box-shadow: 0 25px 60px rgba(0,0,0,0.6); display: flex; flex-direction: column; max-height: 94vh;">
        <!-- Header Crop Modal -->
        <div style="background: #001844; color: #ffffff; padding: 14px 20px; border-bottom: 2px solid #ffb700; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 18px;">✂️</span>
                <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;">Potong &amp; Atur Foto Pengurus</h3>
            </div>
            <button type="button" onclick="closeDpdCropModal()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <!-- Body dengan Canvas Cropper -->
        <div style="padding: 16px; overflow-y: auto; background: #f8fafc; flex: 1;">
            <!-- Box Image Cropper -->
            <div id="dpdCropperContainer" style="width: 100%; height: 380px; background: #0f172a; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                <img id="dpdCropperImage" src="" alt="Crop Preview" style="max-width: 100%; display: block;">
            </div>

            <!-- Toolbar Rasio & Zoom/Rotate -->
            <div style="margin-top: 14px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 10px; background: #ffffff; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <!-- Tombol Pilihan Rasio Crop -->
                <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                    <span style="font-size: 11.5px; font-weight: 800; color: #334155; margin-right: 4px;">Bentuk Crop:</span>
                    <button type="button" onclick="setDpdCropRatio(NaN, this)" class="crop-ratio-btn" title="Bebas atur ukuran crop">Bebas</button>
                    <button type="button" onclick="setDpdCropRatio(3/4, this)" class="crop-ratio-btn active" title="Rasio 3:4 Standar Foto DPD">3:4 (Potret)</button>
                    <button type="button" onclick="setDpdCropRatio(1, this)" class="crop-ratio-btn" title="Rasio 1:1 Persegi">1:1 (Kotak)</button>
                    <button type="button" onclick="setDpdCropRatio(4/5, this)" class="crop-ratio-btn" title="Rasio 4:5">4:5</button>
                </div>

                <!-- Tombol Zoom & Putar -->
                <div style="display: flex; align-items: center; gap: 6px;">
                    <button type="button" onclick="dpdCropperZoom(0.1)" title="Perbesar (Zoom In)" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">🔍 +</button>
                    <button type="button" onclick="dpdCropperZoom(-0.1)" title="Perkecil (Zoom Out)" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">🔍 -</button>
                    <button type="button" onclick="dpdCropperRotate(-90)" title="Putar Kiri 90°" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">↺ -90°</button>
                    <button type="button" onclick="dpdCropperRotate(90)" title="Putar Kanan 90°" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">↻ +90°</button>
                    <button type="button" onclick="dpdCropperReset()" title="Reset Posisi" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">⟲ Reset</button>
                </div>
            </div>
            <p style="font-size: 11.5px; color: #64748b; margin: 8px 0 0 2px;">
                💡 <em>Tarik sudut kotak crop untuk mengubah ukuran area potong sesuai keinginan Anda, atau geser foto dengan mouse/touch.</em>
            </p>
        </div>

        <!-- Footer Crop Modal -->
        <div style="padding: 14px 20px; background: #ffffff; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="closeDpdCropModal()" class="admin-btn admin-btn-light" style="padding: 8px 16px;">Batal</button>
            <button type="button" id="btnApplyCrop" onclick="applyAndUploadCrop()" class="admin-btn" style="background: #10b981; color: #ffffff; font-weight: 800; padding: 8px 20px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px;">
                ✓ Potong &amp; Gunakan Foto
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/cropper.min.js') }}"></script>

<script>
    const csrfTokenDpd = '{{ csrf_token() }}';
    let dpdCropperInstance = null;

    function filterDpdCategory(category) {
        const tabs = {
            'all': document.getElementById('tabDpdAll'),
            'inti': document.getElementById('tabDpdInti'),
            'bidang': document.getElementById('tabDpdBidang')
        };

        Object.keys(tabs).forEach(k => {
            if (tabs[k]) {
                if (k === category) {
                    tabs[k].style.background = '#001844';
                    tabs[k].style.color = '#ffb700';
                    tabs[k].style.border = 'none';
                } else {
                    tabs[k].style.background = 'rgba(0, 24, 68, 0.12)';
                    tabs[k].style.color = '#001844';
                    tabs[k].style.border = '1.5px solid #001844';
                }
            }
        });

        const cards = document.querySelectorAll('.dpd-card-item');
        cards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function openEditDpdModal(id, name, title, category, phone, sk, photo, status) {
        document.getElementById('editDpdId').value = id;
        document.getElementById('editDpdModalTitle').textContent = '✏️ Edit: ' + (name || title);
        document.getElementById('editDpdName').value = name || '';
        document.getElementById('editDpdTitle').value = title;
        document.getElementById('editDpdCategory').value = category;
        document.getElementById('editDpdPhone').value = phone || '';
        document.getElementById('editDpdSk').value = sk || '';
        document.getElementById('editDpdPhoto').value = photo || '';
        
        // Atur preview foto & visibilitas tombol Sesuaikan Crop & Hapus Foto
        const previewImg = document.getElementById('editDpdPhotoPreview');
        const btnCrop = document.getElementById('btnCropExisting');
        const btnRemove = document.getElementById('btnRemovePhoto');

        if (photo && photo.trim() !== '') {
            previewImg.src = photo.startsWith('http') || photo.startsWith('/') ? photo : '/' + photo;
            if (btnCrop) btnCrop.style.display = 'inline-flex';
            if (btnRemove) btnRemove.style.display = 'inline-flex';
        } else {
            previewImg.src = '/images/default_avatar.svg';
            if (btnCrop) btnCrop.style.display = 'none';
            if (btnRemove) btnRemove.style.display = 'none';
        }

        document.getElementById('editDpdStatus').value = status;
        document.getElementById('editDpdModal').style.display = 'flex';
    }

    function closeEditDpdModal() {
        document.getElementById('editDpdModal').style.display = 'none';
    }

    /* Hapus Foto Profil Pengurus (Kembali ke Foto Default Avatar) */
    function removeDpdPhoto() {
        if (!confirm('Apakah Anda yakin ingin menghapus foto profil ini? Foto akan kembali ke tampilan default.')) {
            return;
        }

        document.getElementById('editDpdPhoto').value = '';
        document.getElementById('editDpdPhotoPreview').src = '/images/default_avatar.svg';

        const btnCrop = document.getElementById('btnCropExisting');
        const btnRemove = document.getElementById('btnRemovePhoto');
        if (btnCrop) btnCrop.style.display = 'none';
        if (btnRemove) btnRemove.style.display = 'none';

        const fileInput = document.getElementById('dpdPhotoFileInput');
        if (fileInput) fileInput.value = '';
    }

    /* Handler saat berkas foto baru dipilih */
    function handleDpdPhotoSelected(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Silakan pilih berkas gambar yang valid (JPG, PNG, atau WEBP).');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(evt) {
            openCropModalWithSource(evt.target.result);
        };
        reader.readAsDataURL(file);
        e.target.value = '';
    }

    /* Buka modal crop untuk foto yang sudah terpasang */
    function cropExistingPhoto() {
        const currentPhoto = document.getElementById('editDpdPhoto').value || document.getElementById('editDpdPhotoPreview').src;
        if (!currentPhoto || currentPhoto.includes('default_avatar.svg')) {
            alert('Belum ada foto profil kustom yang dipilih.');
            return;
        }
        openCropModalWithSource(currentPhoto);
    }

    /* Buka Modal Cropper */
    function openCropModalWithSource(src) {
        const modal = document.getElementById('dpdCropModal');
        modal.style.display = 'flex';

        if (dpdCropperInstance) {
            try {
                dpdCropperInstance.destroy();
            } catch(e) {}
            dpdCropperInstance = null;
        }

        const container = document.getElementById('dpdCropperContainer');
        container.innerHTML = '';

        const img = document.createElement('img');
        img.id = 'dpdCropperImage';
        img.style.maxWidth = '100%';
        img.style.maxHeight = '380px';
        img.style.display = 'block';
        container.appendChild(img);

        let isInitialized = false;
        function initCropper() {
            if (isInitialized) return;
            isInitialized = true;

            try {
                dpdCropperInstance = new Cropper(img, {
                    aspectRatio: 3 / 4, // Default potret pengurus
                    viewMode: 1,
                    autoCropArea: 0.9,
                    responsive: true,
                    restore: true,
                    checkCrossOrigin: false,
                    guides: true,
                    center: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: true,
                });
            } catch(err) {
                console.error('Cropper init error:', err);
            }
        }

        img.onload = initCropper;
        img.src = src;

        if (img.complete && img.naturalWidth > 0) {
            initCropper();
        }
    }

    function closeDpdCropModal() {
        document.getElementById('dpdCropModal').style.display = 'none';
        if (dpdCropperInstance) {
            try {
                dpdCropperInstance.destroy();
            } catch(e) {}
            dpdCropperInstance = null;
        }
    }

    function setDpdCropRatio(ratio, btn) {
        if (dpdCropperInstance) {
            dpdCropperInstance.setAspectRatio(ratio);
        }
        document.querySelectorAll('.crop-ratio-btn').forEach(b => {
            b.classList.remove('active');
            b.style.background = '#ffffff';
            b.style.color = '#001844';
            b.style.borderColor = '#cbd5e1';
        });
        if (btn) {
            btn.classList.add('active');
            btn.style.background = '#001844';
            btn.style.color = '#ffb700';
            btn.style.borderColor = '#001844';
        }
    }

    function dpdCropperZoom(val) {
        if (dpdCropperInstance) dpdCropperInstance.zoom(val);
    }

    function dpdCropperRotate(deg) {
        if (dpdCropperInstance) dpdCropperInstance.rotate(deg);
    }

    function dpdCropperReset() {
        if (dpdCropperInstance) dpdCropperInstance.reset();
    }

    /* Proses Crop & Unggah ke Server */
    function applyAndUploadCrop() {
        if (!dpdCropperInstance) {
            alert('Pemotong gambar belum siap. Silakan pilih kembali foto.');
            return;
        }

        const btn = document.getElementById('btnApplyCrop');
        btn.disabled = true;
        btn.textContent = 'Memproses Foto...';

        let canvas = null;
        try {
            canvas = dpdCropperInstance.getCroppedCanvas({
                maxWidth: 1200,
                maxHeight: 1600,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
        } catch(e) {
            console.warn('getCroppedCanvas with options failed, trying default:', e);
        }

        if (!canvas) {
            try {
                canvas = dpdCropperInstance.getCroppedCanvas();
            } catch(e) {
                console.error('Fallback getCroppedCanvas failed:', e);
            }
        }

        if (!canvas) {
            alert('Gagal memproses gambar crop. Silakan coba sesuaikan kotak crop lalu klik tombol kembali.');
            btn.disabled = false;
            btn.textContent = '✓ Potong & Gunakan Foto';
            return;
        }

        btn.textContent = 'Mengunggah Foto...';

        function sendUploadPayload(bodyData, isJson) {
            const headers = {
                'X-CSRF-TOKEN': csrfTokenDpd,
                'Accept': 'application/json'
            };
            if (isJson) {
                headers['Content-Type'] = 'application/json';
            }

            fetch('/admin/upload-image', {
                method: 'POST',
                headers: headers,
                body: bodyData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.textContent = '✓ Potong & Gunakan Foto';

                if (data.success && (data.relative_url || data.url)) {
                    const finalPath = data.relative_url || data.url;
                    document.getElementById('editDpdPhoto').value = finalPath;
                    document.getElementById('editDpdPhotoPreview').src = finalPath;

                    const btnCrop = document.getElementById('btnCropExisting');
                    const btnRemove = document.getElementById('btnRemovePhoto');
                    if (btnCrop) btnCrop.style.display = 'inline-flex';
                    if (btnRemove) btnRemove.style.display = 'inline-flex';

                    closeDpdCropModal();
                } else {
                    alert(data.message || 'Gagal mengunggah foto hasil crop.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.textContent = '✓ Potong & Gunakan Foto';
                alert('Terjadi kesalahan saat mengunggah foto ke server.');
                console.error(err);
            });
        }

        // Gunakan Blob jika didukung, atau fallback ke Base64 Data URL
        try {
            canvas.toBlob(function(blob) {
                if (blob) {
                    const formData = new FormData();
                    formData.append('image', blob, 'officer_' + Date.now() + '.jpg');
                    sendUploadPayload(formData, false);
                } else {
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
                    sendUploadPayload(JSON.stringify({ image_base64: dataUrl }), true);
                }
            }, 'image/jpeg', 0.92);
        } catch(e) {
            try {
                const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
                sendUploadPayload(JSON.stringify({ image_base64: dataUrl }), true);
            } catch(err2) {
                alert('Gagal memproses kanvas gambar: ' + (err2.message || err2));
                btn.disabled = false;
                btn.textContent = '✓ Potong & Gunakan Foto';
            }
        }
    }

    function submitDpdEdit(e) {
        e.preventDefault();
        const id = document.getElementById('editDpdId').value;
        const btn = document.getElementById('btnSaveDpd');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        const payload = {
            name: document.getElementById('editDpdName').value,
            title: document.getElementById('editDpdTitle').value,
            category: document.getElementById('editDpdCategory').value,
            phone: document.getElementById('editDpdPhone').value,
            sk_number: document.getElementById('editDpdSk').value,
            photo: document.getElementById('editDpdPhoto').value,
            status: document.getElementById('editDpdStatus').value,
        };

        fetch(`/admin/dpd/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfTokenDpd,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.textContent = 'Simpan Pengurus DPD';
            if (data.success) {
                alert(data.message || 'Data Pengurus DPD berhasil diperbarui!');
                window.location.reload();
            } else {
                alert(data.message || 'Gagal memperbarui data.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = 'Simpan Pengurus DPD';
            alert('Terjadi kesalahan jaringan.');
            console.error(err);
        });
    }
</script>

@endsection
