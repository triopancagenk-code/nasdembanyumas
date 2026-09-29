@extends('layouts.app')

@section('title', 'Pengurus DPRt – Tingkat Desa & Kelurahan (Partai NasDem)')

@section('top_bar')
<div style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 7px 32px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; font-weight: 700; position: relative; z-index: 1000; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <a href="{{ route('admin.dprt') }}" style="color: #001844; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.color='#f8bd00'" onmouseout="this.style.color='#001844'">
            ← Kembali ke Tabel 320 DPRt (Desa)
        </a>
        <span style="color: #cbd5e1;">|</span>
        <a href="{{ route('admin.dpc') }}" style="color: #64748b; font-weight: 700; text-decoration: none;" onmouseover="this.style.color='#001844'" onmouseout="this.style.color='#64748b'">
            Menu DPC (Kecamatan)
        </a>
    </div>

    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="background: #001844; color: #ffb700; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 900; letter-spacing: 0.5px;">
            POV ADMIN • 9 PENGURUS DPRT (DESA)
        </span>
    </div>
</div>
@endsection

@section('content')

{{-- ========================================================
     HERO BANNER PENGURUS DPRT DESA (LATAR BIRU TUA MEWAH)
     ======================================================== --}}
<section style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 60px 24px 45px; border-bottom: 3px solid #ffb700; color: #ffffff;">
    <div style="max-width: 1300px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 3px 9px; border-radius: 4px; text-transform: uppercase;">
                        STRUKTUR KEPENGURUSAN RANTING (DPRT)
                    </span>
                    <span style="color: #94a3b8; font-size: 13px;">9 Kolom Pengurus Desa / Kelurahan</span>
                </div>
                <h1 style="font-size: clamp(24px, 3.2vw, 36px); font-weight: 900; color: #ffffff; margin: 0 0 8px 0; letter-spacing: 0.5px;">
                    Pengurus DPRt <span style="color: #ffb700;">{{ $selectedDprt ? $selectedDprt->type . ' ' . $selectedDprt->desa_name : 'Desa' }}</span>
                </h1>
                <p style="font-size: 14px; color: #cbd5e1; margin: 0; max-width: 750px; line-height: 1.6;">
                    Susunan lengkap 9 personil kepengurusan Dewan Pimpinan Ranting (DPRt) Partai NasDem untuk 
                    <strong>{{ $selectedDprt ? $selectedDprt->type . ' ' . $selectedDprt->desa_name : '' }}</strong>, 
                    Kecamatan <strong>{{ $selectedKecamatan }}</strong>, {{ $parentDpc ? $parentDpc->dapil : 'Kabupaten Banyumas' }}.
                </p>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.dprt', ['kecamatan' => $selectedKecamatan]) }}" class="admin-btn admin-btn-light" style="text-decoration: none; font-size: 12px; padding: 8px 16px; border-radius: 6px; font-weight: 800; background: #ffffff; color: #001844;">
                    📋 Tabel DPRt Kec. {{ $selectedKecamatan }}
                </a>
                <a href="{{ route('admin.dpc.pengurus', ['kecamatan' => $selectedKecamatan]) }}" class="btn-yellow" style="text-decoration: none; font-size: 12px; padding: 8px 16px; border-radius: 6px; font-weight: 800;">
                    Ke Pengurus DPC {{ $selectedKecamatan }} →
                </a>
            </div>
        </div>

        {{-- METRIK DESA TERPILIH --}}
        @if($selectedDprt)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 12px; padding: 16px 20px;">
            <div>
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">KECAMATAN &amp; DAPIL</span>
                <div style="font-size: 17px; font-weight: 900; color: #ffb700; margin-top: 2px;">
                    Kec. {{ $selectedKecamatan }} ({{ $parentDpc ? $parentDpc->dapil : 'Banyumas' }})
                </div>
            </div>
            <div>
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">STATUS KEPENGURUSAN</span>
                <div style="font-size: 15px; font-weight: 800; color: #10b981; margin-top: 4px;">
                    ● {{ $selectedDprt->status }}
                </div>
            </div>
            <div>
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">JUMLAH KADER DESA</span>
                <div style="font-size: 18px; font-weight: 900; color: #ffffff; margin-top: 2px;">
                    {{ number_format($selectedDprt->total_kader, 0, ',', '.') }} Orang
                </div>
            </div>
            <div>
                <span style="font-size: 11px; color: #94a3b8; font-weight: 700; text-transform: uppercase;">TOTAL DESA DI KECAMATAN INI</span>
                <div style="font-size: 18px; font-weight: 900; color: #cbd5e1; margin-top: 2px;">
                    {{ $desasInKecamatan->count() }} Desa / Kelurahan
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ========================================================
     NAVIGASI TABS: PILIH KECAMATAN & PILIH DESA
     ======================================================== --}}
