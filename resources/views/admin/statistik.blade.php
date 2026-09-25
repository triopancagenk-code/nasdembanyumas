@extends('layouts.app')

@section('title', 'Statistik Wilayah & Anggota – DPD Partai NasDem Banyumas')

@section('content')

{{-- Admin Top Banner --}}
<div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 110px 20px 40px; border-bottom: 3px solid #ffb700;">
    <div style="max-width: 1300px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                    POV ADMIN
                </span>
                <span style="color: #94a3b8; font-size: 13px;">Dashboard Analitik Partai</span>
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: #ffffff; margin: 0 0 6px 0;">
                Statistik Wilayah &amp; <span style="color: #ffb700;">Statistik Anggota</span>
            </h1>
            <p style="font-size: 14px; color: #cbd5e1; margin: 0;">
                Data teritorial keterisian struktur partai dan demografi keanggotaan kader DPD Partai NasDem Kabupaten Banyumas.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.dpc') }}" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 8px 14px;">
                ← Kelola DPC
            </a>
            <a href="{{ route('admin.calon-legislatif') }}" class="btn-yellow" style="text-decoration: none; font-size: 12px; padding: 8px 16px; border-radius: 6px; font-weight: 800;">
                Ke Calon Legislatif →
            </a>
        </div>
    </div>
</div>

