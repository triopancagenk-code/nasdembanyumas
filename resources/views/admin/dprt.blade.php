@extends('layouts.app')

@section('title', 'DPRt – Seluruh Desa di Kabupaten Banyumas (Partai NasDem)')

@section('content')

{{-- Admin Top Banner --}}
<div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 110px 20px 40px; border-bottom: 3px solid #ffb700;">
    <div style="max-width: 1300px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                    POV ADMIN
                </span>
                <span style="color: #94a3b8; font-size: 13px;">Dewan Pimpinan Ranting (Desa / Kelurahan)</span>
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: #ffffff; margin: 0 0 6px 0;">
                Seluruh Desa &amp; Kelurahan <span style="color: #ffb700;">DPRt Banyumas</span>
            </h1>
            <p style="font-size: 14px; color: #cbd5e1; margin: 0;">
                Tingkat basis kerakyatan Partai NasDem yang menaungi 320+ desa/kelurahan di 27 kecamatan se-Banyumas.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.dpc') }}" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 8px 14px;">
                ← Ke Halaman DPC
            </a>
            <a href="{{ route('admin.statistik') }}" class="btn-yellow" style="text-decoration: none; font-size: 12px; padding: 8px 16px; border-radius: 6px; font-weight: 800;">
                Ke Statistik Wilayah →
            </a>
        </div>
    </div>
</div>

<div style="max-width: 1300px; margin: 30px auto 80px; padding: 0 20px;">

    <!-- SUMMARY METRICS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 4px;">TOTAL DESA &amp; KELURAHAN</span>
            <div style="font-size: 28px; font-weight: 900; color: #001333;">{{ $totalDesa }} Desa</div>
            <span style="font-size: 11px; color: #64748b; font-weight: 700;">Di 27 Kecamatan Banyumas</span>
        </div>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 4px;">SK DEFINITIF TERBENTUK</span>
            <div style="font-size: 28px; font-weight: 900; color: #10b981;">{{ $totalTerbentuk }} DPRt</div>
            <span style="font-size: 11px; color: #10b981; font-weight: 800;">✓ Keterisian {{ round(($totalTerbentuk / max(1, $totalDesa)) * 100, 1) }}%</span>
        </div>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 4px;">MANDATARIS / PROSES</span>
            <div style="font-size: 28px; font-weight: 900; color: #ffb700;">{{ $totalMandataris }} DPRt</div>
            <span style="font-size: 11px; color: #d97706; font-weight: 800;">Dalam Pembentukan Final</span>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
        <form action="{{ route('admin.dprt') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            <!-- Kecamatan Dropdown -->
            <select name="kecamatan" style="padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #ffffff; min-width: 180px;">
                <option value="all">Semua Kecamatan (27)</option>
                @foreach($kecamatans as $kec)
                    <option value="{{ $kec }}" {{ request('kecamatan') === $kec ? 'selected' : '' }}>
                        Kec. {{ $kec }}
                    </option>
                @endforeach
            </select>

            <!-- Search Input -->
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama desa/kelurahan atau ketua..." style="padding: 9px 14px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; flex: 1; min-width: 220px;">

            <!-- Status Dropdown -->
            <select name="status" style="padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #ffffff;">
                <option value="all">Semua Status</option>
                <option value="Terbentuk SK" {{ request('status') === 'Terbentuk SK' ? 'selected' : '' }}>Terbentuk SK</option>
                <option value="Mandataris" {{ request('status') === 'Mandataris' ? 'selected' : '' }}>Mandataris</option>
            </select>

            <button type="submit" class="admin-btn admin-btn-primary" style="padding: 9px 16px;">
                🔍 Filter
            </button>

            @if(request('kecamatan') || request('search') || request('status'))
                <a href="{{ route('admin.dprt') }}" class="admin-btn admin-btn-light" style="padding: 9px 14px; text-decoration: none;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- DPRT TABLE -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.03);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #001333; color: #ffffff;">
                        <th style="padding: 14px 16px; font-weight: 800; width: 50px;">No</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Desa / Kelurahan</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Kecamatan</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Ketua DPRt</th>
                        <th style="padding: 14px 16px; font-weight: 800;">No. Telepon / Kontak</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Jumlah Kader</th>
                        <th style="padding: 14px 16px; font-weight: 800;">Status</th>
                        <th style="padding: 14px 16px; font-weight: 800; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dprts as $dprt)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='#ffffff';">
                            <td style="padding: 12px 16px; color: #64748b; font-weight: 700;">
                                {{ $loop->iteration + ($dprts->currentPage() - 1) * $dprts->perPage() }}
                            </td>
                            <td style="padding: 12px 16px;">
                                <strong style="color: #001333; font-size: 14px;">{{ $dprt->desa_name }}</strong>
                                <span style="display: block; font-size: 11px; color: #64748b;">{{ $dprt->type }}</span>
                            </td>
                            <td style="padding: 12px 16px;">
                                <span style="background: rgba(0, 19, 51, 0.08); color: #001333; font-weight: 800; padding: 2px 7px; border-radius: 4px; font-size: 11px;">
                                    Kec. {{ $dprt->kecamatan_name }}
                                </span>
                            </td>
                            <td style="padding: 12px 16px; font-weight: 700; color: #0f172a;">
                                {{ $dprt->ketua_name ?: '-' }}
                            </td>
                            <td style="padding: 12px 16px; color: #475569;">
                                {{ $dprt->phone ?: '-' }}
                            </td>
                            <td style="padding: 12px 16px;">
                                <span style="color: #10b981; font-weight: 800;">{{ $dprt->total_kader }}</span> Kader
                            </td>
                            <td style="padding: 12px 16px;">
                                @if($dprt->status === 'Terbentuk SK')
                                    <span style="background: rgba(16, 185, 129, 0.12); color: #059669; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 4px;">
                                        ● Terbentuk SK
                                    </span>
                                @else
                                    <span style="background: rgba(245, 158, 11, 0.12); color: #d97706; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 4px;">
                                        ● Mandataris
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 12px 16px; text-align: right;">
                                <button type="button" onclick="openEditDprtModal({{ $dprt->id }}, '{{ addslashes($dprt->desa_name) }}', '{{ addslashes($dprt->kecamatan_name) }}', '{{ addslashes($dprt->ketua_name ?? '') }}', '{{ addslashes($dprt->phone ?? '') }}', '{{ addslashes($dprt->status) }}', {{ $dprt->total_kader }})" style="background: #001333; color: #ffb700; border: none; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 800; cursor: pointer;">
                                    ✏️ Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 40px; text-align: center; color: #64748b;">
                                Tidak ada data desa/kelurahan yang cocok dengan pencarian atau filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="padding: 16px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 12px; color: #64748b;">
                Menampilkan halaman {{ $dprts->currentPage() }} dari {{ $dprts->lastPage() }} (Total {{ $dprts->total() }} Desa)
            </span>
            <div>
                {{ $dprts->links() }}
            </div>
        </div>
    </div>

