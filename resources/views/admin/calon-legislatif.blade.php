@extends('layouts.app')

@section('title', 'Calon Legislatif – DPD Partai NasDem Kabupaten Banyumas')

@section('content')

<style>
    /* ========================================================
       PERBAIKAN WARNA TEKS MODAL & FORM CALEG
       ======================================================== */
    #createCalegModal input,
    #createCalegModal select,
    #createCalegModal textarea,
    #editCalegModal input,
    #editCalegModal select,
    #editCalegModal textarea,
    form[action*="calon-legislatif"] input,
    form[action*="calon-legislatif"] select {
        color: #0f172a !important;
        -webkit-text-fill-color: #0f172a !important;
        background-color: #ffffff !important;
        font-weight: 600 !important;
    }

    #createCalegModal select option,
    #editCalegModal select option,
    form[action*="calon-legislatif"] select option,
    select option {
        color: #0f172a !important;
        -webkit-text-fill-color: #0f172a !important;
        background-color: #ffffff !important;
        font-weight: 600 !important;
    }

    #createCalegModal label,
    #editCalegModal label {
        color: #0f172a !important;
        font-weight: 700 !important;
    }

    #createCalegModal input::placeholder,
    #editCalegModal input::placeholder,
    #createCalegModal textarea::placeholder,
    #editCalegModal textarea::placeholder {
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
                <span style="color: #94a3b8; font-size: 13px;">Badan Pemenangan Pemilu (Bappilu)</span>
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: #ffffff; margin: 0 0 6px 0;">
                Calon Legislatif <span style="color: #ffb700;">Partai NasDem Banyumas</span>
            </h1>
            <p style="font-size: 14px; color: #cbd5e1; margin: 0;">
                Profil lengkap, nomor urut, target suara, dan pemetaan basis wilayah 50 Calon Anggota DPRD Kabupaten Banyumas.
            </p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.statistik') }}" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 9px 14px;">
                ← Ke Statistik
            </a>
            <button type="button" onclick="openCreateCalegModal()" class="btn-yellow" style="border: none; cursor: pointer; font-size: 13px; padding: 9px 18px; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                + Tambah Calon Legislatif
            </button>
            <a href="{{ route('admin.berita') }}" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 9px 14px;">
                Ke Berita →
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

    <!-- ========================================================
         SUMMARY KPI CARDS
         ======================================================== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px; margin-bottom: 30px;">
        {{-- Total Caleg --}}
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase;">Total Caleg DPRD</span>
                <span style="background: #eff6ff; color: #1e40af; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 4px;">6 DAPIL</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 4px 0;">
                {{ $totalCandidates }} <span style="font-size: 18px; color: #64748b; font-weight: 700;">Calon</span>
            </div>
            <span style="font-size: 12px; color: #10b981; font-weight: 700;">
                ✓ 100% Kuota Terisi Lengkap di Seluruh Dapil
            </span>
        </div>

        {{-- Keterwakilan Perempuan --}}
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase;">Keterwakilan Perempuan</span>
                <span style="background: #fdf2f8; color: #be185d; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 4px;">KPU > 30%</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #be185d; margin: 4px 0;">
                {{ $persenWanita }}% <span style="font-size: 16px; color: #64748b; font-weight: 700;">({{ $totalWanita }} Perempuan)</span>
            </div>
            <span style="font-size: 12px; color: #059669; font-weight: 700;">
                ✓ {{ $totalPria }} Laki-laki • Memenuhi Regulasi Afirmasi
            </span>
        </div>

        {{-- Akumulasi Target Suara --}}
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase;">Target Akumulasi Suara</span>
                <span style="background: #fef3c7; color: #92400e; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 4px;">BAPPILU</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 4px 0;">
                {{ number_format($totalTargetSuara, 0, ',', '.') }}
            </div>
            <span style="font-size: 12px; color: #0284c7; font-weight: 700;">
                Rata-rata Target: {{ number_format(round($totalTargetSuara / max(1, $totalCandidates)), 0, ',', '.') }} suara/caleg
            </span>
        </div>

        {{-- Potensi Lolos / Caleg Terpilih --}}
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 800; text-transform: uppercase;">Suara Masuk / Terpilih</span>
                <span style="background: #ecfdf5; color: #065f46; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 4px;">ESTIMASI</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #ffb700; margin: 4px 0;">
                {{ $totalTerpilih }} <span style="font-size: 18px; color: #001333;">Kursi Terpilih</span>
            </div>
            <span style="font-size: 12px; color: #10b981; font-weight: 700;">
                {{ number_format($totalSuaraMasuk, 0, ',', '.') }} Suara Sah Masuk
            </span>
        </div>
    </div>

    <!-- ========================================================
         DAPIL NAV TABS & QUICK FILTERS
         ======================================================== -->
    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
        <a href="{{ route('admin.calon-legislatif') }}" style="text-decoration: none; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 800; transition: all 0.15s ease; {{ !request('dapil') || request('dapil') === 'all' ? 'background: #001333; color: #ffb700; box-shadow: 0 4px 10px rgba(0, 19, 51, 0.2);' : 'background: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
            🌟 Semua Dapil ({{ $totalCandidates }})
        </a>
        @foreach($dapilList as $d)
            @php
                $isActive = request('dapil') === $d;
                $st = $dapilStats[$d] ?? ['count' => 0];
            @endphp
            <a href="{{ route('admin.calon-legislatif', array_merge(request()->query(), ['dapil' => $d])) }}" style="text-decoration: none; padding: 9px 16px; border-radius: 8px; font-size: 13px; font-weight: 800; transition: all 0.15s ease; {{ $isActive ? 'background: #001333; color: #ffb700; box-shadow: 0 4px 10px rgba(0, 19, 51, 0.2);' : 'background: #ffffff; color: #475569; border: 1px solid #cbd5e1;' }}">
                {{ $d }} <span style="font-size: 11px; opacity: 0.85; margin-left: 4px;">({{ $st['count'] }})</span>
            </a>
        @endforeach
    </div>

    <!-- ========================================================
         FILTER & SEARCH BAR
         ======================================================== -->
    <form action="{{ route('admin.calon-legislatif') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center; background: #ffffff; padding: 16px; border-radius: 10px; border: 1.5px solid #e2e8f0; box-shadow: 0 2px 6px rgba(0,0,0,0.02); margin-bottom: 25px;">
        @if(request('dapil') && request('dapil') !== 'all')
            <input type="hidden" name="dapil" value="{{ request('dapil') }}">
        @endif

        <div style="flex: 1; min-width: 240px;">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama caleg, gelar, nomor urut, jabatan, atau basis wilayah..." style="width: 100%; padding: 9px 14px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
        </div>

        <div style="min-width: 140px;">
            <select name="gender" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                <option value="all" style="color: #0f172a; background-color: #ffffff;">Semua Gender</option>
                <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }} style="color: #0f172a; background-color: #ffffff;">Laki-laki</option>
                <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }} style="color: #0f172a; background-color: #ffffff;">Perempuan</option>
            </select>
        </div>

        <div style="min-width: 150px;">
            <select name="status" style="width: 100%; padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                <option value="all" style="color: #0f172a; background-color: #ffffff;">Semua Status</option>
                <option value="DCT" {{ request('status') === 'DCT' ? 'selected' : '' }} style="color: #0f172a; background-color: #ffffff;">DCT (Calon Tetap)</option>
                <option value="Caleg Terpilih" {{ request('status') === 'Caleg Terpilih' ? 'selected' : '' }} style="color: #0f172a; background-color: #ffffff;">Caleg Terpilih</option>
                <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }} style="color: #0f172a; background-color: #ffffff;">Aktif</option>
            </select>
        </div>

        <button type="submit" class="admin-btn admin-btn-navy" style="padding: 9px 18px; font-size: 13px; font-weight: 800; cursor: pointer; border: none; border-radius: 6px; background: #001333; color: #ffb700;">
            Cari Caleg
        </button>

        @if(request()->anyFilled(['q', 'gender', 'status', 'dapil']))
            <a href="{{ route('admin.calon-legislatif') }}" class="admin-btn admin-btn-light" style="padding: 9px 14px; text-decoration: none; font-size: 13px;">
                Reset Filter
            </a>
        @endif
    </form>

    <!-- ========================================================
         CALEG GRID CARDS
         ======================================================== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
        @forelse($candidates as $c)
            @php
                $pct = $c->percentage;
                $isElected = $c->status === 'Caleg Terpilih';
            @endphp
            <div style="background: #ffffff; border: {{ $isElected ? '2px solid #ffb700' : '1.5px solid #e2e8f0' }}; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.04); display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.04)';">
                
                {{-- Card Top Banner --}}
                <div style="background: {{ $isElected ? 'linear-gradient(135deg, #001333 0%, #002b66 100%)' : '#001333' }}; padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid {{ $isElected ? '#ffb700' : 'rgba(255, 183, 0, 0.4)' }};">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="background: #ffb700; color: #001333; font-weight: 900; font-size: 13px; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                            {{ $c->nomor_urut }}
                        </span>
                        <div>
                            <span style="color: #cbd5e1; font-size: 11px; font-weight: 700; text-transform: uppercase;">{{ $c->dapil }}</span>
                            <span style="display: block; color: #ffffff; font-size: 11.5px; font-weight: 800;">{{ $c->tingkat }}</span>
                        </div>
                    </div>

                    <div>
                        @if($isElected)
                            <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 8px rgba(255, 183, 0, 0.4);">
                                🌟 Terpilih
                            </span>
                        @else
                            <span style="background: rgba(255, 255, 255, 0.15); color: #cbd5e1; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 4px;">
                                {{ $c->status }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Card Body --}}
                <div style="padding: 18px 18px 14px; flex: 1; display: flex; flex-direction: column;">
                    <div style="display: flex; gap: 14px; align-items: flex-start; margin-bottom: 12px;">
                        {{-- Photo --}}
                        <div style="width: 70px; height: 85px; border-radius: 8px; overflow: hidden; background: #001333; flex-shrink: 0; border: 2px solid {{ $isElected ? '#ffb700' : '#e2e8f0' }}; box-shadow: 0 3px 8px rgba(0,0,0,0.1); position: relative;">
                            @if($c->foto)
                                <img src="{{ asset($c->foto) }}" alt="{{ $c->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(180deg, #001f4d 0%, #000c22 100%); color: #ffb700;">
                                    <span style="font-size: 26px;">👤</span>
                                    <span style="font-size: 9px; font-weight: 800; color: #cbd5e1;">NASDEM</span>
                                </div>
                            @endif
                        </div>

                        {{-- Main Info --}}
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 3px;">
                                @if($c->jenis_kelamin === 'P')
                                    <span style="background: #fdf2f8; color: #db2777; border: 1px solid #fbcfe8; font-size: 10px; font-weight: 800; padding: 1px 6px; border-radius: 4px;">
                                        ♀ Perempuan
                                    </span>
                                @else
                                    <span style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; font-size: 10px; font-weight: 800; padding: 1px 6px; border-radius: 4px;">
                                        ♂ Laki-laki
                                    </span>
                                @endif
                                @if($c->pendidikan_terakhir)
                                    <span style="background: #f1f5f9; color: #475569; font-size: 10px; font-weight: 700; padding: 1px 5px; border-radius: 4px;">
                                        {{ $c->pendidikan_terakhir }}
                                    </span>
                                @endif
                            </div>

                            <h3 style="font-size: 15.5px; font-weight: 900; color: #001333; margin: 0 0 4px 0; line-height: 1.3;">
                                {{ $c->nama }}
                            </h3>

                            @if($c->jabatan)
                                <p style="font-size: 12px; color: #64748b; margin: 0 0 4px; font-weight: 600;">
                                    {{ $c->jabatan }}
                                </p>
                            @endif

                            @if($c->basis_wilayah)
                                <span style="font-size: 11.5px; color: #0369a1; display: flex; align-items: center; gap: 4px; font-weight: 700;">
                                    📍 Basis: {{ $c->basis_wilayah }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Slogan --}}
                    @if($c->slogan)
                        <div style="background: #f8fafc; border-left: 3px solid #ffb700; padding: 6px 10px; border-radius: 0 6px 6px 0; margin-bottom: 12px; font-size: 11.5px; font-style: italic; color: #475569;">
                            "{{ $c->slogan }}"
                        </div>
                    @endif

                    {{-- Target & Suara Masuk --}}
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; margin-top: auto; margin-bottom: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                            <span style="font-size: 11px; color: #64748b; font-weight: 700;">PROGRES SUARA MASUK</span>
                            <div>
                                <strong style="font-size: 14px; color: #001333;">{{ number_format($c->suara_masuk, 0, ',', '.') }}</strong>
                                <span style="font-size: 11px; color: #94a3b8;">/ {{ number_format($c->target_suara, 0, ',', '.') }} target</span>
                            </div>
                        </div>

                        <div style="width: 100%; height: 7px; background: #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 4px;">
                            <div style="width: {{ $pct }}%; height: 100%; background: {{ $isElected ? '#ffb700' : '#001333' }}; border-radius: 4px;"></div>
                        </div>

                        <div style="display: flex; justify-content: space-between; font-size: 10.5px; color: #64748b;">
                            <span>Pencapaian Target</span>
                            <strong style="color: {{ $pct >= 80 ? '#059669' : '#0284c7' }};">{{ $pct }}%</strong>
                        </div>
                    </div>

                    @if($c->phone)
                        <div style="font-size: 11.5px; margin-bottom: 6px;">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c->phone) }}" target="_blank" style="text-decoration: none; color: #10b981; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                📱 Hubungi Tim: {{ $c->phone }}
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Card Actions Footer --}}
                <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 10px 16px; display: flex; justify-content: space-between; align-items: center;">
                    <button type="button" onclick="toggleElectedCandidate({{ $c->id }})" title="Klik untuk ubah status terpilih" style="background: {{ $isElected ? '#fef3c7' : '#ffffff' }}; color: {{ $isElected ? '#b45309' : '#64748b' }}; border: 1px solid {{ $isElected ? '#fcd34d' : '#cbd5e1' }}; padding: 5px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                        {{ $isElected ? '⭐ Batal Terpilih' : '☆ Tandai Terpilih' }}
                    </button>

                    <div style="display: flex; gap: 6px;">
                        <button type="button" onclick="openEditCalegModal({{ json_encode($c) }})" title="Edit Calon Legislatif" style="background: #001333; color: #ffb700; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer;">
                            ✏️ Edit
                        </button>
                        <button type="button" onclick="confirmDeleteCaleg({{ $c->id }}, '{{ addslashes($c->nama) }}')" title="Hapus Calon Legislatif" style="background: #fee2e2; color: #dc2626; border: none; padding: 6px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer;">
                            🗑️
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div style="grid-column: 1 / -1; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 40px; text-align: center; color: #64748b;">
                <div style="font-size: 36px; margin-bottom: 10px;">👥</div>
                <h3 style="font-size: 16px; font-weight: 800; color: #001333; margin: 0 0 6px;">Tidak ada calon legislatif yang cocok dengan filter</h3>
                <p style="font-size: 13px; margin: 0 0 16px;">Silakan atur ulang filter pencarian atau tambahkan calon legislatif baru.</p>
                <button type="button" onclick="openCreateCalegModal()" class="btn-yellow" style="border: none; padding: 8px 18px; border-radius: 6px; font-weight: 800; cursor: pointer;">
                    + Tambah Calon Legislatif Baru
                </button>
            </div>
        @endforelse
    </div>

