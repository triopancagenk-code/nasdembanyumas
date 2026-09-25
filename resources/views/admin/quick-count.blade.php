@extends('layouts.app')

@section('title', 'Quick Count & Real Count Pemilu – DPD Partai NasDem Banyumas')

@section('content')

<style>
    /* ========================================================
       PERBAIKAN WARNA TEKS MODAL & FORM QUICK COUNT
       ======================================================== */
    #createTpsModal input,
    #createTpsModal select,
    #createTpsModal textarea,
    #editTpsModal input,
    #editTpsModal select,
    #editTpsModal textarea,
    #uploadC1PdfModal input,
    #uploadC1PdfModal select,
    #uploadC1PdfModal textarea,
    .quick-count-filter input,
    .quick-count-filter select {
        color: #0f172a !important;
        -webkit-text-fill-color: #0f172a !important;
        background-color: #ffffff !important;
        font-weight: 600 !important;
    }

    #createTpsModal select option,
    #editTpsModal select option,
    #uploadC1PdfModal select option,
    .quick-count-filter select option,
    select option {
        color: #0f172a !important;
        -webkit-text-fill-color: #0f172a !important;
        background-color: #ffffff !important;
        font-weight: 600 !important;
    }

    #createTpsModal label,
    #editTpsModal label,
    #uploadC1PdfModal label {
        color: #0f172a !important;
        font-weight: 800 !important;
    }

    #createTpsModal input::placeholder,
    #editTpsModal input::placeholder,
    #uploadC1PdfModal input::placeholder,
    #createTpsModal textarea::placeholder,
    #editTpsModal textarea::placeholder,
    #uploadC1PdfModal textarea::placeholder {
        color: #94a3b8 !important;
        -webkit-text-fill-color: #94a3b8 !important;
        opacity: 1 !important;
    }
</style>

{{-- Admin Top Banner --}}
<div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 110px 20px 40px; border-bottom: 3px solid #ffb700;">
    <div style="max-width: 1300px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                    POV ADMIN
                </span>
                <span style="color: #94a3b8; font-size: 13px;">Bappilu &amp; Saksi Tabulasi Pemilu</span>
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: #ffffff; margin: 0 0 6px 0;">
                Quick Count &amp; Real Count <span style="color: #ffb700;">Pemilu Banyumas</span>
            </h1>
            <p style="font-size: 14px; color: #cbd5e1; margin: 0;">
                Pusat tabulasi dan monitoring perolehan suara Partai NasDem di 6 Dapil, 27 Kecamatan, dan 5.587 TPS se-Kabupaten Banyumas.
            </p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.dprt') }}" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 9px 14px;">
                ← Ke DPRt
            </a>
            <a href="{{ route('admin.quick-count.export') }}" target="_blank" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 9px 14px; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Cetak Rekapitulasi C1
            </a>
            <button type="button" onclick="openUploadC1PdfModal()" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 9px 15px; display: inline-flex; align-items: center; gap: 7px; cursor: pointer; border: 1.5px solid #ffb700; background: #ffffff; color: #001333; font-weight: 800; border-radius: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="12" y2="12"/><line x1="15" y1="15" x2="12" y2="12"/></svg>
                Unggah C1 PDF
            </button>
            <button type="button" onclick="openCreateTpsModal()" class="btn-yellow" style="border: none; cursor: pointer; font-size: 13px; padding: 9px 18px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Input Hasil TPS (C1)
            </button>
            <a href="{{ route('admin.statistik') }}" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 9px 14px;">
                Ke Statistik →
            </a>
        </div>
    </div>
</div>