<div style="max-width: 1300px; margin: 40px auto 80px; padding: 0 20px;">

    <!-- ========================================================
         BAGIAN 1: STATISTIK WILAYAH
         ======================================================== -->
    <div style="margin-bottom: 50px;">
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid rgba(255, 255, 255, 0.15); padding-bottom: 12px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    📍
                </div>
                <div>
                    <h2 style="font-size: 22px; font-weight: 900; color: #ffb700; margin: 0;">1. Statistik Cakupan Wilayah</h2>
                    <span style="font-size: 13px; color: #cbd5e1;">Keterisian struktur dari DPD Kabupaten, DPC Kecamatan, hingga DPRt Desa/Kelurahan</span>
                </div>
            </div>
            <span style="background: #10b981; color: #ffffff; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                Ketercapaian Teritorial: {{ $persentaseWilayah }}%
            </span>
        </div>

        <!-- 4 Wilayah Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 24px;">
            <div style="background: #ffffff; border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">DPD KABUPATEN</span>
                <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 6px 0;">{{ $totalDpd }} Wilayah</div>
                <span style="font-size: 12px; color: #10b981; font-weight: 700;">Kabupaten Banyumas (100%)</span>
            </div>

            <div style="background: #ffffff; border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">DPC KECAMATAN</span>
                <div style="font-size: 32px; font-weight: 900; color: #ffb700; margin: 6px 0;">{{ $totalDpc }} / 27</div>
                <span style="font-size: 12px; color: #10b981; font-weight: 700;">100% Terbentuk Definitif</span>
            </div>

            <div style="background: #ffffff; border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">DPRT DESA &amp; KELURAHAN</span>
                <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 6px 0;">{{ $dprtTerbentuk }} / {{ $totalDprt }}</div>
                <span style="font-size: 12px; color: #059669; font-weight: 700;">{{ $dprtTerbentuk }} SK Resmi • {{ $dprtMandataris }} Mandataris</span>
            </div>

            <div style="background: #ffffff; border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">DAERAH PEMILIHAN</span>
                <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 6px 0;">6 Dapil</div>
                <span style="font-size: 12px; color: #64748b; font-weight: 700;">DPRD Kabupaten Banyumas (50 Kursi)</span>
            </div>
        </div>

        <!-- Dapil Breakdown Table -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <div style="background: #001333; color: #ffffff; padding: 14px 20px;">
                <h3 style="margin: 0; font-size: 16px; font-weight: 800;">Rekapitulasi Teritorial Berdasarkan Daerah Pemilihan (Dapil)</h3>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569;">
                            <th style="padding: 12px 18px; font-weight: 800;">Nama Dapil</th>
                            <th style="padding: 12px 16px; font-weight: 800;">Kecamatan</th>
                            <th style="padding: 12px 16px; font-weight: 800;">DPRt (Desa)</th>
                            <th style="padding: 12px 18px; font-weight: 800; text-align: right;">Jumlah Kader</th>
                            <th style="padding: 12px 18px; font-weight: 800; text-align: right;">Perolehan Suara</th>
                            <th style="padding: 12px 16px; font-weight: 800; text-align: center;">Rasio Suara/Kader</th>
                            <th style="padding: 12px 18px; font-weight: 800; text-align: center;">Status Struktur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dapilStats as $dapil)
                            @php
                                $dapilRatio = round($dapil->total_suara / max(1, $dapil->total_kader), 2);
                            @endphp
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 14px 18px; font-weight: 800; color: #001333;">
                                    <span style="background: rgba(0, 24, 68, 0.08); padding: 3px 8px; border-radius: 4px;">
                                        {{ $dapil->dapil }}
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; font-weight: 700; color: #0f172a;">
                                    {{ $dapil->total_dpc }} Kecamatan
                                </td>
                                <td style="padding: 14px 16px; color: #475569;">
                                    {{ $dapil->total_ranting }} Desa
                                </td>
                                <td style="padding: 14px 18px; font-weight: 800; color: #001844; text-align: right;">
                                    {{ number_format($dapil->total_kader, 0, ',', '.') }}
                                </td>
                                <td style="padding: 14px 18px; font-weight: 900; color: #b45309; text-align: right;">
                                    {{ number_format($dapil->total_suara, 0, ',', '.') }}
                                </td>
                                <td style="padding: 14px 16px; text-align: center;">
                                    <span style="background: rgba(255, 183, 0, 0.15); color: #92400e; font-weight: 800; font-size: 11.5px; padding: 2px 8px; border-radius: 4px; border: 1px solid rgba(255, 183, 0, 0.4);">
                                        {{ $dapilRatio }}x
                                    </span>
                                </td>
                                <td style="padding: 14px 18px; text-align: center;">
                                    <span style="background: rgba(16, 185, 129, 0.12); color: #059669; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                                        ● 100% Terstruktur
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ========================================================
         BAGIAN 2: STATISTIK ANGGOTA
         ======================================================== -->
    <div>
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid rgba(255, 255, 255, 0.15); padding-bottom: 12px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="background: #ffb700; color: #001333; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                    👥
                </div>
                <div>
                    <h2 style="font-size: 22px; font-weight: 900; color: #ffb700; margin: 0;">2. Statistik Keanggotaan &amp; Kader</h2>
                    <span style="font-size: 13px; color: #cbd5e1;">Demografi gender, rentang usia, kepemilikan KTA digital, dan sebaran anggota</span>
                </div>
            </div>
            <span style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 183, 0, 0.4); color: #ffb700; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px;">
                Total: {{ number_format($totalKader, 0, ',', '.') }} Kader
            </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 24px; margin-bottom: 24px;">
            
            <!-- DEMOGRAFI GENDER -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <h3 style="font-size: 16px; font-weight: 900; color: #001333; margin: 0 0 16px 0;">
                    Komposisi Gender Anggota
                </h3>
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                        <span>Laki-laki ({{ round(100 - $persenWanita, 1) }}%)</span>
                        <span style="color: #001333;">{{ number_format($kaderPria, 0, ',', '.') }} Orang</span>
                    </div>
                    <div style="height: 12px; border-radius: 6px; background: #e2e8f0; overflow: hidden;">
                        <div style="height: 100%; width: {{ 100 - $persenWanita }}%; background: #001333; border-radius: 6px;"></div>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                        <span style="color: #b45309;">Perempuan ({{ $persenWanita }}%)</span>
                        <span style="color: #b45309;">{{ number_format($kaderWanita, 0, ',', '.') }} Orang</span>
                    </div>
                    <div style="height: 12px; border-radius: 6px; background: #e2e8f0; overflow: hidden;">
                        <div style="height: 100%; width: {{ $persenWanita }}%; background: #ffb700; border-radius: 6px;"></div>
                    </div>
                </div>

                <div style="background: #fffdf5; border: 1px solid rgba(255,183,0,0.4); border-radius: 8px; padding: 10px 14px; font-size: 12px; color: #92400e;">
                    ✓ <strong>Kuota Keterwakilan Perempuan 30%:</strong> Telah terpenuhi secara konsisten dengan proporsi <strong>{{ $persenWanita }}%</strong>.
                </div>
            </div>

            <!-- DEMOGRAFI USIA -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <h3 style="font-size: 16px; font-weight: 900; color: #001333; margin: 0 0 16px 0;">
                    Distribusi Kelompok Usia Kader
                </h3>
                <div style="margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; margin-bottom: 4px;">
                        <span>Milenial &amp; Gen Z (17 - 35 Tahun)</span>
                        <strong style="color: #10b981;">42% ({{ number_format($usiaGenZ, 0, ',', '.') }} Kader)</strong>
                    </div>
                    <div style="height: 10px; border-radius: 5px; background: #e2e8f0; overflow: hidden;">
                        <div style="height: 100%; width: 42%; background: #10b981;"></div>
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; margin-bottom: 4px;">
                        <span>Dewasa (36 - 50 Tahun)</span>
                        <strong style="color: #001333;">38% ({{ number_format($usiaDewasa, 0, ',', '.') }} Kader)</strong>
                    </div>
                    <div style="height: 10px; border-radius: 5px; background: #e2e8f0; overflow: hidden;">
                        <div style="height: 100%; width: 38%; background: #001333;"></div>
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; margin-bottom: 4px;">
                        <span>Senior (&gt; 50 Tahun)</span>
                        <strong style="color: #64748b;">20% ({{ number_format($usiaSenior, 0, ',', '.') }} Kader)</strong>
                    </div>
                    <div style="height: 10px; border-radius: 5px; background: #e2e8f0; overflow: hidden;">
                        <div style="height: 100%; width: 20%; background: #94a3b8;"></div>
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; font-size: 12px; color: #475569;">
                    Partai NasDem Banyumas didominasi generasi muda produktif untuk mewujudkan politik modern berbasis inovasi.
                </div>
            </div>

        </div>

        <!-- TOP 5 KECAMATAN -->
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 16px; font-weight: 900; color: #001333; margin: 0;">
                    5 Kecamatan dengan Jumlah Kader Terbesar di Banyumas
                </h3>
                <span style="font-size: 12px; color: #64748b;">KTA Digital Terbit: <strong>{{ number_format($ktaVerified, 0, ',', '.') }}</strong></span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                @foreach($topDpc as $idx => $dpc)
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; text-align: center;">
                        <span style="display: inline-block; width: 26px; height: 26px; line-height: 26px; border-radius: 50%; background: #001333; color: #ffb700; font-size: 11px; font-weight: 900; margin-bottom: 6px;">
                            #{{ $idx + 1 }}
                        </span>
                        <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 800; color: #001333;">Kec. {{ $dpc->kecamatan_name }}</h4>
                        <span style="font-size: 11px; color: #64748b; display: block; margin-bottom: 6px;">{{ $dpc->dapil }} • {{ $dpc->total_ranting }} Desa</span>
                        <div style="font-size: 20px; font-weight: 900; color: #10b981;">
                            {{ number_format($dpc->total_kader, 0, ',', '.') }}
                        </div>
                        <span style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Kader Terdaftar</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

        <!-- ========================================================
             BAGIAN 3: GRAFIK & STATISTIK TEPAT JUMLAH KADER & SUARA PARTAI
             27 KECAMATAN SE-KABUPATEN BANYUMAS
             ======================================================== -->
        <div style="margin-top: 50px;" id="sectionGrafik27Kecamatan">
            <!-- Header Bagian 3 -->
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid rgba(255, 255, 255, 0.15); padding-bottom: 14px; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="background: #ffb700; color: #001844; width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 900; box-shadow: 0 4px 14px rgba(255,183,0,0.35);">
                        📊
                    </div>
                    <div>
                        <h2 style="font-size: 22px; font-weight: 900; color: #ffb700; margin: 0; letter-spacing: 0.3px;">
                            3. Grafik Peringkat Kader &amp; Suara Partai 27 Kecamatan se-Kabupaten Banyumas
                        </h2>
                        <span style="font-size: 13px; color: #cbd5e1;">
                            Visualisasi presisi komparasi Jumlah Kader ber-KTA, Perolehan Suara Sah Pemilu, dan Rasio Efektivitas Konversi di 27 DPC Kecamatan
                        </span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <span style="background: rgba(255, 183, 0, 0.15); border: 1.5px solid #ffb700; color: #ffb700; font-size: 12px; font-weight: 800; padding: 6px 14px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                        27 Kecamatan • 331 Desa/Kelurahan • 100% Terstruktur
                    </span>
                </div>
            </div>

            <!-- 4 KPI Metrics Chips: Kader & Suara Presisi -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-bottom: 24px;">
                <!-- Card 1: Juara Kader & Suara -->
                <div style="background: linear-gradient(135deg, #001844 0%, #002877 100%); border: 2px solid #ffb700; border-radius: 12px; padding: 18px 20px; color: #ffffff; box-shadow: 0 8px 20px rgba(0, 24, 68, 0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 11px; font-weight: 900; color: #ffb700; text-transform: uppercase; letter-spacing: 0.5px;">
                            🏆 JUARA KADER &amp; SUARA (#1)
                        </span>
                        <span style="background: #ffb700; color: #001844; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 10px;">DAPIL 6</span>
                    </div>
                    <div style="font-size: 20px; font-weight: 900; color: #ffffff; margin-bottom: 4px;">
                        Kec. {{ $maxSuaraDpc->kecamatan_name ?? 'Cilongok' }}
                    </div>
                    <div style="display: flex; align-items: baseline; gap: 12px; margin-bottom: 4px;">
                        <div>
                            <div style="font-size: 18px; font-weight: 900; color: #ffb700;">
                                {{ number_format($maxSuaraDpc->total_suara ?? 6850, 0, ',', '.') }}
                            </div>
                            <span style="font-size: 10.5px; color: #cbd5e1; text-transform: uppercase;">Suara Sah</span>
                        </div>
                        <div style="border-left: 1px solid rgba(255,255,255,0.2); padding-left: 12px;">
                            <div style="font-size: 18px; font-weight: 900; color: #10b981;">
                                {{ number_format($maxSuaraDpc->total_kader ?? 2140, 0, ',', '.') }}
                            </div>
                            <span style="font-size: 10.5px; color: #cbd5e1; text-transform: uppercase;">Kader KTA</span>
                        </div>
                    </div>
                    <span style="font-size: 11px; color: #94a3b8; display: block;">
                        Rasio Efektivitas: <strong style="color: #ffb700;">{{ $maxSuaraDpc->rasio_suara_kader ?? '3.20' }}x</strong> • 20 DPRt Desa
                    </span>
                </div>

                <!-- Card 2: Total Kader Terdaftar -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        👥 TOTAL KADER SE-BANYUMAS
                    </span>
                    <div style="font-size: 24px; font-weight: 900; color: #001844; margin: 4px 0 2px 0;">
                        {{ number_format($totalKader, 0, ',', '.') }} <span style="font-size: 12px; color: #64748b; font-weight: 600;">Kader</span>
                    </div>
                    <div style="font-size: 12px; color: #10b981; font-weight: 700; margin-bottom: 4px;">
                        ✓ Rata-rata {{ number_format($avgKader, 0, ',', '.') }} kader / kecamatan
                    </div>
                    <span style="font-size: 11px; color: #64748b;">
                        100% Sinkron dengan 331 DPRt Desa/Kelurahan
                    </span>
                </div>

                <!-- Card 3: Total Perolehan Suara -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        🗳️ TOTAL PEROLEHAN SUARA
                    </span>
                    <div style="font-size: 24px; font-weight: 900; color: #b45309; margin: 4px 0 2px 0;">
                        {{ number_format($totalSuara, 0, ',', '.') }} <span style="font-size: 12px; color: #64748b; font-weight: 600;">Suara Sah</span>
                    </div>
                    <div style="font-size: 12px; color: #b45309; font-weight: 700; margin-bottom: 4px;">
                        🎯 Target: {{ number_format($totalTargetSuara, 0, ',', '.') }} (Capaian: {{ $persenTargetKabupaten }}%)
                    </div>
                    <span style="font-size: 11px; color: #64748b;">
                        Rata-rata {{ number_format($avgSuara, 0, ',', '.') }} suara / kecamatan
                    </span>
                </div>

                <!-- Card 4: Rasio Efektivitas Konversi -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        ⚡ RASIO SUARA PER KADER
                    </span>
                    <div style="font-size: 24px; font-weight: 900; color: #0284c7; margin: 4px 0 2px 0;">
                        {{ $rasioKabupaten }}x <span style="font-size: 12px; color: #64748b; font-weight: 600;">Multiplier</span>
                    </div>
                    <div style="font-size: 12px; color: #0369a1; font-weight: 700; margin-bottom: 4px;">
                        Tinggi: 3.20x (Cilongok) • Rendah: 1.40x (Tambak)
                    </div>
                    <span style="font-size: 11px; color: #64748b;">
                        Setiap 1 kader KTA mengonversi {{ $rasioKabupaten }} suara pemilih
                    </span>
                </div>
            </div>

            <!-- Main Chart Card -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(0, 24, 68, 0.06); margin-bottom: 24px;">
                
                <!-- Controls & Filters Toolbar -->
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
                    
                    <!-- Pilihan Metrik Utama (Kader vs Suara vs Komparasi) -->
                    <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <span style="font-size: 12px; font-weight: 900; color: #001844; margin-right: 4px;">Pilih Metrik:</span>
                        <div style="display: flex; background: #f1f5f9; border-radius: 8px; padding: 3px; border: 1px solid #e2e8f0; flex-wrap: wrap; gap: 3px;">
                            <button type="button" id="btnMetricCompare" onclick="setMetricMode('compare', this)" style="background: #001844; color: #ffb700; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer;">
                                📊 Komparasi (Kader vs Suara)
                            </button>
                            <button type="button" id="btnMetricSuara" onclick="setMetricMode('suara', this)" style="background: transparent; color: #475569; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">
                                🗳️ Suara Pemilu
                            </button>
                            <button type="button" id="btnMetricKader" onclick="setMetricMode('kader', this)" style="background: transparent; color: #475569; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">
                                👥 Jumlah Kader
                            </button>
                            <button type="button" id="btnMetricRatio" onclick="setMetricMode('ratio', this)" style="background: transparent; color: #475569; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;">
                                ⚡ Rasio Konversi
                            </button>
                        </div>
                    </div>

                    <!-- Toggle Buttons: Orientasi & View -->
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <!-- Toggle Orientasi (Horizontal / Vertikal) -->
                        <button type="button" id="btnToggleAxis" onclick="toggleAxisOrientation()" style="background: #ffffff; color: #001844; border: 1.5px solid #cbd5e1; padding: 6px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                            🔄 <span id="axisLabel">Mode: Bar Horizontal</span>
                        </button>

                        <!-- Toggle Tab Tampilan: Grafik vs Tabel -->
                        <div style="display: flex; background: #f1f5f9; border-radius: 8px; padding: 3px; border: 1px solid #e2e8f0;">
                            <button type="button" id="tabBtnChart" onclick="switchKecamatanView('chart', this)" style="background: #001844; color: #ffffff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 800; cursor: pointer;">
                                📊 Grafik Visual
                            </button>
                            <button type="button" id="tabBtnTable" onclick="switchKecamatanView('table', this)" style="background: transparent; color: #475569; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                📋 Tabel Rincian
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Filter Dapil Chips Bar -->
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; padding: 10px 14px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <span style="font-size: 11.5px; font-weight: 800; color: #475569; margin-right: 4px;">Filter Dapil:</span>
                        <button type="button" onclick="filterKecamatanDapil('all', this)" class="dapil-filter-chip active" style="background: #001844; color: #ffb700; border: 1.5px solid #001844; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; cursor: pointer;">
                            Semua Dapil (27)
                        </button>
                        <button type="button" onclick="filterKecamatanDapil('Dapil 1', this)" class="dapil-filter-chip" style="background: #ffffff; color: #475569; border: 1.5px solid #cbd5e1; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            Dapil 1 (5)
                        </button>
                        <button type="button" onclick="filterKecamatanDapil('Dapil 2', this)" class="dapil-filter-chip" style="background: #ffffff; color: #475569; border: 1.5px solid #cbd5e1; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            Dapil 2 (4)
                        </button>
                        <button type="button" onclick="filterKecamatanDapil('Dapil 3', this)" class="dapil-filter-chip" style="background: #ffffff; color: #475569; border: 1.5px solid #cbd5e1; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            Dapil 3 (6)
                        </button>
                        <button type="button" onclick="filterKecamatanDapil('Dapil 4', this)" class="dapil-filter-chip" style="background: #ffffff; color: #475569; border: 1.5px solid #cbd5e1; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            Dapil 4 (4)
                        </button>
                        <button type="button" onclick="filterKecamatanDapil('Dapil 5', this)" class="dapil-filter-chip" style="background: #ffffff; color: #475569; border: 1.5px solid #cbd5e1; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            Dapil 5 (4)
                        </button>
                        <button type="button" onclick="filterKecamatanDapil('Dapil 6', this)" class="dapil-filter-chip" style="background: #ffffff; color: #475569; border: 1.5px solid #cbd5e1; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; cursor: pointer;">
                            Dapil 6 (4)
                        </button>
                    </div>

                    <div style="font-size: 11.5px; color: #64748b;">
                        Menampilkan <strong id="chartCountInfo" style="color: #001844;">27 Kecamatan</strong>
                    </div>
                </div>

                <!-- CHART VIEW CONTAINER -->
                <div id="kecamatanChartWrapper" style="position: relative; width: 100%;">
                    <!-- Subheader Info di atas kanvas -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                        <div id="chartSubTitleText" style="font-size: 12px; color: #475569; font-weight: 600;">
                            Komparasi Jumlah Kader ber-KTA (Biru Tua) vs Perolehan Suara Sah Pemilu (Emas NasDem)
                        </div>
                        
                        <!-- Legenda Grafik Komparasi -->
                        <div id="chartLegendBox" style="display: flex; align-items: center; gap: 14px; font-size: 11.5px; font-weight: 700; color: #475569;">
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <span style="width: 12px; height: 12px; border-radius: 3px; background: #001844; display: inline-block;"></span>
                                Jumlah Kader (KTA)
                            </span>
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <span style="width: 12px; height: 12px; border-radius: 3px; background: #ffb700; display: inline-block;"></span>
                                Perolehan Suara Sah
                            </span>
                        </div>
                    </div>

                    <!-- Canvas Chart.js -->
                    <div id="canvasContainer" style="position: relative; height: 800px; width: 100%;">
                        <canvas id="kader27KecamatanChart"></canvas>
                    </div>
                </div>

                <!-- TABLE VIEW CONTAINER (Hidden default, toggleable) -->
                <div id="kecamatanTableWrapper" style="display: none;">
                    <div style="overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 10px;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12.5px;">
                            <thead>
                                <tr style="background: #001844; color: #ffffff;">
                                    <th style="padding: 12px 14px; font-weight: 800; width: 60px; text-align: center;">Rank</th>
                                    <th style="padding: 12px 16px; font-weight: 800;">Kecamatan</th>
                                    <th style="padding: 12px 14px; font-weight: 800;">Dapil</th>
                                    <th style="padding: 12px 14px; font-weight: 800; text-align: center;">DPRt (Desa)</th>
                                    <th style="padding: 12px 16px; font-weight: 800; text-align: right;">Jumlah Kader (KTA)</th>
                                    <th style="padding: 12px 16px; font-weight: 800; text-align: right;">Perolehan Suara</th>
                                    <th style="padding: 12px 14px; font-weight: 800; text-align: center;">Rasio Suara/Kader</th>
                                    <th style="padding: 12px 16px; font-weight: 800; min-width: 180px;">Proporsi Suara vs Kader</th>
                                    <th style="padding: 12px 14px; font-weight: 800; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="kecamatanTableBody">
                                @foreach($allDpc as $idx => $dpc)
                                    @php
                                        $maxSuaraVal = $maxSuaraDpc->total_suara ?: 1;
                                        $pctSuara = round(($dpc->total_suara / $maxSuaraVal) * 100, 1);
                                        $pctKader = round(($dpc->total_kader / ($maxDpc->total_kader ?: 1)) * 100, 1);
                                        $ratioVal = $dpc->rasio_suara_kader;
                                    @endphp
                                    <tr style="border-bottom: 1px solid #e2e8f0; background: {{ $idx % 2 === 0 ? '#ffffff' : '#f8fafc' }};" class="table-row-dpc" data-dapil="{{ $dpc->dapil }}">
                                        <td style="padding: 12px 14px; text-align: center; font-weight: 900;">
                                            @if($idx === 0)
                                                <span style="display: inline-block; background: #ffb700; color: #001844; width: 26px; height: 26px; line-height: 26px; border-radius: 50%; font-size: 11px;">🥇</span>
                                            @elseif($idx === 1)
                                                <span style="display: inline-block; background: #e2e8f0; color: #0f172a; width: 26px; height: 26px; line-height: 26px; border-radius: 50%; font-size: 11px;">🥈</span>
                                            @elseif($idx === 2)
                                                <span style="display: inline-block; background: #fed7aa; color: #9a3412; width: 26px; height: 26px; line-height: 26px; border-radius: 50%; font-size: 11px;">🥉</span>
                                            @else
                                                <span style="color: #64748b; font-size: 12px;">#{{ $idx + 1 }}</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px 16px; font-weight: 800; color: #001844;">
                                            Kec. {{ $dpc->kecamatan_name }}
                                        </td>
                                        <td style="padding: 12px 14px;">
                                            <span style="background: rgba(0, 24, 68, 0.08); color: #001844; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 4px;">
                                                {{ $dpc->dapil }}
                                            </span>
                                        </td>
                                        <td style="padding: 12px 14px; text-align: center; color: #475569; font-weight: 600;">
                                            {{ $dpc->total_ranting }} Desa
                                        </td>
                                        <td style="padding: 12px 16px; text-align: right; font-weight: 800; color: #001844; font-size: 13.5px;">
                                            {{ number_format($dpc->total_kader, 0, ',', '.') }}
                                        </td>
                                        <td style="padding: 12px 16px; text-align: right; font-weight: 900; color: #b45309; font-size: 14px;">
                                            {{ number_format($dpc->total_suara, 0, ',', '.') }}
                                        </td>
                                        <td style="padding: 12px 14px; text-align: center;">
                                            <span style="background: {{ $ratioVal >= 2.5 ? 'rgba(16,185,129,0.15)' : 'rgba(255,183,0,0.15)' }}; color: {{ $ratioVal >= 2.5 ? '#065f46' : '#92400e' }}; font-weight: 900; font-size: 11.5px; padding: 3px 8px; border-radius: 6px; border: 1px solid {{ $ratioVal >= 2.5 ? 'rgba(16,185,129,0.3)' : 'rgba(255,183,0,0.4)' }};">
                                                {{ $ratioVal }}x
                                            </span>
                                        </td>
                                        <td style="padding: 12px 16px;">
                                            <div style="margin-bottom: 4px;">
                                                <div style="display: flex; justify-content: space-between; font-size: 10px; font-weight: 700; color: #64748b; margin-bottom: 2px;">
                                                    <span>Suara: {{ $pctSuara }}%</span>
                                                    <span>Kader: {{ $pctKader }}%</span>
                                                </div>
                                                <div style="height: 6px; border-radius: 3px; background: #e2e8f0; overflow: hidden; display: flex;">
                                                    <div style="height: 100%; width: {{ $pctSuara }}%; background: #ffb700;"></div>
                                                </div>
                                                <div style="height: 4px; border-radius: 2px; background: #e2e8f0; overflow: hidden; margin-top: 2px;">
                                                    <div style="height: 100%; width: {{ $pctKader }}%; background: #001844;"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 12px 14px; text-align: center;">
                                            <a href="{{ route('admin.dpc', ['search' => $dpc->kecamatan_name]) }}" style="background: #f1f5f9; color: #001844; text-decoration: none; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 800; border: 1px solid #cbd5e1; display: inline-block;">
                                                Detail →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="{{ asset('js/chart.umd.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data Master 27 DPC Kecamatan dari Controller
        const rawDpcList = @json($allDpc);
        const totalKaderGlobal = {{ $totalKader ?: 36920 }};
        const totalSuaraGlobal = {{ $totalSuara ?: 73630 }};

        // State Grafik
        let currentMetric = 'compare'; // 'compare', 'suara', 'kader', 'ratio'
        let currentDapilFilter = 'all';
        let currentAxisOrientation = 'y'; // 'y' = horizontal, 'x' = vertikal
        let chartInstance = null;

        function getFilteredData() {
            let data = currentDapilFilter === 'all'
                ? rawDpcList.slice()
                : rawDpcList.filter(item => item.dapil === currentDapilFilter);

            // Sorting sesuai metrik yang dipilih
            if (currentMetric === 'suara') {
                data.sort((a, b) => b.total_suara - a.total_suara);
            } else if (currentMetric === 'kader') {
                data.sort((a, b) => b.total_kader - a.total_kader);
            } else if (currentMetric === 'ratio') {
                data.sort((a, b) => (b.total_suara / (b.total_kader || 1)) - (a.total_suara / (a.total_kader || 1)));
            } else {
                // 'compare' diurutkan berdasarkan perolehan suara terbanyak
                data.sort((a, b) => b.total_suara - a.total_suara);
            }

            return data;
        }

        function updateChart() {
            const dataItems = getFilteredData();
            const labels = dataItems.map(item => 'Kec. ' + item.kecamatan_name);
            const kaderValues = dataItems.map(item => item.total_kader);
            const suaraValues = dataItems.map(item => item.total_suara);
            const ratioValues = dataItems.map(item => Number((item.total_suara / (item.total_kader || 1)).toFixed(2)));

            // Update info counter
            const countInfo = document.getElementById('chartCountInfo');
            if (countInfo) {
                countInfo.textContent = currentDapilFilter === 'all' 
                    ? '27 Kecamatan' 
                    : `${dataItems.length} Kecamatan (${currentDapilFilter})`;
            }

            // Atur dinamis tinggi kanvas container
            const container = document.getElementById('canvasContainer');
            if (currentAxisOrientation === 'y') {
                const perItemHeight = currentMetric === 'compare' ? 36 : 28;
                const calculatedHeight = Math.max(450, dataItems.length * perItemHeight + 60);
                container.style.height = calculatedHeight + 'px';
            } else {
                container.style.height = '480px';
            }

            // Buat dataset berdasarkan mode
            let datasets = [];
            const subTitle = document.getElementById('chartSubTitleText');
            const legendBox = document.getElementById('chartLegendBox');

            if (currentMetric === 'compare') {
                if (subTitle) subTitle.textContent = 'Komparasi Berdampingan: Jumlah Kader ber-KTA (Biru Tua) vs Perolehan Suara Sah Pemilu (Emas NasDem)';
                if (legendBox) {
                    legendBox.innerHTML = `
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="width: 12px; height: 12px; border-radius: 3px; background: #001844; display: inline-block;"></span>
                            Jumlah Kader (KTA)
                        </span>
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="width: 12px; height: 12px; border-radius: 3px; background: #ffb700; display: inline-block;"></span>
                            Perolehan Suara Sah
                        </span>
                    `;
                }

                datasets = [
                    {
                        label: 'Perolehan Suara Sah',
                        data: suaraValues,
                        backgroundColor: '#ffb700',
                        borderColor: '#d97706',
                        borderWidth: 1.2,
                        borderRadius: currentAxisOrientation === 'y' ? 4 : 4,
                        maxBarThickness: currentAxisOrientation === 'y' ? 16 : 24,
                    },
                    {
                        label: 'Jumlah Kader (KTA)',
                        data: kaderValues,
                        backgroundColor: '#001844',
                        borderColor: '#000c22',
                        borderWidth: 1.2,
                        borderRadius: currentAxisOrientation === 'y' ? 4 : 4,
                        maxBarThickness: currentAxisOrientation === 'y' ? 16 : 24,
                    }
                ];
            } else if (currentMetric === 'suara') {
                if (subTitle) subTitle.textContent = 'Peringkat 27 Kecamatan Berdasarkan Perolehan Suara Sah Pemilu Terbanyak';
                if (legendBox) {
                    legendBox.innerHTML = `
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="width: 12px; height: 12px; border-radius: 3px; background: #ffb700; display: inline-block;"></span>
                            Perolehan Suara Sah Pemilu
                        </span>
                    `;
                }

                const colors = dataItems.map((item, idx) => {
                    if (idx === 0) return '#ffb700'; // Juara 1
                    if (idx < 3) return '#f59e0b';
                    if (idx < 10) return '#2563eb';
                    return '#001844';
                });

                datasets = [{
                    label: 'Perolehan Suara Sah',
                    data: suaraValues,
                    backgroundColor: colors,
                    borderColor: '#001844',
                    borderWidth: 1.2,
                    borderRadius: currentAxisOrientation === 'y' ? 5 : 4,
                    maxBarThickness: currentAxisOrientation === 'y' ? 22 : 32,
                }];
            } else if (currentMetric === 'kader') {
                if (subTitle) subTitle.textContent = 'Peringkat 27 Kecamatan Berdasarkan Jumlah Kader Terdaftar (KTA) Terbanyak';
                if (legendBox) {
                    legendBox.innerHTML = `
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="width: 12px; height: 12px; border-radius: 3px; background: #10b981; display: inline-block;"></span>
                            Jumlah Kader Terdaftar (KTA)
                        </span>
                    `;
                }

                const colors = dataItems.map((item, idx) => {
                    if (idx === 0) return '#10b981';
                    if (idx < 3) return '#059669';
                    if (idx < 10) return '#2563eb';
                    return '#001844';
                });

                datasets = [{
                    label: 'Jumlah Kader (KTA)',
                    data: kaderValues,
                    backgroundColor: colors,
                    borderColor: '#001844',
                    borderWidth: 1.2,
                    borderRadius: currentAxisOrientation === 'y' ? 5 : 4,
                    maxBarThickness: currentAxisOrientation === 'y' ? 22 : 32,
                }];
            } else if (currentMetric === 'ratio') {
                if (subTitle) subTitle.textContent = 'Peringkat Efektivitas Konversi: Rasio Perolehan Suara per 1 Kader Aktif';
                if (legendBox) {
                    legendBox.innerHTML = `
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <span style="width: 12px; height: 12px; border-radius: 3px; background: #0284c7; display: inline-block;"></span>
                            Rasio Suara per Kader (Multiplier)
                        </span>
                    `;
                }

                const colors = ratioValues.map(r => r >= 2.5 ? '#10b981' : (r >= 2.0 ? '#0284c7' : '#001844'));

                datasets = [{
                    label: 'Rasio Suara per Kader (x)',
                    data: ratioValues,
                    backgroundColor: colors,
                    borderColor: '#001844',
                    borderWidth: 1.2,
                    borderRadius: currentAxisOrientation === 'y' ? 5 : 4,
                    maxBarThickness: currentAxisOrientation === 'y' ? 20 : 30,
                }];
            }

            if (chartInstance) {
                chartInstance.destroy();
            }

            const ctx = document.getElementById('kader27KecamatanChart').getContext('2d');

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    indexAxis: currentAxisOrientation,
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 600,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: currentMetric === 'compare',
                            position: 'top',
                            labels: {
                                font: { size: 12, weight: '700' },
                                color: '#001844',
                                boxWidth: 14
                            }
                        },
                        tooltip: {
                            backgroundColor: '#001333',
                            titleColor: '#ffb700',
                            bodyColor: '#ffffff',
                            titleFont: { size: 13, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            boxPadding: 6,
                            cornerRadius: 8,
                            borderColor: '#ffb700',
                            borderWidth: 1.5,
                            callbacks: {
                                title: function(contexts) {
                                    const idx = contexts[0].dataIndex;
                                    const item = dataItems[idx];
                                    return `#${idx + 1} Kec. ${item.kecamatan_name} (${item.dapil})`;
                                },
                                label: function(context) {
                                    const raw = Number(context.raw);
                                    if (currentMetric === 'ratio') {
                                        return ` Rasio Efektivitas: ${raw}x suara per kader`;
                                    }
                                    return ` ${context.dataset.label}: ${raw.toLocaleString('id-ID')} orang/suara`;
                                },
                                afterBody: function(contexts) {
                                    const idx = contexts[0].dataIndex;
                                    const item = dataItems[idx];
                                    const ratio = (item.total_suara / (item.total_kader || 1)).toFixed(2);
                                    const lines = [
                                        `• Total Kader: ${Number(item.total_kader).toLocaleString('id-ID')} orang`,
                                        `• Perolehan Suara: ${Number(item.total_suara).toLocaleString('id-ID')} suara`,
                                        `• Multiplier: ${ratio}x suara per kader`,
                                        `• Struktur: ${item.total_ranting} DPRt Desa/Kelurahan`
                                    ];
                                    return lines;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(226, 232, 240, 0.7)',
                                drawBorder: false
                            },
                            ticks: {
                                font: { size: 11, weight: '600' },
                                color: '#475569',
                                callback: function(value) {
                                    return currentAxisOrientation === 'y' 
                                        ? Number(value).toLocaleString('id-ID')
                                        : (this.getLabelForValue(value).length > 10 ? this.getLabelForValue(value).substring(0, 10) + '..' : this.getLabelForValue(value));
                                },
                                maxRotation: currentAxisOrientation === 'x' ? 45 : 0,
                                minRotation: currentAxisOrientation === 'x' ? 45 : 0,
                            }
                        },
                        y: {
                            grid: {
                                display: currentAxisOrientation === 'x',
                                color: 'rgba(226, 232, 240, 0.7)',
                                drawBorder: false
                            },
                            ticks: {
                                font: { size: 11, weight: '700' },
                                color: '#001844',
                                callback: function(value) {
                                    return currentAxisOrientation === 'x' 
                                        ? Number(value).toLocaleString('id-ID')
                                        : this.getLabelForValue(value);
                                }
                            }
                        }
                    }
                }
            });
        }

        // Global Handlers
        window.setMetricMode = function(metric, btn) {
            currentMetric = metric;

            const btnCompare = document.getElementById('btnMetricCompare');
            const btnSuara = document.getElementById('btnMetricSuara');
            const btnKader = document.getElementById('btnMetricKader');
            const btnRatio = document.getElementById('btnMetricRatio');

            [btnCompare, btnSuara, btnKader, btnRatio].forEach(b => {
                if (b) {
                    b.style.background = 'transparent';
                    b.style.color = '#475569';
                }
            });

            if (btn) {
                btn.style.background = '#001844';
                btn.style.color = '#ffb700';
            }

            updateChart();
        };

        window.filterKecamatanDapil = function(dapil, btn) {
            currentDapilFilter = dapil;
            
            // Perbarui tombol aktif
            document.querySelectorAll('.dapil-filter-chip').forEach(b => {
                b.style.background = '#ffffff';
                b.style.color = '#475569';
                b.style.borderColor = '#cbd5e1';
                b.classList.remove('active');
            });
            if (btn) {
                btn.style.background = '#001844';
                btn.style.color = '#ffb700';
                btn.style.borderColor = '#001844';
                btn.classList.add('active');
            }

            // Perbarui tabel data bila sedang dibuka
            document.querySelectorAll('.table-row-dpc').forEach(row => {
                if (dapil === 'all' || row.dataset.dapil === dapil) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            updateChart();
        };

        window.toggleAxisOrientation = function() {
            currentAxisOrientation = currentAxisOrientation === 'y' ? 'x' : 'y';
            const label = document.getElementById('axisLabel');
            if (label) {
                label.textContent = currentAxisOrientation === 'y' 
                    ? 'Mode: Bar Horizontal' 
                    : 'Mode: Bar Vertikal';
            }
            updateChart();
        };

        window.switchKecamatanView = function(view, btn) {
            const chartWrap = document.getElementById('kecamatanChartWrapper');
            const tableWrap = document.getElementById('kecamatanTableWrapper');
            const tabChart = document.getElementById('tabBtnChart');
            const tabTable = document.getElementById('tabBtnTable');

            if (view === 'chart') {
                chartWrap.style.display = 'block';
                tableWrap.style.display = 'none';
                tabChart.style.background = '#001844';
                tabChart.style.color = '#ffffff';
                tabTable.style.background = 'transparent';
                tabTable.style.color = '#475569';
                if (chartInstance) chartInstance.resize();
            } else {
                chartWrap.style.display = 'none';
                tableWrap.style.display = 'block';
                tabTable.style.background = '#001844';
                tabTable.style.color = '#ffffff';
                tabChart.style.background = 'transparent';
                tabChart.style.color = '#475569';
            }
        };

        // Inisialisasi awal grafik
        updateChart();
    });
</script>
@endpush

@endsection