<section style="background: #ffffff; border-bottom: 2px solid #e2e8f0; padding: 18px 24px; position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
    <div style="max-width: 1300px; margin: 0 auto;">
        
        <!-- Baris 1: Filter Dropdown / Pemilihan Kecamatan -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <span style="font-size: 12px; font-weight: 900; color: #001844; text-transform: uppercase;">
                    Pilih Kecamatan:
                </span>
                <select onchange="window.location.href=this.value" style="padding: 7px 14px; border: 1.5px solid #001844; border-radius: 8px; font-size: 13px; font-weight: 800; color: #001844; background: #fff8e6; cursor: pointer;">
                    @foreach($allKecamatans as $kec)
                        <option value="{{ route('admin.dprt.pengurus', ['kecamatan' => $kec->kecamatan_name]) }}" {{ $selectedKecamatan === $kec->kecamatan_name ? 'selected' : '' }}>
                            Kecamatan {{ $kec->kecamatan_name }} ({{ $kec->dapil }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="font-size: 12px; font-weight: 700; color: #64748b;">
                Menampilkan: <strong style="color: #001844;">{{ $desasInKecamatan->count() }} Desa/Kelurahan</strong> di Kec. {{ $selectedKecamatan }}
            </div>
        </div>

        <!-- Baris 2: Pilihan Desa di dalam Kecamatan Ini -->
        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; padding-top: 10px; border-top: 1px dashed #e2e8f0; max-height: 120px; overflow-y: auto;">
            <span style="font-size: 12px; font-weight: 900; color: #e11d48; text-transform: uppercase; margin-right: 4px; white-space: nowrap;">
                Pilih Desa:
            </span>
            @foreach($desasInKecamatan as $desaOption)
                @php
                    $isSelectedDesa = $selectedDprt && $selectedDprt->id === $desaOption->id;
                @endphp
                <a href="{{ route('admin.dprt.pengurus', ['id' => $desaOption->id]) }}" style="text-decoration: none; padding: 5px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 800; transition: all 0.15s ease; white-space: nowrap; {{ $isSelectedDesa ? 'background: #ffb700; color: #001844; border: 1.5px solid #001844; box-shadow: 0 2px 6px rgba(0,0,0,0.1);' : 'background: #f8fafc; color: #001844; border: 1.5px solid #cbd5e1;' }}">
                    🏡 {{ $desaOption->desa_name }}
                </a>
            @endforeach
        </div>

    </div>
</section>

{{-- ========================================================
     SECTION 9 KOLOM PENGURUS DPRT DESA (LATAR KUNING EMAS SEPERTI PADA DPC & DPD)
     ======================================================== --}}
<section style="background: #ffb700; padding: 60px 24px 80px; min-height: 70vh;">
    <div style="max-width: 1300px; margin: 0 auto;">

        <!-- Section Title Header (SAMA DENGAN DPC & DPD) -->
        <div style="text-align: center; margin-bottom: 40px;">
            <p style="font-size: 14px; font-weight: 800; letter-spacing: 2.5px; color: #001844; margin: 0 0 6px 0; text-transform: uppercase;">
                MENGENAL LEBIH DEKAT
            </p>
            <h2 style="font-size: 30px; font-weight: 900; color: #001844; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 0.5px;">
                PENGURUS DPRT {{ $selectedDprt ? strtoupper($selectedDprt->type . ' ' . $selectedDprt->desa_name) : 'DESA' }}
            </h2>
            <p style="font-size: 13px; font-weight: 800; color: #001844; margin: 0 0 16px 0;">
                KECAMATAN {{ strtoupper($selectedKecamatan) }} • {{ $parentDpc ? strtoupper($parentDpc->dapil) : '' }} BANYUMAS • 9 SUSUNAN PENGURUS LENGKAP
            </p>
            <div style="width: 60px; height: 3.5px; background: #001844; margin: 0 auto 26px;"></div>

            <!-- Filter Category Tabs (Persis DPC & DPD) -->
            <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 25px;">
                <button type="button" onclick="filterDprtCategory('all')" id="tabDprtAll" class="dprt-filter-btn active" style="background: #001844; color: #ffb700; border: none; padding: 8px 18px; border-radius: 20px; font-size: 12.5px; font-weight: 800; cursor: pointer; transition: all 0.15s ease;">
                    Semua 9 Pengurus ({{ $officers->count() }})
                </button>
                <button type="button" onclick="filterDprtCategory('inti')" id="tabDprtInti" class="dprt-filter-btn" style="background: rgba(0, 24, 68, 0.12); color: #001844; border: 1.5px solid #001844; padding: 8px 18px; border-radius: 20px; font-size: 12.5px; font-weight: 800; cursor: pointer; transition: all 0.15s ease;">
                    Pengurus Inti &amp; KSB ({{ $intiOfficers->count() }})
                </button>
                <button type="button" onclick="filterDprtCategory('bidang')" id="tabDprtBidang" class="dprt-filter-btn" style="background: rgba(0, 24, 68, 0.12); color: #001844; border: 1.5px solid #001844; padding: 8px 18px; border-radius: 20px; font-size: 12.5px; font-weight: 800; cursor: pointer; transition: all 0.15s ease;">
                    Koordinator Bidang ({{ $bidangOfficers->count() }})
                </button>
            </div>
        </div>

        {{-- GRID 9 KARTU PENGURUS DPRT --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px;" id="dprtOfficersGrid">
            @forelse($officers as $officer)
            <div class="dprt-card-item" data-category="{{ $officer->category }}" style="background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 24px rgba(0, 24, 68, 0.12); text-align: center; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s ease;" onmouseover="this.style.transform='translateY(-6px)'" onmouseout="this.style.transform='none'">
                
                <!-- Foto Pengurus & Badge Kategori -->
                <div style="background: #001844; height: 260px; overflow: hidden; position: relative;">
                    <img src="{{ asset(ltrim($officer->photo ?: 'images/default_avatar.svg', '/')) }}" alt="{{ $officer->name ?: $officer->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <span style="position: absolute; top: 10px; right: 10px; background: {{ $officer->category === 'inti' ? '#e11d48' : '#0284c7' }}; color: #ffffff; font-size: 10px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ $officer->category === 'inti' ? 'Pengurus Inti' : 'Koordinator Bidang' }}
                    </span>
                    <span style="position: absolute; bottom: 8px; left: 10px; background: rgba(0,0,0,0.6); color: #ffb700; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 4px;">
                        Kolom #{{ $officer->sort_order }}
                    </span>
                </div>

                <!-- Informasi Pengurus: Nama, Jabatan, SK, Telepon, Instagram -->
                <div style="padding: 18px 14px 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3 style="font-size: 15.5px; font-weight: 900; color: #001844; margin: 0 0 6px 0; line-height: 1.3; min-height: 22px;">
                            {{ $officer->name ?: 'Belum Diisi' }}
                        </h3>
                        <p style="font-size: 12px; font-weight: 800; color: #e11d48; margin: 0 0 8px 0; text-transform: uppercase;">
                            {{ $officer->title }}
                        </p>
                        <p style="font-size: 11.5px; color: #64748b; margin: 0 0 12px 0; line-height: 1.5;">
                            SK: {{ $officer->sk_number ?: '-' }}<br>
                            @if($officer->phone)
                                📞 {{ $officer->phone }}
                            @endif
                        </p>
                    </div>

                    <!-- Tombol Edit Pengurus -->
                    <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 6px; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                        @auth
                            @if(auth()->user()->isAdmin())
                            <button type="button" onclick="openEditDprtOfficerModal({{ $officer->id }}, '{{ addslashes($officer->name ?? '') }}', '{{ addslashes($officer->title) }}', '{{ addslashes($officer->category) }}', '{{ addslashes($officer->phone ?? '') }}', '{{ addslashes($officer->sk_number ?? '') }}', '{{ addslashes($officer->instagram ?? '') }}', '{{ addslashes($officer->photo ?? '') }}', '{{ addslashes($officer->status) }}', '{{ addslashes($selectedDprt->desa_name ?? '') }}', '{{ addslashes($selectedKecamatan ?? '') }}')" style="background: #ffb700; color: #001844; border: none; padding: 7px 18px; border-radius: 6px; font-size: 12px; font-weight: 900; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                ✏️ Edit
                            </button>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px 20px; background: #ffffff; border-radius: 14px;">
                <p style="color: #64748b; font-weight: 700; font-size: 16px; margin: 0 0 10px;">Data 9 pengurus DPRt belum tersedia.</p>
                <span style="font-size: 13px; color: #94a3b8;">Silakan hubungi administrator atau pilih desa/kelurahan lain.</span>
            </div>
            @endforelse
        </div>

    </div>
</section>

<link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">

<style>
    /* Form input text color override */
    #editDprtOfficerModal input,
    #editDprtOfficerModal select,
    #editDprtOfficerModal textarea,
    #editDprtOfficerModal .admin-form-control {
        color: #000000 !important;
        background-color: #ffffff !important;
        -webkit-text-fill-color: #000000 !important;
        font-weight: 600 !important;
    }

    #editDprtOfficerModal label {
        color: #1e293b !important;
        font-weight: 800 !important;
    }

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
     MODAL EDIT 9 PENGURUS DPRT (PERSIS DENGAN DPC & DPD)
     ======================================================== -->
<div id="editDprtOfficerModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeEditDprtOfficerModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 24, 68, 0.85); backdrop-filter: blur(4px);"></div>
    <div style="position: relative; background: #ffffff; border-radius: 14px; max-width: 560px; width: 100%; overflow: hidden; z-index: 2; box-shadow: 0 20px 40px rgba(0,0,0,0.5); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; max-height: 94vh; display: flex; flex-direction: column;">
        <div style="background: #001844; color: #ffffff; padding: 16px 20px; border-bottom: 2px solid #ffb700; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16.5px; font-weight: 800; color: #ffffff;" id="editDprtOfficerModalTitle">✏️ Edit Pengurus DPRt</h3>
            <button type="button" onclick="closeEditDprtOfficerModal()" style="background: none; border: none; color: #cbd5e1; font-size: 22px; cursor: pointer;">&times;</button>
        </div>
        <form id="editDprtOfficerForm" onsubmit="submitDprtOfficerEdit(event)" style="padding: 22px; overflow-y: auto;">
            <input type="hidden" id="editDprtOfficerId">

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Nama Lengkap &amp; Gelar</label>
                <input type="text" id="editDprtOfficerName" class="admin-form-control" placeholder="Contoh: Budi Santoso, S.Pd.">
            </div>

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Jabatan / Struktur *</label>
                <input type="text" id="editDprtOfficerTitle" class="admin-form-control" required placeholder="Contoh: Ketua DPRt / Sekretaris / Bendahara">
            </div>

            <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Kategori Pengurus</label>
                    <select id="editDprtOfficerCategory" class="admin-form-control">
                        <option value="inti">Pengurus Inti &amp; KSB</option>
                        <option value="bidang">Koordinator Bidang</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Status</label>
                    <select id="editDprtOfficerStatus" class="admin-form-control">
                        <option value="Aktif">Aktif</option>
                        <option value="Cuti">Cuti</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Nomor SK Kepengurusan</label>
                    <input type="text" id="editDprtOfficerSk" class="admin-form-control" placeholder="Contoh: SK-DPRT/ND/AJB/01">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Nomor Telepon / WA</label>
                    <input type="text" id="editDprtOfficerPhone" class="admin-form-control" placeholder="0858-xxxx-xxxx">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Akun / Tautan Instagram</label>
                <input type="text" id="editDprtOfficerInstagram" class="admin-form-control" placeholder="Contoh: @nasdembanyumas atau https://instagram.com/username">
                <span style="font-size: 11px; color: #64748b;">Bisa diisi username (e.g. @nama) atau URL lengkap profil Instagram.</span>
            </div>

            <!-- Bagian Unggah & Crop Foto Profil -->
            <div style="margin-bottom: 16px; background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 10px; padding: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 800; color: #001844; margin-bottom: 8px;">
                    Foto Profil Pengurus
                </label>
                
                <div style="display: flex; align-items: center; gap: 16px;">
                    <!-- Preview Foto -->
                    <div style="width: 74px; height: 92px; border-radius: 8px; overflow: hidden; background: #001844; border: 2px solid #ffb700; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.12);">
                        <img id="editDprtOfficerPhotoPreview" src="{{ asset('images/default_avatar.svg') }}" alt="Preview Foto" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <!-- Tombol Unggah & Crop -->
                    <div style="flex: 1;">
                        <input type="file" id="dprtOfficerPhotoFileInput" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="handleDprtOfficerPhotoSelected(event)">
                        
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 6px;">
                            <button type="button" onclick="document.getElementById('dprtOfficerPhotoFileInput').click()" style="background: #001844; color: #ffb700; border: 1.5px solid #ffb700; padding: 7px 14px; border-radius: 6px; font-size: 12px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                Unggah &amp; Crop Foto
                            </button>
                            <button type="button" id="btnCropDprtOfficerExisting" onclick="cropExistingDprtOfficerPhoto()" style="background: #ffffff; color: #001844; border: 1.5px solid #cbd5e1; padding: 7px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                ✂️ Sesuaikan Crop
                            </button>
                            <button type="button" id="btnRemoveDprtOfficerPhoto" onclick="removeDprtOfficerPhoto()" style="background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1.5px solid rgba(239, 68, 68, 0.3); padding: 7px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                🗑️ Hapus Foto
                            </button>
                        </div>
                        
                        <div style="font-size: 11px; color: #64748b; line-height: 1.4;">
                            Mendukung format JPG, PNG, WEBP. Anda bisa mengatur rasio crop potret 3:4 atau bebas.
                        </div>
                    </div>
                </div>

                <!-- Input Path Foto Tersembunyi (Disimpan ke DB) -->
                <input type="hidden" id="editDprtOfficerPhoto">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 14px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                <button type="button" onclick="closeEditDprtOfficerModal()" class="admin-btn admin-btn-light">Batal</button>
                <button type="submit" id="btnSaveDprtOfficer" class="admin-btn admin-btn-save">Simpan Pengurus DPRt</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     MODAL CROP FOTO PENGURUS DPRT
     ======================================================== -->
<div id="dprtOfficerCropModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 100000; align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">
    <div onclick="closeDprtOfficerCropModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 15, 45, 0.88); backdrop-filter: blur(5px);"></div>
    
    <div style="position: relative; background: #ffffff; border-radius: 14px; max-width: 680px; width: 100%; overflow: hidden; z-index: 3; box-shadow: 0 25px 60px rgba(0,0,0,0.6); display: flex; flex-direction: column; max-height: 94vh;">
        <div style="background: #001844; color: #ffffff; padding: 14px 20px; border-bottom: 2px solid #ffb700; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 18px;">✂️</span>
                <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #ffffff;">Potong &amp; Atur Foto Pengurus DPRt</h3>
            </div>
            <button type="button" onclick="closeDprtOfficerCropModal()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer;">&times;</button>
        </div>

        <div style="padding: 16px; overflow-y: auto; background: #f8fafc; flex: 1;">
            <div id="dprtOfficerCropperContainer" style="width: 100%; height: 380px; background: #0f172a; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                <img id="dprtOfficerCropperImage" src="" alt="Crop Preview" style="max-width: 100%; display: block;">
            </div>

            <!-- Toolbar Rasio & Zoom/Rotate -->
            <div style="margin-top: 14px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 10px; background: #ffffff; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                    <span style="font-size: 11.5px; font-weight: 800; color: #334155; margin-right: 4px;">Bentuk Crop:</span>
                    <button type="button" onclick="setDprtOfficerCropRatio(NaN, this)" class="crop-ratio-btn">Bebas</button>
                    <button type="button" onclick="setDprtOfficerCropRatio(3/4, this)" class="crop-ratio-btn active">3:4 (Potret)</button>
                    <button type="button" onclick="setDprtOfficerCropRatio(1, this)" class="crop-ratio-btn">1:1 (Kotak)</button>
                    <button type="button" onclick="setDprtOfficerCropRatio(4/5, this)" class="crop-ratio-btn">4:5</button>
                </div>

                <div style="display: flex; align-items: center; gap: 6px;">
                    <button type="button" onclick="dprtOfficerCropperZoom(0.1)" title="Perbesar" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">🔍 +</button>
                    <button type="button" onclick="dprtOfficerCropperZoom(-0.1)" title="Perkecil" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">🔍 -</button>
                    <button type="button" onclick="dprtOfficerCropperRotate(-90)" title="Putar Kiri" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">↺ -90°</button>
                    <button type="button" onclick="dprtOfficerCropperRotate(90)" title="Putar Kanan" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">↻ +90°</button>
                    <button type="button" onclick="dprtOfficerCropperReset()" title="Reset" style="background: #f1f5f9; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 800; cursor: pointer; color: #0f172a;">⟲ Reset</button>
                </div>
            </div>
        </div>

        <div style="padding: 14px 20px; background: #ffffff; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" onclick="closeDprtOfficerCropModal()" class="admin-btn admin-btn-light" style="padding: 8px 16px;">Batal</button>
            <button type="button" id="btnApplyDprtOfficerCrop" onclick="applyAndUploadDprtOfficerCrop()" class="admin-btn" style="background: #10b981; color: #ffffff; font-weight: 800; padding: 8px 20px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px;">
                ✓ Potong &amp; Gunakan Foto
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/cropper.min.js') }}"></script>

<script>
    const csrfToken = '{{ csrf_token() }}';
    let dprtOfficerCropperInstance = null;

    function filterDprtCategory(category) {
        const tabs = {
            'all': document.getElementById('tabDprtAll'),
            'inti': document.getElementById('tabDprtInti'),
            'bidang': document.getElementById('tabDprtBidang')
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

        const cards = document.querySelectorAll('.dprt-card-item');
        cards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function openEditDprtOfficerModal(id, name, title, category, phone, sk, instagram, photo, status, desa, kecamatan) {
        document.getElementById('editDprtOfficerId').value = id;
        document.getElementById('editDprtOfficerModalTitle').textContent = '✏️ Edit: ' + (name || title) + (desa ? ' (' + desa + ', Kec. ' + kecamatan + ')' : '');
        document.getElementById('editDprtOfficerName').value = name || '';
        document.getElementById('editDprtOfficerTitle').value = title;
        document.getElementById('editDprtOfficerCategory').value = category || 'inti';
        document.getElementById('editDprtOfficerPhone').value = phone || '';
        document.getElementById('editDprtOfficerSk').value = sk || '';
        document.getElementById('editDprtOfficerInstagram').value = instagram || '';
        document.getElementById('editDprtOfficerPhoto').value = photo || '';
        document.getElementById('editDprtOfficerStatus').value = status || 'Aktif';

        const previewImg = document.getElementById('editDprtOfficerPhotoPreview');
        const btnCrop = document.getElementById('btnCropDprtOfficerExisting');
        const btnRemove = document.getElementById('btnRemoveDprtOfficerPhoto');

        if (photo && photo.trim() !== '') {
            previewImg.src = photo.startsWith('http') || photo.startsWith('/') ? photo : '/' + photo;
            if (btnCrop) btnCrop.style.display = 'inline-flex';
            if (btnRemove) btnRemove.style.display = 'inline-flex';
        } else {
            previewImg.src = '/images/default_avatar.svg';
            if (btnCrop) btnCrop.style.display = 'none';
            if (btnRemove) btnRemove.style.display = 'none';
        }

        document.getElementById('editDprtOfficerModal').style.display = 'flex';
    }

    function closeEditDprtOfficerModal() {
        document.getElementById('editDprtOfficerModal').style.display = 'none';
    }

    function removeDprtOfficerPhoto() {
        if (!confirm('Apakah Anda yakin ingin menghapus foto profil ini? Foto akan kembali ke tampilan default.')) {
            return;
        }

        document.getElementById('editDprtOfficerPhoto').value = '';
        document.getElementById('editDprtOfficerPhotoPreview').src = '/images/default_avatar.svg';

        const btnCrop = document.getElementById('btnCropDprtOfficerExisting');
        const btnRemove = document.getElementById('btnRemoveDprtOfficerPhoto');
        if (btnCrop) btnCrop.style.display = 'none';
        if (btnRemove) btnRemove.style.display = 'none';

        const fileInput = document.getElementById('dprtOfficerPhotoFileInput');
        if (fileInput) fileInput.value = '';
    }

    function handleDprtOfficerPhotoSelected(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Silakan pilih berkas gambar yang valid (JPG, PNG, atau WEBP).');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(evt) {
            openDprtOfficerCropModalWithSource(evt.target.result);
        };
        reader.readAsDataURL(file);
        e.target.value = '';
    }

    function cropExistingDprtOfficerPhoto() {
        const currentPhoto = document.getElementById('editDprtOfficerPhoto').value || document.getElementById('editDprtOfficerPhotoPreview').src;
        if (!currentPhoto || currentPhoto.includes('default_avatar.svg')) {
            alert('Belum ada foto profil kustom yang dipilih.');
            return;
        }
        openDprtOfficerCropModalWithSource(currentPhoto);
    }

    function openDprtOfficerCropModalWithSource(src) {
        const modal = document.getElementById('dprtOfficerCropModal');
        modal.style.display = 'flex';

        if (dprtOfficerCropperInstance) {
            try {
                dprtOfficerCropperInstance.destroy();
            } catch(e) {}
            dprtOfficerCropperInstance = null;
        }

        const container = document.getElementById('dprtOfficerCropperContainer');
        container.innerHTML = '';

        const img = document.createElement('img');
        img.id = 'dprtOfficerCropperImage';
        img.style.maxWidth = '100%';
        img.style.maxHeight = '380px';
        img.style.display = 'block';
        container.appendChild(img);

        let isInitialized = false;
        function initCropper() {
            if (isInitialized) return;
            isInitialized = true;

            try {
                dprtOfficerCropperInstance = new Cropper(img, {
                    aspectRatio: 3 / 4,
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

    function closeDprtOfficerCropModal() {
        document.getElementById('dprtOfficerCropModal').style.display = 'none';
        if (dprtOfficerCropperInstance) {
            try {
                dprtOfficerCropperInstance.destroy();
            } catch(e) {}
                dprtOfficerCropperInstance = null;
        }
    }

    function setDprtOfficerCropRatio(ratio, btn) {
        if (dprtOfficerCropperInstance) {
            dprtOfficerCropperInstance.setAspectRatio(ratio);
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

    function dprtOfficerCropperZoom(val) {
        if (dprtOfficerCropperInstance) dprtOfficerCropperInstance.zoom(val);
    }

    function dprtOfficerCropperRotate(deg) {
        if (dprtOfficerCropperInstance) dprtOfficerCropperInstance.rotate(deg);
    }

    function dprtOfficerCropperReset() {
        if (dprtOfficerCropperInstance) dprtOfficerCropperInstance.reset();
    }

    function applyAndUploadDprtOfficerCrop() {
        if (!dprtOfficerCropperInstance) {
            alert('Pemotong gambar belum siap.');
            return;
        }

        const btn = document.getElementById('btnApplyDprtOfficerCrop');
        btn.disabled = true;
        btn.textContent = 'Memproses Foto...';

        let canvas = null;
        try {
            canvas = dprtOfficerCropperInstance.getCroppedCanvas({
                maxWidth: 1200,
                maxHeight: 1600,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
        } catch(e) {
            console.warn(e);
        }

        if (!canvas) {
            try {
                canvas = dprtOfficerCropperInstance.getCroppedCanvas();
            } catch(e) {}
        }

        if (!canvas) {
            alert('Gagal memproses gambar crop.');
            btn.disabled = false;
            btn.textContent = '✓ Potong & Gunakan Foto';
            return;
        }

        btn.textContent = 'Mengunggah Foto...';

        function sendUploadPayload(bodyData, isJson) {
            const headers = {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            };
            if (isJson) headers['Content-Type'] = 'application/json';

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
                    document.getElementById('editDprtOfficerPhoto').value = finalPath;
                    document.getElementById('editDprtOfficerPhotoPreview').src = finalPath;

                    const btnCrop = document.getElementById('btnCropDprtOfficerExisting');
                    const btnRemove = document.getElementById('btnRemoveDprtOfficerPhoto');
                    if (btnCrop) btnCrop.style.display = 'inline-flex';
                    if (btnRemove) btnRemove.style.display = 'inline-flex';

                    closeDprtOfficerCropModal();
                } else {
                    alert(data.message || 'Gagal mengunggah foto.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.textContent = '✓ Potong & Gunakan Foto';
                alert('Terjadi kesalahan saat mengunggah foto.');
                console.error(err);
            });
        }

        try {
            canvas.toBlob(function(blob) {
                if (blob) {
                    const formData = new FormData();
                    formData.append('image', blob, 'dprt_officer_' + Date.now() + '.jpg');
                    sendUploadPayload(formData, false);
                } else {
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
                    sendUploadPayload(JSON.stringify({ image_base64: dataUrl }), true);
                }
            }, 'image/jpeg', 0.92);
        } catch(e) {
            const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
            sendUploadPayload(JSON.stringify({ image_base64: dataUrl }), true);
        }
    }

    function submitDprtOfficerEdit(e) {
        e.preventDefault();
        const id = document.getElementById('editDprtOfficerId').value;
        const btn = document.getElementById('btnSaveDprtOfficer');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        const payload = {
            name: document.getElementById('editDprtOfficerName').value,
            title: document.getElementById('editDprtOfficerTitle').value,
            category: document.getElementById('editDprtOfficerCategory').value,
            phone: document.getElementById('editDprtOfficerPhone').value,
            sk_number: document.getElementById('editDprtOfficerSk').value,
            instagram: document.getElementById('editDprtOfficerInstagram').value,
            photo: document.getElementById('editDprtOfficerPhoto').value,
            status: document.getElementById('editDprtOfficerStatus').value,
        };

        fetch(`/admin/dprt/pengurus/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.textContent = 'Simpan Pengurus DPRt';
            if (data.success) {
                alert(data.message || 'Data Pengurus DPRt berhasil disimpan!');
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menyimpan data.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = 'Simpan Pengurus DPRt';
            alert('Terjadi kesalahan jaringan.');
            console.error(err);
        });
    }
</script>

@endsection