</div>

<!-- EDIT DPRT MODAL -->
<div id="editDprtModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeEditDprtModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>
    <div style="position: relative; background: #ffffff; border-radius: 14px; max-width: 480px; width: 100%; overflow: hidden; z-index: 2; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
        <div style="background: #001333; color: #ffffff; padding: 16px 20px; border-bottom: 2px solid #ffb700; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 17px; font-weight: 800;" id="editDprtModalTitle">✏️ Edit Pengurus DPRt</h3>
            <button type="button" onclick="closeEditDprtModal()" style="background: none; border: none; color: #cbd5e1; font-size: 22px; cursor: pointer;">&times;</button>
        </div>
        <form id="editDprtForm" onsubmit="submitDprtEdit(event)" style="padding: 20px;">
            <input type="hidden" id="editDprtId">
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Nama Ketua DPRt *</label>
                <input type="text" id="editDprtKetua" class="admin-form-control" required>
            </div>
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Nomor Telepon / Kontak</label>
                <input type="text" id="editDprtPhone" class="admin-form-control">
            </div>
            <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Status Kepengurusan</label>
                    <select id="editDprtStatus" class="admin-form-control">
                        <option value="Terbentuk SK">Terbentuk SK</option>
                        <option value="Mandataris">Mandataris</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Total Kader Desa</label>
                    <input type="number" id="editDprtKader" class="admin-form-control">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                <button type="button" onclick="closeEditDprtModal()" class="admin-btn admin-btn-light">Batal</button>
                <button type="submit" id="btnSaveDprt" class="admin-btn admin-btn-save">Simpan DPRt</button>
            </div>
        </form>
    </div>
</div>

<script>
    const csrfToken = '{{ csrf_token() }}';

    function openEditDprtModal(id, desa, kecamatan, ketua, phone, status, kader) {
        document.getElementById('editDprtId').value = id;
        document.getElementById('editDprtModalTitle').textContent = '✏️ Edit DPRt ' + desa + ' (Kec. ' + kecamatan + ')';
        document.getElementById('editDprtKetua').value = ketua;
        document.getElementById('editDprtPhone').value = phone;
        document.getElementById('editDprtStatus').value = status;
        document.getElementById('editDprtKader').value = kader;
        document.getElementById('editDprtModal').style.display = 'flex';
    }

    function closeEditDprtModal() {
        document.getElementById('editDprtModal').style.display = 'none';
    }

    function submitDprtEdit(e) {
        e.preventDefault();
        const id = document.getElementById('editDprtId').value;
        const btn = document.getElementById('btnSaveDprt');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        const payload = {
            ketua_name: document.getElementById('editDprtKetua').value,
            phone: document.getElementById('editDprtPhone').value,
            status: document.getElementById('editDprtStatus').value,
            total_kader: document.getElementById('editDprtKader').value,
        };

        fetch(`/admin/dprt/${id}`, {
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
            btn.textContent = 'Simpan DPRt';
            if (data.success) {
                alert(data.message || 'Data DPRt berhasil disimpan!');
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menyimpan data.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = 'Simpan DPRt';
            alert('Terjadi kesalahan jaringan.');
            console.error(err);
        });
    }
</script>

@endsection