<div style="max-width: 1300px; margin: 30px auto 80px; padding: 0 20px;">

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; font-weight: 700; font-size: 14px; display: flex; align-items: center; justify-content: space-between;">
            <span>✓ {{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #065f46;">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
            <strong style="display: block; margin-bottom: 6px;">⚠️ Ada kendala saat menyimpan data:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ========================================================
         SUMMARY KPI CARDS
         ======================================================== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 30px;">
        {{-- Card 1: Suara NasDem --}}
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase;">SUARA MASUK NASDEM</span>
                <span style="background: #eff6ff; color: #001333; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 4px; border: 1px solid #bfdbfe;">NO. 5</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 4px 0;">
                {{ number_format($nasdemSuara, 0, ',', '.') }}
            </div>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 12px;">
                <span style="color: #ffb700; font-weight: 900; background: #001333; padding: 2px 6px; border-radius: 4px;">{{ $nasdemPersen }}%</span>
                <span style="color: #64748b; font-weight: 600;">Peringkat Ke-4 Se-Banyumas</span>
            </div>
        </div>

        {{-- Card 2: Estimasi Kursi --}}
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase;">ESTIMASI KURSI DPRD</span>
                <span style="background: #fef3c7; color: #92400e; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 4px;">SAINTE-LAGUË</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #ffb700; margin: 4px 0;">
                {{ $nasdemKursi }} <span style="font-size: 20px; color: #001333;">Kursi</span>
            </div>
            <span style="font-size: 12px; color: #10b981; font-weight: 700;">
                ✓ 1 Fraksi Mandiri Penuh (Lolos di Semua 6 Dapil)
            </span>
        </div>

        {{-- Card 3: Progress TPS Masuk --}}
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase;">PROGRESS TPS MASUK</span>
                <span style="font-size: 12px; font-weight: 900; color: #10b981;">{{ $persenTpsMasuk }}%</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 4px 0;">
                {{ number_format($tpsMasukCount, 0, ',', '.') }} <span style="font-size: 18px; color: #94a3b8; font-weight: 700;">/ {{ number_format($totalTpsBanyumas, 0, ',', '.') }}</span>
            </div>
            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden; margin-top: 8px;">
                <div style="width: {{ $persenTpsMasuk }}%; height: 100%; background: linear-gradient(90deg, #ffb700, #10b981); border-radius: 4px;"></div>
            </div>
        </div>

        {{-- Card 4: Status Verifikasi C1 --}}
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase;">DOKUMEN C1 TERCATAT</span>
                <span style="background: #ecfdf5; color: #059669; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 4px;">TERVERIFIKASI</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 4px 0;">
                {{ $recordedTpsCount }} <span style="font-size: 18px; color: #64748b; font-weight: 600;">TPS Sampel</span>
            </div>
            <span style="font-size: 12px; color: #0284c7; font-weight: 700;">
                {{ $verifiedTpsCount }} Terverifikasi • {{ $pendingTpsCount }} Menunggu Pleno
            </span>
        </div>
    </div>

    <!-- ========================================================
         BAGIAN 1: PEROLEHAN SUARA PARTAI POLITIK BANYUMAS
         ======================================================== -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 35px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 14px; margin-bottom: 20px;">
            <div>
                <h2 style="font-size: 18px; font-weight: 900; color: #001333; margin: 0 0 4px 0; display: flex; align-items: center; gap: 8px;">
                    📊 Perolehan Suara Partai Politik &amp; Estimasi Kursi DPRD Kabupaten Banyumas
                </h2>
                <span style="font-size: 13px; color: #64748b;">
                    Simulasi alokasi 50 Kursi DPRD Kabupaten Banyumas menggunakan metode Divisor Sainte-Laguë.
                </span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="background: #f1f5f9; color: #334155; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px;">
                    Total Suara Sah: {{ number_format($totalSuaraSemuaPartai, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px;">
            @foreach($parties as $party)
                @php
                    $isNasdem = str_contains($party->party_name, 'NasDem');
                    $pct = round(($party->total_suara / $totalSuaraSemuaPartai) * 100, 1);
                @endphp
                <div style="padding: 12px 16px; border-radius: 10px; background: {{ $isNasdem ? 'rgba(0, 19, 51, 0.04)' : '#f8fafc' }}; border: {{ $isNasdem ? '2px solid #ffb700' : '1px solid #e2e8f0' }}; display: flex; flex-direction: column; gap: 8px; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="width: 28px; height: 28px; border-radius: 6px; background: {{ $isNasdem ? '#001333' : '#64748b' }}; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900;">
                                {{ $party->party_number ?? $loop->iteration }}
                            </span>
                            <div>
                                <strong style="font-size: 14.5px; color: {{ $isNasdem ? '#001333' : '#1e293b' }};">
                                    {{ $party->party_name }}
                                </strong>
                                @if($isNasdem)
                                    <span style="background: #ffb700; color: #001333; font-size: 10px; font-weight: 900; padding: 1px 6px; border-radius: 4px; margin-left: 6px;">
                                        PARTAI KITA
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="text-align: right;">
                                <div style="font-size: 15px; font-weight: 900; color: {{ $isNasdem ? '#001333' : '#0f172a' }};">
                                    {{ number_format($party->total_suara, 0, ',', '.') }} Suara
                                </div>
                                <span style="font-size: 11px; color: #64748b; font-weight: 700;">{{ $pct }}%</span>
                            </div>

                            <div style="background: {{ $party->kursi_dprd > 0 ? ($isNasdem ? '#001333' : '#0f172a') : '#cbd5e1' }}; color: {{ $isNasdem ? '#ffb700' : '#ffffff' }}; font-weight: 900; font-size: 13px; padding: 6px 14px; border-radius: 6px; min-width: 80px; text-align: center;">
                                {{ $party->kursi_dprd }} Kursi
                            </div>
                        </div>
                    </div>

                    {{-- Bar Progress --}}
                    <div style="width: 100%; height: 7px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                        <div style="width: {{ min(100, $pct * 2.8) }}%; height: 100%; background: {{ $isNasdem ? '#ffb700' : $party->color_hex }}; border-radius: 4px;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ========================================================
         BAGIAN 2: PETA PEROLEHAN 6 DAERAH PEMILIHAN (DAPIL)
         ======================================================== -->
    <div style="margin-bottom: 35px;">
        <div style="border-bottom: 1.5px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: 900; color: #001333; margin: 0 0 4px 0; display: flex; align-items: center; gap: 8px;">
                🗺️ Rincian Perolehan Partai NasDem di 6 Dapil Kabupaten Banyumas
            </h2>
            <span style="font-size: 13px; color: #64748b;">
                Perolehan suara NasDem per daerah pemilihan serta kandidat peraih suara tertinggi.
            </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 18px;">
            @foreach($dapils as $dapilKey => $dapil)
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: 0; left: 0; width: 6px; height: 100%; background: #001333;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                        <div>
                            <span style="background: #001333; color: #ffb700; font-size: 11px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                                {{ $dapilKey }}
                            </span>
                            <h3 style="font-size: 16px; font-weight: 900; color: #001333; margin: 6px 0 2px;">
                                {{ $dapil['nama'] }}
                            </h3>
                            <span style="font-size: 11.5px; color: #64748b; display: block; line-height: 1.4;">
                                {{ $dapil['wilayah'] }}
                            </span>
                        </div>
                        <div style="text-align: right;">
                            <span style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 4px;">
                                Kuota: {{ $dapil['kursi'] }} Kursi
                            </span>
                        </div>
                    </div>

                    <div style="background: #f8fafc; border-radius: 8px; padding: 12px 14px; margin: 12px 0; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <span style="font-size: 11px; color: #64748b; font-weight: 700; display: block;">SUARA NASDEM</span>
                            <div style="font-size: 18px; font-weight: 900; color: #001333;">
                                {{ number_format($dapil['suara'], 0, ',', '.') }}
                            </div>
                            <span style="font-size: 10.5px; color: #10b981; font-weight: 700;">Target: {{ number_format($dapil['target'], 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span style="font-size: 11px; color: #64748b; font-weight: 700; display: block;">TPS MASUK</span>
                            <div style="font-size: 18px; font-weight: 900; color: #001333;">
                                {{ $dapil['tps_masuk'] }} <span style="font-size: 13px; color: #94a3b8;">/ {{ $dapil['tps_total'] }}</span>
                            </div>
                            <span style="font-size: 10.5px; color: #0284c7; font-weight: 700;">Progress: {{ $dapil['persen_masuk'] }}%</span>
                        </div>
                    </div>

                    <div style="border-top: 1px dashed #e2e8f0; padding-top: 10px; display: flex; align-items: center; justify-content: space-between; font-size: 12px;">
                        <div>
                            <span style="color: #64748b;">Caleg Suara Teratas:</span>
                            <div style="font-weight: 800; color: #001333;">{{ $dapil['top_candidate'] }}</div>
                        </div>
                        <div style="text-align: right;">
                            <span style="background: #ecfdf5; color: #059669; font-weight: 800; padding: 2px 8px; border-radius: 4px; font-size: 11px;">
                                {{ number_format($dapil['top_candidate_suara'], 0, ',', '.') }} Suara
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ========================================================
         BAGIAN 3: TABEL DATA HASIL TPS & C1 PLANO
         ======================================================== -->
    <div id="data-tps" style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); scroll-margin-top: 100px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 4px;">
                    <h2 style="font-size: 18px; font-weight: 900; color: #001333; margin: 0;">
                        📋 Data Masuk TPS &amp; Formulir C1 Plano
                    </h2>
                    <span style="background: #001333; color: #ffb700; font-size: 11px; font-weight: 900; padding: 3px 9px; border-radius: 5px;">
                        {{ $recordedTpsCount }} TPS Masuk (27 Kecamatan)
                    </span>
                    <span style="background: #ecfdf5; color: #059669; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 5px; border: 1px solid #a7f3d0;">
                        NasDem: {{ number_format($totalSuaraNasdemTps, 0, ',', '.') }} Suara
                    </span>
                    <span style="background: #eff6ff; color: #1e40af; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 5px; border: 1px solid #bfdbfe;">
                        Total Sah: {{ number_format($totalSuaraSahTps, 0, ',', '.') }} Suara
                    </span>
                </div>
                <span style="font-size: 13px; color: #64748b;">
                    Hasil input form C1 TPS dari saksi resmi Partai NasDem di lapangan se-Kabupaten Banyumas (27 Kecamatan).
                </span>
            </div>

            <button type="button" onclick="openCreateTpsModal()" class="btn-yellow" style="border: none; cursor: pointer; font-size: 13px; padding: 9px 18px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                + Tambah Hasil TPS Baru
            </button>
        </div>

        {{-- FILTER FORM --}}
        <form action="{{ route('admin.quick-count') }}" method="GET" class="quick-count-filter" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; background: #f8fafc; padding: 14px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e2e8f0;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari TPS, Desa, Kecamatan, atau Saksi..." style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background: #ffffff;">
            </div>

            <div style="min-width: 140px;">
                <select name="dapil" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #ffffff; color: #0f172a;">
                    <option value="all">Semua Dapil</option>
                    @foreach(['Dapil 1', 'Dapil 2', 'Dapil 3', 'Dapil 4', 'Dapil 5', 'Dapil 6'] as $d)
                        <option value="{{ $d }}" {{ request('dapil') === $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <div style="min-width: 150px;">
                <select name="kecamatan" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #ffffff; color: #0f172a;">
                    <option value="all">Semua Kecamatan</option>
                    @foreach($dpcs as $dpc)
                        <option value="{{ $dpc->kecamatan_name }}" {{ request('kecamatan') === $dpc->kecamatan_name ? 'selected' : '' }}>
                            {{ $dpc->kecamatan_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="min-width: 150px;">
                <select name="status" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #ffffff; color: #0f172a;">
                    <option value="all">Semua Status</option>
                    <option value="Terverifikasi" {{ request('status') === 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="Menunggu Verifikasi" {{ request('status') === 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="Perlu Koreksi" {{ request('status') === 'Perlu Koreksi' ? 'selected' : '' }}>Perlu Koreksi</option>
                </select>
            </div>

            <div style="min-width: 160px;">
                <select name="sort" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #ffffff; color: #0f172a;">
                    <option value="wilayah" {{ request('sort', 'wilayah') === 'wilayah' ? 'selected' : '' }}>🏛️ Urut Wilayah &amp; Dapil</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>⏱️ Urut Input Terbaru</option>
                    <option value="suara_desc" {{ request('sort') === 'suara_desc' ? 'selected' : '' }}>📈 Urut Suara Terbanyak</option>
                </select>
            </div>

            <button type="submit" class="admin-btn admin-btn-navy" style="padding: 8px 16px; font-size: 13px; font-weight: 800; cursor: pointer; border: none; border-radius: 6px; background: #001333; color: #ffb700;">
                Terapkan Filter
            </button>

            @if(request()->anyFilled(['q', 'dapil', 'kecamatan', 'status', 'sort']))
                <a href="{{ route('admin.quick-count') }}" class="admin-btn admin-btn-light" style="padding: 8px 14px; text-decoration: none; font-size: 13px;">
                    Reset
                </a>
            @endif
        </form>

        {{-- TABLE DATA --}}
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                <thead>
                    <tr style="background: #001333; color: #ffffff;">
                        <th style="padding: 12px 14px; font-weight: 800; border-radius: 6px 0 0 0;">No</th>
                        <th style="padding: 12px 14px; font-weight: 800;">Dapil / Wilayah</th>
                        <th style="padding: 12px 14px; font-weight: 800;">TPS</th>
                        <th style="padding: 12px 14px; font-weight: 800; text-align: right;">Suara NasDem</th>
                        <th style="padding: 12px 14px; font-weight: 800; text-align: right;">Total Suara Sah</th>
                        <th style="padding: 12px 14px; font-weight: 800; text-align: center;">% NasDem</th>
                        <th style="padding: 12px 14px; font-weight: 800;">Saksi TPS</th>
                        <th style="padding: 12px 14px; font-weight: 800; text-align: center;">Bukti C1</th>
                        <th style="padding: 12px 14px; font-weight: 800; text-align: center;">Status</th>
                        <th style="padding: 12px 14px; font-weight: 800; text-align: center; border-radius: 0 6px 0 0;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tpsList as $tps)
                        @php
                            $nasdemPct = $tps->suara_sah > 0 ? round(($tps->suara_nasdem / $tps->suara_sah) * 100, 1) : 0;
                            $isPdf = $tps->c1_photo && str_ends_with(strtolower($tps->c1_photo), '.pdf');
                        @endphp
                        <tr style="border-bottom: 1px solid #f1f5f9; background: {{ $loop->even ? '#fcfdfd' : '#ffffff' }};">
                            <td style="padding: 12px 14px; color: #64748b; font-weight: 700;">
                                {{ $loop->iteration + ($tpsList->currentPage() - 1) * $tpsList->perPage() }}
                            </td>
                            <td style="padding: 12px 14px;">
                                <strong style="color: #001333; font-size: 13.5px;">{{ $tps->kecamatan_name }}</strong>
                                <span style="display: block; font-size: 11.5px; color: #64748b;">
                                    Desa {{ $tps->desa_name }} • <span style="color: #ff9900; font-weight: 800;">{{ $tps->dapil }}</span>
                                </span>
                            </td>
                            <td style="padding: 12px 14px;">
                                <span style="background: #001333; color: #ffb700; font-weight: 900; font-size: 11.5px; padding: 3px 8px; border-radius: 4px;">
                                    {{ $tps->tps_number }}
                                </span>
                                <span style="display: block; font-size: 11px; color: #94a3b8; margin-top: 3px;">DPT: {{ $tps->total_dpt }}</span>
                            </td>
                            <td style="padding: 12px 14px; text-align: right; font-weight: 900; font-size: 15px; color: #001333;">
                                {{ number_format($tps->suara_nasdem, 0, ',', '.') }}
                            </td>
                            <td style="padding: 12px 14px; text-align: right; font-size: 13px; color: #475569; font-weight: 700;">
                                {{ number_format($tps->suara_sah, 0, ',', '.') }}
                            </td>
                            <td style="padding: 12px 14px; text-align: center;">
                                <span style="background: {{ $nasdemPct >= 25 ? '#ecfdf5' : '#eff6ff' }}; color: {{ $nasdemPct >= 25 ? '#059669' : '#1e40af' }}; font-weight: 900; font-size: 12px; padding: 2px 8px; border-radius: 4px;">
                                    {{ $nasdemPct }}%
                                </span>
                            </td>
                            <td style="padding: 12px 14px;">
                                <div style="font-weight: 700; color: #1e293b;">{{ $tps->saksi_name ?: '-' }}</div>
                                @if($tps->saksi_phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tps->saksi_phone) }}" target="_blank" style="font-size: 11px; color: #10b981; text-decoration: none; font-weight: 700;">
                                        📱 {{ $tps->saksi_phone }}
                                    </a>
                                @endif
                            </td>
                            <td style="padding: 12px 14px; text-align: center;">
                                @if($tps->c1_photo)
                                    @if($isPdf)
                                        <button type="button" onclick="previewC1('{{ asset($tps->c1_photo) }}', '{{ $tps->tps_number }} Desa {{ $tps->desa_name }}')" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                            📄 Dokumen PDF
                                        </button>
                                    @else
                                        <button type="button" onclick="previewC1('{{ asset($tps->c1_photo) }}', '{{ $tps->tps_number }} Desa {{ $tps->desa_name }}')" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                            📷 Foto C1
                                        </button>
                                    @endif
                                @else
                                    <span style="color: #94a3b8; font-size: 11px; font-style: italic;">Belum ada</span>
                                @endif
                            </td>
                            <td style="padding: 12px 14px; text-align: center;">
                                @if($tps->status === 'Terverifikasi')
                                    <span style="background: #ecfdf5; color: #059669; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                                        ✓ Valid
                                    </span>
                                @elseif($tps->status === 'Menunggu Verifikasi')
                                    <span style="background: #fffbeb; color: #d97706; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                                        ⏳ Pending
                                    </span>
                                @else
                                    <span style="background: #fef2f2; color: #dc2626; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                                        ⚠️ Koreksi
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 12px 14px; text-align: center;">
                                <div style="display: flex; justify-content: center; gap: 5px;">
                                    @if($tps->status !== 'Terverifikasi')
                                        <button type="button" onclick="fastVerifyTps({{ $tps->id }})" title="Verifikasi Cepat" style="background: #10b981; color: #ffffff; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 800; cursor: pointer;">
                                            ✓
                                        </button>
                                    @endif
                                    <button type="button" onclick="openEditTpsModal({{ json_encode($tps) }})" title="Edit Data TPS" style="background: #001333; color: #ffb700; border: none; padding: 4px 9px; border-radius: 4px; font-size: 11px; font-weight: 800; cursor: pointer;">
                                        ✏️
                                    </button>
                                    <button type="button" onclick="confirmDeleteTps({{ $tps->id }}, '{{ $tps->tps_number }} {{ $tps->desa_name }}')" title="Hapus Data" style="background: #fee2e2; color: #dc2626; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 800; cursor: pointer;">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="padding: 30px; text-align: center; color: #64748b;">
                                <div style="font-size: 32px; margin-bottom: 8px;">🗳️</div>
                                <strong>Belum ada data TPS yang cocok dengan filter.</strong>
                                <p style="font-size: 12px; margin: 4px 0 12px;">Silakan klik tombol <em>Input Hasil TPS (C1)</em> untuk memasukkan data baru.</p>
                                <button type="button" onclick="openCreateTpsModal()" class="btn-yellow" style="border: none; padding: 6px 14px; font-size: 12px; font-weight: 800; cursor: pointer; border-radius: 4px;">
                                    + Input Hasil TPS
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($tpsList->hasPages())
            <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <span style="font-size: 12px; color: #64748b;">
                    Menampilkan data TPS {{ $tpsList->firstItem() }} - {{ $tpsList->lastItem() }} dari {{ $tpsList->total() }} data masuk
                </span>
                <div>
                    {{ $tpsList->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ========================================================
     MODAL 1: INPUT TPS BARU
     ======================================================== -->
<div id="createTpsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeCreateTpsModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>

    <div style="position: relative; background: #ffffff; width: 100%; max-width: 680px; border-radius: 14px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); max-height: 92vh; display: flex; flex-direction: column;">
        <div style="background: #001333; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #ffb700;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 20px;">🗳️</span>
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 900; color: #ffb700;">Input Hasil Quick Count TPS (C1)</h3>
                    <span style="font-size: 11.5px; color: #94a3b8;">Tabulasi data formulir C1 Plano perolehan Partai NasDem</span>
                </div>
            </div>
            <button type="button" onclick="closeCreateTpsModal()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('admin.quick-count.store') }}" method="POST" enctype="multipart/form-data" style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px;">
            @csrf

            {{-- Bagian 1: Wilayah TPS --}}
            <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 12px;">
                <span style="font-size: 11px; font-weight: 900; color: #001333; text-transform: uppercase; letter-spacing: 0.5px;">📍 Wilayah &amp; Identitas TPS</span>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Daerah Pemilihan (Dapil) *</label>
                        <select name="dapil" id="createDapil" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                            @foreach(['Dapil 1', 'Dapil 2', 'Dapil 3', 'Dapil 4', 'Dapil 5', 'Dapil 6'] as $d)
                                <option value="{{ $d }}" style="color: #0f172a; background-color: #ffffff;">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Kecamatan *</label>
                        <select name="kecamatan_name" id="createKecamatan" onchange="onKecamatanChange(this.value, 'createDesa')" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                            <option value="" style="color: #0f172a; background-color: #ffffff;">-- Pilih Kecamatan --</option>
                            @foreach($dpcs as $dpc)
                                <option value="{{ $dpc->kecamatan_name }}" data-dapil="{{ $dpc->dapil }}" style="color: #0f172a; background-color: #ffffff;">{{ $dpc->kecamatan_name }} ({{ $dpc->dapil }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Desa / Kelurahan *</label>
                        <input type="text" name="desa_name" id="createDesa" list="desaSuggestions" required placeholder="Contoh: Sokaraja Kulon" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <datalist id="desaSuggestions"></datalist>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Nomor TPS *</label>
                        <input type="text" name="tps_number" placeholder="Contoh: TPS 01 / TPS 14" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                    </div>
                </div>
            </div>

            {{-- Bagian 2: Hasil Perolehan Suara --}}
            <div style="background: #fffbeb; padding: 14px; border-radius: 10px; border: 1.5px solid #fde68a; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 11px; font-weight: 900; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">🗳️ Perolehan Suara Hasil Pleno TPS</span>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 900; color: #001333; margin-bottom: 4px;">
                            ⭐ Suara NasDem *
                        </label>
                        <input type="number" name="suara_nasdem" required min="0" placeholder="0" style="width: 100%; padding: 9px 12px; border: 2px solid #ffb700; border-radius: 6px; font-size: 16px; font-weight: 900; color: #001333; background-color: #ffffff; box-sizing: border-box;">
                        <span style="font-size: 10.5px; color: #b45309; font-weight: 700; display: block; margin-top: 3px;">Partai Kita</span>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
                            Total Suara Sah *
                        </label>
                        <input type="number" name="suara_sah" required min="0" placeholder="0" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 15px; font-weight: 700; color: #0f172a; background-color: #ffffff; box-sizing: border-box;">
                        <span style="font-size: 10.5px; color: #64748b; font-weight: 600; display: block; margin-top: 3px;">Seluruh Partai</span>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
                            Suara Tidak Sah
                        </label>
                        <input type="number" name="suara_tidak_sah" min="0" value="0" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 15px; font-weight: 700; color: #0f172a; background-color: #ffffff; box-sizing: border-box;">
                        <span style="font-size: 10.5px; color: #64748b; font-weight: 600; display: block; margin-top: 3px;">Rusak / Blanko</span>
                    </div>
                </div>
            </div>

            {{-- Bagian 3: Saksi & Status Verifikasi --}}
            <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 12px;">
                <span style="font-size: 11px; font-weight: 900; color: #001333; text-transform: uppercase; letter-spacing: 0.5px;">👤 Data Saksi &amp; Status Verifikasi</span>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Nama Saksi TPS</label>
                        <input type="text" name="saksi_name" placeholder="Nama saksi mandat partai" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">No. WhatsApp Saksi</label>
                        <input type="text" name="saksi_phone" placeholder="0812-xxxx-xxxx" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Status Verifikasi *</label>
                    <select name="status" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="Terverifikasi" selected style="color: #0f172a; background-color: #ffffff;">✓ Terverifikasi (Pleno)</option>
                        <option value="Menunggu Verifikasi" style="color: #0f172a; background-color: #ffffff;">⏳ Menunggu Verifikasi</option>
                        <option value="Perlu Koreksi" style="color: #0f172a; background-color: #ffffff;">⚠️ Perlu Koreksi</option>
                    </select>
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Catatan Lapangan / Kejadian Khusus</label>
                <textarea name="notes" rows="2" placeholder="Catatan saksi bila ada keberatan atau hal khusus saat pleno TPS..." style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 8px; border-top: 1.5px solid #e2e8f0; padding-top: 16px;">
                <button type="button" onclick="closeCreateTpsModal()" class="admin-btn admin-btn-light" style="padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 700;">
                    Batal
                </button>
                <button type="submit" class="btn-yellow" style="border: none; padding: 10px 24px; border-radius: 6px; font-weight: 900; font-size: 13.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    💾 Simpan Data TPS
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     MODAL 2: EDIT TPS
     ======================================================== -->
<div id="editTpsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeEditTpsModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>

    <div style="position: relative; background: #ffffff; width: 100%; max-width: 680px; border-radius: 14px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); max-height: 92vh; display: flex; flex-direction: column;">
        <div style="background: #001333; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #ffb700;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 20px;">✏️</span>
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 900; color: #ffb700;" id="editModalTitle">Edit Hasil TPS</h3>
                    <span style="font-size: 11.5px; color: #94a3b8;">Perbarui data perolehan suara TPS</span>
                </div>
            </div>
            <button type="button" onclick="closeEditTpsModal()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form id="editTpsForm" method="POST" enctype="multipart/form-data" style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px;">
            @csrf

            <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 12px;">
                <span style="font-size: 11px; font-weight: 900; color: #001333; text-transform: uppercase; letter-spacing: 0.5px;">📍 Wilayah &amp; Identitas TPS</span>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Dapil *</label>
                        <select name="dapil" id="editDapil" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                            @foreach(['Dapil 1', 'Dapil 2', 'Dapil 3', 'Dapil 4', 'Dapil 5', 'Dapil 6'] as $d)
                                <option value="{{ $d }}" style="color: #0f172a; background-color: #ffffff;">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Kecamatan *</label>
                        <input type="text" name="kecamatan_name" id="editKecamatan" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Desa / Kelurahan *</label>
                        <input type="text" name="desa_name" id="editDesa" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Nomor TPS *</label>
                        <input type="text" name="tps_number" id="editTpsNumber" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                    </div>
                </div>
            </div>

            <div style="background: #fffbeb; padding: 14px; border-radius: 10px; border: 1.5px solid #fde68a; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 11px; font-weight: 900; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">🗳️ Perolehan Suara Hasil Pleno TPS</span>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 900; color: #001333; margin-bottom: 4px;">⭐ Suara NasDem *</label>
                        <input type="number" name="suara_nasdem" id="editSuaraNasdem" required min="0" style="width: 100%; padding: 9px 12px; border: 2px solid #ffb700; border-radius: 6px; font-size: 16px; font-weight: 900; color: #001333; background-color: #ffffff; box-sizing: border-box;">
                        <span style="font-size: 10.5px; color: #b45309; font-weight: 700; display: block; margin-top: 3px;">Partai Kita</span>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Total Suara Sah *</label>
                        <input type="number" name="suara_sah" id="editSuaraSah" required min="0" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 15px; font-weight: 700; color: #0f172a; background-color: #ffffff; box-sizing: border-box;">
                        <span style="font-size: 10.5px; color: #64748b; font-weight: 600; display: block; margin-top: 3px;">Seluruh Partai</span>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Suara Tidak Sah</label>
                        <input type="number" name="suara_tidak_sah" id="editSuaraTidakSah" min="0" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 15px; font-weight: 700; color: #0f172a; background-color: #ffffff; box-sizing: border-box;">
                        <span style="font-size: 10.5px; color: #64748b; font-weight: 600; display: block; margin-top: 3px;">Rusak / Blanko</span>
                    </div>
                </div>
            </div>

            <div style="background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 12px;">
                <span style="font-size: 11px; font-weight: 900; color: #001333; text-transform: uppercase; letter-spacing: 0.5px;">👤 Data Saksi &amp; Status Verifikasi</span>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Nama Saksi</label>
                        <input type="text" name="saksi_name" id="editSaksiName" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">No. WhatsApp Saksi</label>
                        <input type="text" name="saksi_phone" id="editSaksiPhone" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Status Verifikasi *</label>
                    <select name="status" id="editStatus" required style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="Terverifikasi" style="color: #0f172a; background-color: #ffffff;">✓ Terverifikasi (Pleno)</option>
                        <option value="Menunggu Verifikasi" style="color: #0f172a; background-color: #ffffff;">⏳ Menunggu Verifikasi</option>
                        <option value="Perlu Koreksi" style="color: #0f172a; background-color: #ffffff;">⚠️ Perlu Koreksi</option>
                    </select>
                </div>
            </div>

            <div style="background: #f1f5f9; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; font-size: 12.5px;">
                <span style="color: #475569; font-weight: 700;">Dokumen C1:</span>
                <span id="editCurrentC1Info" style="font-weight: 700; color: #0f172a;">Belum ada berkas C1</span>
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Catatan Saksi</label>
                <textarea name="notes" id="editNotes" rows="2" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 8px; border-top: 1.5px solid #e2e8f0; padding-top: 16px;">
                <button type="button" onclick="closeEditTpsModal()" class="admin-btn admin-btn-light" style="padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 700;">
                    Batal
                </button>
                <button type="submit" class="btn-yellow" style="border: none; padding: 10px 24px; border-radius: 6px; font-weight: 900; font-size: 13.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     MODAL KHUSUS: UNGGAH DOKUMEN C1 PLANO (PDF)
     ======================================================== -->
<div id="uploadC1PdfModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeUploadC1PdfModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>

    <div style="position: relative; background: #ffffff; width: 100%; max-width: 660px; border-radius: 14px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); max-height: 92vh; display: flex; flex-direction: column;">
        <div style="background: #001333; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #ffb700;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 24px;">📄</span>
                <div>
                    <h3 style="margin: 0; font-size: 17px; font-weight: 900; color: #ffb700;">Unggah Dokumen Formulir C1 Plano (PDF)</h3>
                    <span style="font-size: 11.5px; color: #94a3b8;">Arsipkan berkas pindaian / scan PDF resmi C1 TPS ke sistem</span>
                </div>
            </div>
            <button type="button" onclick="closeUploadC1PdfModal()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('admin.quick-count.upload-c1') }}" method="POST" enctype="multipart/form-data" style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px;">
            @csrf

            {{-- Mode Switcher Tabs --}}
            <div style="display: flex; background: #f1f5f9; padding: 4px; border-radius: 8px; gap: 6px;">
                <button type="button" id="tabBtnExisting" onclick="switchUploadMode('existing')" style="flex: 1; padding: 8px 12px; border: none; border-radius: 6px; font-size: 12.5px; font-weight: 800; cursor: pointer; background: #001333; color: #ffb700; transition: all 0.15s ease;">
                    1. Tautkan ke TPS Terdaftar
                </button>
                <button type="button" id="tabBtnNew" onclick="switchUploadMode('new')" style="flex: 1; padding: 8px 12px; border: none; border-radius: 6px; font-size: 12.5px; font-weight: 800; cursor: pointer; background: transparent; color: #64748b; transition: all 0.15s ease;">
                    2. Input TPS Baru + PDF
                </button>
            </div>
            <input type="hidden" name="mode" id="uploadModeInput" value="existing">

            {{-- PANEL 1: EXISTING TPS --}}
            <div id="panelExistingTps" style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">
                        Pilih TPS Sasaran Dokumen C1 *
                    </label>
                    <select name="tps_id" id="uploadExistingTpsSelect" style="width: 100%; padding: 10px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="">-- Pilih TPS yang Ingin Dilampirkan C1 PDF --</option>
                        @foreach($allTpsList as $tpsItem)
                            <option value="{{ $tpsItem->id }}">
                                {{ $tpsItem->tps_number }} – Desa {{ $tpsItem->desa_name }}, Kec. {{ $tpsItem->kecamatan_name }} ({{ $tpsItem->dapil }}) {{ $tpsItem->c1_photo ? '• [Sudah ada file]' : '• [Belum ada C1]' }}
                            </option>
                        @endforeach
                    </select>
                    <span style="font-size: 11px; color: #64748b; margin-top: 3px; display: block;">Pilih data TPS yang suaranya telah diinput untuk ditautkan berkas C1 PDF resminya.</span>
                </div>
            </div>

            {{-- PANEL 2: NEW TPS FORM (HIDDEN BY DEFAULT) --}}
            <div id="panelNewTps" style="display: none; flex-direction: column; gap: 12px; background: #f8fafc; padding: 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <span style="font-size: 11px; font-weight: 900; color: #001333; text-transform: uppercase;">Identitas TPS Baru</span>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="display: block; font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Dapil *</label>
                        <select name="dapil" id="uploadDapil" style="width: 100%; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 12.5px; color: #0f172a; background: #ffffff;">
                            @foreach(['Dapil 1', 'Dapil 2', 'Dapil 3', 'Dapil 4', 'Dapil 5', 'Dapil 6'] as $d)
                                <option value="{{ $d }}">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Kecamatan *</label>
                        <select name="kecamatan_name" id="uploadKecamatan" onchange="onKecamatanChange(this.value, 'uploadDesa')" style="width: 100%; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 12.5px; color: #0f172a; background: #ffffff;">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($dpcs as $dpc)
                                <option value="{{ $dpc->kecamatan_name }}" data-dapil="{{ $dpc->dapil }}">{{ $dpc->kecamatan_name }} ({{ $dpc->dapil }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="display: block; font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Desa / Kelurahan *</label>
                        <input type="text" name="desa_name" id="uploadDesa" placeholder="Contoh: Sokaraja Kulon" style="width: 100%; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 12.5px; box-sizing: border-box; color: #0f172a; background: #ffffff;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Nomor TPS *</label>
                        <input type="text" name="tps_number" placeholder="Contoh: TPS 05" style="width: 100%; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 12.5px; box-sizing: border-box; color: #0f172a; background: #ffffff;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="display: block; font-size: 11.5px; font-weight: 900; color: #001333; margin-bottom: 3px;">Suara NasDem *</label>
                        <input type="number" name="suara_nasdem" min="0" placeholder="0" style="width: 100%; padding: 8px 10px; border: 2px solid #ffb700; border-radius: 6px; font-size: 13px; font-weight: 800; color: #001333; background: #ffffff; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Total Suara Sah *</label>
                        <input type="number" name="suara_sah" min="0" placeholder="0" style="width: 100%; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: 700; color: #0f172a; background: #ffffff; box-sizing: border-box;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="display: block; font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Nama Saksi</label>
                        <input type="text" name="saksi_name" placeholder="Nama saksi mandat" style="width: 100%; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 12.5px; box-sizing: border-box; color: #0f172a; background: #ffffff;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11.5px; font-weight: 800; color: #0f172a; margin-bottom: 3px;">Status Verifikasi</label>
                        <select name="status" style="width: 100%; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 12.5px; color: #0f172a; background: #ffffff;">
                            <option value="Terverifikasi" selected>Terverifikasi</option>
                            <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                            <option value="Perlu Koreksi">Perlu Koreksi</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- File PDF Input (Shared) --}}
            <div style="background: #fef2f2; border: 1.5px dashed #ef4444; border-radius: 10px; padding: 16px; text-align: center;">
                <div style="margin-bottom: 8px;">
                    <span style="font-size: 28px;">📑</span>
                    <strong style="display: block; font-size: 13.5px; color: #991b1b; margin-top: 4px;">Pilih Berkas Dokumen PDF C1 Plano *</strong>
                    <span style="font-size: 11.5px; color: #7f1d1d;">Format resmi: <strong>.PDF</strong> (Maksimal ukuran berkas 20 MB)</span>
                </div>
                <input type="file" name="c1_pdf_file" accept=".pdf,application/pdf" required style="font-size: 12.5px; padding: 8px 12px; background: #ffffff; border: 1px solid #fca5a5; border-radius: 6px; width: 90%; max-width: 400px; color: #0f172a;">
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows="2" placeholder="Catatan mengenai berkas C1 (misal: scan C1 asli bertanda tangan KPPS lengkap)..." style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 8px; border-top: 1.5px solid #e2e8f0; padding-top: 16px;">
                <button type="button" onclick="closeUploadC1PdfModal()" class="admin-btn admin-btn-light" style="padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 700;">
                    Batal
                </button>
                <button type="submit" class="btn-yellow" style="border: none; padding: 10px 24px; border-radius: 6px; font-weight: 900; font-size: 13.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; background: #ffb700; color: #001333;">
                    🚀 Unggah &amp; Simpan C1 PDF
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     MODAL 3: PREVIEW BUKTI C1 (PDF & FOTO)
     ======================================================== -->
<div id="c1PreviewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeC1Preview()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.9); backdrop-filter: blur(5px);"></div>
    <div style="position: relative; max-width: 900px; width: 100%; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.5); max-height: 92vh; display: flex; flex-direction: column;">
        <div style="background: #001333; color: #ffffff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ffb700;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span id="c1ModalBadge" style="background: #ffb700; color: #001333; font-size: 10.5px; font-weight: 900; padding: 2px 7px; border-radius: 4px; text-transform: uppercase;">
                    DOKUMEN C1
                </span>
                <strong id="c1ModalTitle" style="color: #ffffff; font-size: 14px;">Bukti Dokumen C1</strong>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <a id="c1DownloadBtn" href="" target="_blank" download style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                    ⬇️ Unduh Berkas
                </a>
                <a id="c1NewTabBtn" href="" target="_blank" style="background: rgba(255,255,255,0.15); color: #ffffff; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                    ↗️ Tab Baru
                </a>
                <button type="button" onclick="closeC1Preview()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer; line-height: 1; margin-left: 6px;">&times;</button>
            </div>
        </div>
        <div style="padding: 16px; text-align: center; flex: 1; overflow-y: auto; background: #f8fafc; min-height: 350px; display: flex; align-items: center; justify-content: center;">
            <iframe id="c1ModalIframe" src="" style="width: 100%; height: 70vh; border: 1px solid #cbd5e1; border-radius: 8px; display: none; background: #ffffff;"></iframe>
            <img id="c1ModalImg" src="" alt="Bukti C1" style="max-width: 100%; max-height: 70vh; border-radius: 8px; border: 1px solid #e2e8f0; object-fit: contain; display: none;">
        </div>
    </div>
</div>

{{-- SCRIPT INTERAKSI --}}
<script>
    const desaMap = @json($desaByKecamatan);

    function onKecamatanChange(kecName, desaInputId) {
        const dataList = document.getElementById('desaSuggestions');
        dataList.innerHTML = '';
        if (desaMap[kecName]) {
            desaMap[kecName].forEach(d => {
                const opt = document.createElement('option');
                opt.value = d;
                dataList.appendChild(opt);
            });
        }
        // Auto select dapil
        const selKec = document.getElementById('createKecamatan');
        const selectedOpt = selKec.options[selKec.selectedIndex];
        if (selectedOpt && selectedOpt.dataset.dapil) {
            document.getElementById('createDapil').value = selectedOpt.dataset.dapil;
        }
    }

    function openCreateTpsModal() {
        document.getElementById('createTpsModal').style.display = 'flex';
    }

    function closeCreateTpsModal() {
        document.getElementById('createTpsModal').style.display = 'none';
    }

    function openEditTpsModal(tps) {
        const form = document.getElementById('editTpsForm');
        form.action = `/admin/quick-count/${tps.id}`;
        document.getElementById('editModalTitle').textContent = `✏️ Edit Hasil ${tps.tps_number} Desa ${tps.desa_name}`;
        document.getElementById('editDapil').value = tps.dapil;
        document.getElementById('editKecamatan').value = tps.kecamatan_name;
        document.getElementById('editDesa').value = tps.desa_name;
        document.getElementById('editTpsNumber').value = tps.tps_number;
        document.getElementById('editSuaraNasdem').value = tps.suara_nasdem;
        document.getElementById('editSuaraSah').value = tps.suara_sah;
        document.getElementById('editSuaraTidakSah').value = tps.suara_tidak_sah || 0;
        document.getElementById('editSaksiName').value = tps.saksi_name || '';
        document.getElementById('editSaksiPhone').value = tps.saksi_phone || '';
        document.getElementById('editStatus').value = tps.status;
        document.getElementById('editNotes').value = tps.notes || '';

        const currentC1Span = document.getElementById('editCurrentC1Info');
        if (currentC1Span) {
            if (tps.c1_photo) {
                const isPdf = tps.c1_photo.toLowerCase().endsWith('.pdf');
                currentC1Span.innerHTML = `<a href="${tps.c1_photo}" target="_blank" style="color: #0284c7; text-decoration: underline;">${isPdf ? '📄 Lihat Dokumen PDF' : '📷 Lihat Foto C1'}</a>`;
            } else {
                currentC1Span.textContent = 'Belum ada berkas C1.';
            }
        }

        document.getElementById('editTpsModal').style.display = 'flex';
    }

    function closeEditTpsModal() {
        document.getElementById('editTpsModal').style.display = 'none';
    }

    function previewC1(url, title) {
        const isPdf = url.toLowerCase().endsWith('.pdf');
        const iframe = document.getElementById('c1ModalIframe');
        const img = document.getElementById('c1ModalImg');
        const badge = document.getElementById('c1ModalBadge');
        const dlBtn = document.getElementById('c1DownloadBtn');
        const tabBtn = document.getElementById('c1NewTabBtn');

        dlBtn.href = url;
        tabBtn.href = url;

        if (isPdf) {
            badge.textContent = 'BERKAS PDF';
            badge.style.background = '#ef4444';
            badge.style.color = '#ffffff';
            img.style.display = 'none';
            img.src = '';
            iframe.style.display = 'block';
            iframe.src = url;
        } else {
            badge.textContent = 'FOTO C1';
            badge.style.background = '#ffb700';
            badge.style.color = '#001333';
            iframe.style.display = 'none';
            iframe.src = '';
            img.style.display = 'block';
            img.src = url;
        }

        document.getElementById('c1ModalTitle').textContent = `Bukti C1 – ${title}`;
        document.getElementById('c1PreviewModal').style.display = 'flex';
    }

    function closeC1Preview() {
        document.getElementById('c1PreviewModal').style.display = 'none';
        document.getElementById('c1ModalIframe').src = '';
        document.getElementById('c1ModalImg').src = '';
    }

    function fastVerifyTps(id) {
        if (!confirm('Verifikasi data hasil TPS ini sekarang?')) return;
        fetch(`/admin/quick-count/${id}/verify`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            }
        })
        .catch(err => alert('Gagal verifikasi: ' + err.message));
    }

    function confirmDeleteTps(id, info) {
        if (!confirm(`Apakah Anda yakin ingin menghapus data ${info} dari Quick Count?`)) return;
        fetch(`/admin/quick-count/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            }
        })
        .catch(err => alert('Gagal menghapus: ' + err.message));
    }

    function openUploadC1PdfModal() {
        document.getElementById('uploadC1PdfModal').style.display = 'flex';
    }

    function closeUploadC1PdfModal() {
        document.getElementById('uploadC1PdfModal').style.display = 'none';
    }

    function switchUploadMode(mode) {
        document.getElementById('uploadModeInput').value = mode;
        const tabExisting = document.getElementById('tabBtnExisting');
        const tabNew = document.getElementById('tabBtnNew');
        const panelExisting = document.getElementById('panelExistingTps');
        const panelNew = document.getElementById('panelNewTps');
        const selectExisting = document.getElementById('uploadExistingTpsSelect');

        if (mode === 'existing') {
            tabExisting.style.background = '#001333';
            tabExisting.style.color = '#ffb700';
            tabNew.style.background = 'transparent';
            tabNew.style.color = '#64748b';
            panelExisting.style.display = 'flex';
            panelNew.style.display = 'none';
            if (selectExisting) selectExisting.required = true;
        } else {
            tabNew.style.background = '#001333';
            tabNew.style.color = '#ffb700';
            tabExisting.style.background = 'transparent';
            tabExisting.style.color = '#64748b';
            panelExisting.style.display = 'none';
            panelNew.style.display = 'flex';
            if (selectExisting) selectExisting.required = false;
        }
    }

    // Escape key modal closer
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateTpsModal();
            closeEditTpsModal();
            closeUploadC1PdfModal();
            closeC1Preview();
        }
    });
</script>

@endsection