</div>

<!-- ========================================================
     MODAL 1: TAMBAH CALEG BARU
     ======================================================== -->
<div id="createCalegModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeCreateCalegModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>

    <div style="position: relative; background: #ffffff; width: 100%; max-width: 650px; border-radius: 14px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); max-height: 90vh; display: flex; flex-direction: column;">
        <div style="background: #001333; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ffb700;">
            <h3 style="margin: 0; font-size: 17px; font-weight: 900; color: #ffb700;">👤 Tambah Calon Legislatif Baru</h3>
            <button type="button" onclick="closeCreateCalegModal()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('admin.calon-legislatif.store') }}" method="POST" enctype="multipart/form-data" style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px;">
            @csrf
            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Nama Lengkap &amp; Gelar *</label>
                <input type="text" name="nama" required placeholder="Contoh: Dr. H. Edris Santoso, S.E., M.M." style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Daerah Pemilihan (Dapil) *</label>
                    <select name="dapil" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        @foreach(['Dapil 1', 'Dapil 2', 'Dapil 3', 'Dapil 4', 'Dapil 5', 'Dapil 6'] as $d)
                            <option value="{{ $d }}" style="color: #0f172a; background-color: #ffffff;">{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Nomor Urut *</label>
                    <input type="number" name="nomor_urut" required min="1" max="50" placeholder="1" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="L" style="color: #0f172a; background-color: #ffffff;">Laki-laki (L)</option>
                        <option value="P" style="color: #0f172a; background-color: #ffffff;">Perempuan (P)</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Tingkat Parlemen *</label>
                    <select name="tingkat" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="DPRD Kabupaten" selected style="color: #0f172a; background-color: #ffffff;">DPRD Kabupaten Banyumas</option>
                        <option value="DPRD Provinsi" style="color: #0f172a; background-color: #ffffff;">DPRD Provinsi Jawa Tengah</option>
                        <option value="DPR RI" style="color: #0f172a; background-color: #ffffff;">DPR RI (Dapil Jateng VIII)</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Status Caleg *</label>
                    <select name="status" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="DCT" selected style="color: #0f172a; background-color: #ffffff;">DCT (Daftar Calon Tetap)</option>
                        <option value="Caleg Terpilih" style="color: #0f172a; background-color: #ffffff;">Caleg Terpilih</option>
                        <option value="Aktif" style="color: #0f172a; background-color: #ffffff;">Aktif</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Jabatan Partai / Latar Belakang</label>
                    <input type="text" name="jabatan" placeholder="Contoh: Wakil Ketua DPD / Pengusaha" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Basis Wilayah Pemenangan</label>
                    <input type="text" name="basis_wilayah" placeholder="Contoh: Cilongok & Karanglewas" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div>
                    <label style="display: block; font-size: 11.5px; font-weight: 800; color: #001333; margin-bottom: 4px;">Target Suara</label>
                    <input type="number" name="target_suara" value="5000" min="0" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 11.5px; font-weight: 800; color: #001333; margin-bottom: 4px;">Suara Masuk Sementara</label>
                    <input type="number" name="suara_masuk" value="0" min="0" style="width: 100%; padding: 8px 12px; border: 1.5px solid #ffb700; border-radius: 6px; font-size: 13px; font-weight: 800; color: #001333; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" placeholder="S1 Hukum / SMA" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">No. WhatsApp / Kontak Tim</label>
                    <input type="text" name="phone" placeholder="0812-xxxx-xxxx" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Slogan / Visi Pemenangan</label>
                <input type="text" name="slogan" placeholder="Contoh: Mengabdi Nyata untuk Restorasi Banyumas" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Foto Calon Legislatif</label>
                <input type="file" name="foto_file" accept="image/*" style="width: 100%; font-size: 12px; padding: 6px 0;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <button type="button" onclick="closeCreateCalegModal()" class="admin-btn admin-btn-light" style="padding: 9px 18px; border-radius: 6px; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" class="btn-yellow" style="border: none; padding: 9px 22px; border-radius: 6px; font-weight: 900; font-size: 13px; cursor: pointer;">
                    💾 Tambah Caleg
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================
     MODAL 2: EDIT CALEG
     ======================================================== -->
<div id="editCalegModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeEditCalegModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>

    <div style="position: relative; background: #ffffff; width: 100%; max-width: 650px; border-radius: 14px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); max-height: 90vh; display: flex; flex-direction: column;">
        <div style="background: #001333; color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ffb700;">
            <h3 style="margin: 0; font-size: 17px; font-weight: 900; color: #ffb700;" id="editCalegModalTitle">✏️ Edit Calon Legislatif</h3>
            <button type="button" onclick="closeEditCalegModal()" style="background: none; border: none; color: #cbd5e1; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
        </div>

        <form id="editCalegForm" method="POST" enctype="multipart/form-data" style="padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px;">
            @csrf
            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Nama Lengkap &amp; Gelar *</label>
                <input type="text" name="nama" id="editNama" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Dapil *</label>
                    <select name="dapil" id="editDapil" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        @foreach(['Dapil 1', 'Dapil 2', 'Dapil 3', 'Dapil 4', 'Dapil 5', 'Dapil 6'] as $d)
                            <option value="{{ $d }}" style="color: #0f172a; background-color: #ffffff;">{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Nomor Urut *</label>
                    <input type="number" name="nomor_urut" id="editNomorUrut" required min="1" max="50" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" id="editJenisKelamin" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="L" style="color: #0f172a; background-color: #ffffff;">Laki-laki (L)</option>
                        <option value="P" style="color: #0f172a; background-color: #ffffff;">Perempuan (P)</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Tingkat Parlemen *</label>
                    <select name="tingkat" id="editTingkat" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="DPRD Kabupaten" style="color: #0f172a; background-color: #ffffff;">DPRD Kabupaten Banyumas</option>
                        <option value="DPRD Provinsi" style="color: #0f172a; background-color: #ffffff;">DPRD Provinsi Jawa Tengah</option>
                        <option value="DPR RI" style="color: #0f172a; background-color: #ffffff;">DPR RI (Dapil Jateng VIII)</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Status Caleg *</label>
                    <select name="status" id="editStatus" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #0f172a; background-color: #ffffff; font-weight: 600;">
                        <option value="DCT" style="color: #0f172a; background-color: #ffffff;">DCT (Daftar Calon Tetap)</option>
                        <option value="Caleg Terpilih" style="color: #0f172a; background-color: #ffffff;">Caleg Terpilih</option>
                        <option value="Aktif" style="color: #0f172a; background-color: #ffffff;">Aktif</option>
                        <option value="Mundur" style="color: #0f172a; background-color: #ffffff;">Mundur</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Jabatan / Latar Belakang</label>
                    <input type="text" name="jabatan" id="editJabatan" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Basis Wilayah Pemenangan</label>
                    <input type="text" name="basis_wilayah" id="editBasisWilayah" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div>
                    <label style="display: block; font-size: 11.5px; font-weight: 800; color: #001333; margin-bottom: 4px;">Target Suara</label>
                    <input type="number" name="target_suara" id="editTargetSuara" min="0" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 11.5px; font-weight: 800; color: #001333; margin-bottom: 4px;">Suara Masuk Sementara</label>
                    <input type="number" name="suara_masuk" id="editSuaraMasuk" min="0" style="width: 100%; padding: 8px 12px; border: 1.5px solid #ffb700; border-radius: 6px; font-size: 13px; font-weight: 800; color: #001333; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" id="editPendidikanTerakhir" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">No. WhatsApp / Kontak Tim</label>
                    <input type="text" name="phone" id="editPhone" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Slogan / Visi Pemenangan</label>
                <input type="text" name="slogan" id="editSlogan" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;">
            </div>

            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Perbarui Foto Caleg</label>
                <input type="file" name="foto_file" accept="image/*" style="width: 100%; font-size: 12px; padding: 6px 0;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <button type="button" onclick="closeEditCalegModal()" class="admin-btn admin-btn-light" style="padding: 9px 18px; border-radius: 6px; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" class="btn-yellow" style="border: none; padding: 9px 22px; border-radius: 6px; font-weight: 900; font-size: 13px; cursor: pointer;">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    function openCreateCalegModal() {
        document.getElementById('createCalegModal').style.display = 'flex';
    }

    function closeCreateCalegModal() {
        document.getElementById('createCalegModal').style.display = 'none';
    }

    function openEditCalegModal(caleg) {
        const form = document.getElementById('editCalegForm');
        form.action = `/admin/calon-legislatif/${caleg.id}`;
        document.getElementById('editCalegModalTitle').textContent = `✏️ Edit ${caleg.nama}`;
        document.getElementById('editNama').value = caleg.nama;
        document.getElementById('editDapil').value = caleg.dapil;
        document.getElementById('editNomorUrut').value = caleg.nomor_urut;
        document.getElementById('editJenisKelamin').value = caleg.jenis_kelamin;
        document.getElementById('editTingkat').value = caleg.tingkat;
        document.getElementById('editStatus').value = caleg.status;
        document.getElementById('editJabatan').value = caleg.jabatan || '';
        document.getElementById('editBasisWilayah').value = caleg.basis_wilayah || '';
        document.getElementById('editTargetSuara').value = caleg.target_suara || 5000;
        document.getElementById('editSuaraMasuk').value = caleg.suara_masuk || 0;
        document.getElementById('editPendidikanTerakhir').value = caleg.pendidikan_terakhir || '';
        document.getElementById('editPhone').value = caleg.phone || '';
        document.getElementById('editSlogan').value = caleg.slogan || '';
        document.getElementById('editCalegModal').style.display = 'flex';
    }

    function closeEditCalegModal() {
        document.getElementById('editCalegModal').style.display = 'none';
    }

    function toggleElectedCandidate(id) {
        fetch(`/admin/calon-legislatif/${id}/toggle-elected`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(err => alert('Gagal mengubah status: ' + err.message));
    }

    function confirmDeleteCaleg(id, nama) {
        if (!confirm(`Hapus Calon Legislatif ${nama}? Data yang dihapus tidak dapat dikembalikan.`)) return;
        fetch(`/admin/calon-legislatif/${id}`, {
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

    // Escape key modal closer
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateCalegModal();
            closeEditCalegModal();
        }
    });
</script>

@endsection
