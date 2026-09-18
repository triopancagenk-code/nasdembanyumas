@extends('layouts.app')

@section('title', 'DPC – Seluruh Kecamatan di Banyumas (Partai NasDem)')

@section('content')

{{-- Admin Top Banner --}}
<div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 110px 20px 40px; border-bottom: 3px solid #ffb700;">
    <div style="max-width: 1300px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                    POV ADMIN
                </span>
                <span style="color: #94a3b8; font-size: 13px;">Dewan Pimpinan Cabang (Kecamatan)</span>
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: #ffffff; margin: 0 0 6px 0;">
                Seluruh 27 DPC <span style="color: #ffb700;">Kabupaten Banyumas</span>
            </h1>
            <p style="font-size: 14px; color: #cbd5e1; margin: 0;">
                Cakupan teritorial tingkat kecamatan, pengurus KSB (Ketua, Sekretaris, Bendahara), dan keterisian ranting.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.dprt') }}" class="btn-yellow" style="text-decoration: none; font-size: 12px; padding: 8px 16px; border-radius: 6px; font-weight: 800;">
                Ke Halaman DPRt (Desa) →
            </a>
        </div>
    </div>
</div>

<div style="max-width: 1300px; margin: 30px auto 80px; padding: 0 20px;">

    <!-- SUMMARY METRICS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 30px;">
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 4px;">TOTAL DPC KECAMATAN</span>
            <div style="font-size: 28px; font-weight: 900; color: #001333;">27 / 27</div>
            <span style="font-size: 11px; color: #10b981; font-weight: 800;">✓ 100% Terbentuk Definitif</span>
        </div>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 4px;">TOTAL RANTING (DPRT)</span>
            <div style="font-size: 28px; font-weight: 900; color: #ffb700;">{{ $totalRanting }} Desa</div>
            <span style="font-size: 11px; color: #64748b; font-weight: 700;">Cakupan se-Kabupaten</span>
        </div>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 4px;">TOTAL KADER TERDATA</span>
            <div style="font-size: 28px; font-weight: 900; color: #10b981;">{{ number_format($totalKader, 0, ',', '.') }}</div>
            <span style="font-size: 11px; color: #10b981; font-weight: 800;">Tersebar di 27 Kecamatan</span>
        </div>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            <span style="font-size: 12px; color: #64748b; font-weight: 700; display: block; margin-bottom: 4px;">DAERAH PEMILIHAN</span>
            <div style="font-size: 28px; font-weight: 900; color: #001333;">6 Dapil</div>
            <span style="font-size: 11px; color: #64748b; font-weight: 700;">Kabupaten Banyumas</span>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <form action="{{ route('admin.dpc') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; flex: 1;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kecamatan atau ketua..." style="padding: 9px 14px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; min-width: 240px; flex: 1;">

            <select name="dapil" style="padding: 9px 12px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 13px; background: #ffffff;">
                <option value="all">Semua Dapil (6 Dapil)</option>
                <option value="Dapil 1" {{ request('dapil') === 'Dapil 1' ? 'selected' : '' }}>Dapil 1 (Purwokerto Barat, Selatan, Timur, Utara, Patikraja)</option>
                <option value="Dapil 2" {{ request('dapil') === 'Dapil 2' ? 'selected' : '' }}>Dapil 2 (Sokaraja, Kembaran, Sumbang, Baturraden)</option>
                <option value="Dapil 3" {{ request('dapil') === 'Dapil 3' ? 'selected' : '' }}>Dapil 3 (Banyumas, Kalibagor, Kemranjen, Somagede, Sumpiuh, Tambak)</option>
                <option value="Dapil 4" {{ request('dapil') === 'Dapil 4' ? 'selected' : '' }}>Dapil 4 (Jatilawang, Kebasen, Rawalo, Wangon)</option>
                <option value="Dapil 5" {{ request('dapil') === 'Dapil 5' ? 'selected' : '' }}>Dapil 5 (Ajibarang, Gumelar, Lumbir, Pekuncen)</option>
                <option value="Dapil 6" {{ request('dapil') === 'Dapil 6' ? 'selected' : '' }}>Dapil 6 (Cilongok, Karanglewas, Kedungbanteng, Purwojati)</option>
            </select>

            <button type="submit" class="admin-btn admin-btn-primary" style="padding: 9px 16px;">
                🔍 Terapkan Filter
            </button>
            @if(request('search') || request('dapil'))
                <a href="{{ route('admin.dpc') }}" class="admin-btn admin-btn-light" style="padding: 9px 14px; text-decoration: none;">
                    Reset
                </a>
            @endif
        </form>

        <span style="font-size: 13px; font-weight: 700; color: #64748b;">
            Menampilkan: <strong style="color: #001333;">{{ $dpcs->count() }} Kecamatan</strong>
        </span>
    </div>

    <!-- DPC GRID OF ALL 27 KECAMATAN -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 20px;">
        @foreach($dpcs as $dpc)
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.15s ease, border-color 0.15s ease;" onmouseover="this.style.borderColor='#ffb700'; this.style.transform='translateY(-3px)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='none';">
                <div style="padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <span style="background: #001333; color: #ffb700; font-size: 10px; font-weight: 900; padding: 2px 7px; border-radius: 4px; text-transform: uppercase;">
                                {{ $dpc->dapil }}
                            </span>
                            <h3 style="font-size: 19px; font-weight: 900; color: #001333; margin: 6px 0 2px 0;">
                                DPC Kec. {{ $dpc->kecamatan_name }}
                            </h3>
                            <span style="font-size: 12px; color: #64748b;">📍 {{ $dpc->office_address ?: 'Kabupaten Banyumas' }}</span>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.12); color: #059669; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 4px; border: 1px solid rgba(16, 185, 129, 0.3);">
                            {{ $dpc->status }}
                        </span>
                    </div>

                    <!-- KSB Info -->
                    <div style="background: #f8fafc; border-radius: 8px; padding: 12px; font-size: 12px; margin-bottom: 14px; border: 1px solid #e2e8f0;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="color: #64748b;">Ketua DPC:</span>
                            <strong style="color: #0f172a;">{{ $dpc->ketua_name }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="color: #64748b;">Sekretaris:</span>
                            <strong style="color: #0f172a;">{{ $dpc->sekretaris_name ?: '-' }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #64748b;">Bendahara:</span>
                            <strong style="color: #0f172a;">{{ $dpc->bendahara_name ?: '-' }}</strong>
                        </div>
                    </div>

                    <!-- Teritorial Metrics -->
                    <div style="display: flex; justify-content: space-between; font-size: 12px; color: #475569;">
                        <div>
                            <span>Jumlah Ranting:</span>
                            <strong style="color: #ffb700; margin-left: 4px;">{{ $dpc->total_ranting }} DPRt</strong>
                        </div>
                        <div>
                            <span>Kader Terdaftar:</span>
                            <strong style="color: #10b981; margin-left: 4px;">{{ number_format($dpc->total_kader, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>

                <div style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 10px 18px; display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('admin.dprt', ['kecamatan' => $dpc->kecamatan_name]) }}" style="font-size: 12px; color: #001333; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                        <span>Lihat Desa Ranting</span>
                        <span style="color: #ffb700;">→</span>
                    </a>

                    <button type="button" onclick="openEditDpcModal({{ $dpc->id }}, '{{ addslashes($dpc->kecamatan_name) }}', '{{ addslashes($dpc->ketua_name) }}', '{{ addslashes($dpc->sekretaris_name ?? '') }}', '{{ addslashes($dpc->bendahara_name ?? '') }}', '{{ addslashes($dpc->office_address ?? '') }}', '{{ addslashes($dpc->phone ?? '') }}', '{{ addslashes($dpc->status) }}', {{ $dpc->total_kader }})" style="background: #001333; color: #ffb700; border: none; padding: 5px 12px; border-radius: 4px; font-size: 11px; font-weight: 800; cursor: pointer;">
                        ✏️ Edit Pengurus
                    </button>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- EDIT DPC MODAL -->
<div id="editDpcModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeEditDpcModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>
    <div style="position: relative; background: #ffffff; border-radius: 14px; max-width: 520px; width: 100%; overflow: hidden; z-index: 2; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
        <div style="background: #001333; color: #ffffff; padding: 16px 20px; border-bottom: 2px solid #ffb700; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 17px; font-weight: 800;" id="editDpcModalTitle">✏️ Edit Pengurus DPC</h3>
            <button type="button" onclick="closeEditDpcModal()" style="background: none; border: none; color: #cbd5e1; font-size: 22px; cursor: pointer;">&times;</button>
        </div>
        <form id="editDpcForm" onsubmit="submitDpcEdit(event)" style="padding: 20px;">
            <input type="hidden" id="editDpcId">
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Nama Ketua DPC *</label>
                <input type="text" id="editDpcKetua" class="admin-form-control" required>
            </div>
            <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Sekretaris</label>
                    <input type="text" id="editDpcSekretaris" class="admin-form-control">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Bendahara</label>
                    <input type="text" id="editDpcBendahara" class="admin-form-control">
                </div>
            </div>
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Alamat Kantor DPC</label>
                <input type="text" id="editDpcAddress" class="admin-form-control">
            </div>
            <div style="display: flex; gap: 12px; margin-bottom: 14px;">
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Nomor Telepon / WA</label>
                    <input type="text" id="editDpcPhone" class="admin-form-control">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 4px;">Total Kader</label>
                    <input type="number" id="editDpcKader" class="admin-form-control">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
                <button type="button" onclick="closeEditDpcModal()" class="admin-btn admin-btn-light">Batal</button>
                <button type="submit" id="btnSaveDpc" class="admin-btn admin-btn-save">Simpan DPC</button>
            </div>
        </form>
    </div>
</div>

<script>
    const csrfToken = '{{ csrf_token() }}';

    function openEditDpcModal(id, kecamatan, ketua, sekretaris, bendahara, address, phone, status, kader) {
        document.getElementById('editDpcId').value = id;
        document.getElementById('editDpcModalTitle').textContent = '✏️ Edit DPC Kec. ' + kecamatan;
        document.getElementById('editDpcKetua').value = ketua;
        document.getElementById('editDpcSekretaris').value = sekretaris;
        document.getElementById('editDpcBendahara').value = bendahara;
        document.getElementById('editDpcAddress').value = address;
        document.getElementById('editDpcPhone').value = phone;
        document.getElementById('editDpcKader').value = kader;
        document.getElementById('editDpcModal').style.display = 'flex';
    }

    function closeEditDpcModal() {
        document.getElementById('editDpcModal').style.display = 'none';
    }

    function submitDpcEdit(e) {
        e.preventDefault();
        const id = document.getElementById('editDpcId').value;
        const btn = document.getElementById('btnSaveDpc');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        const payload = {
            ketua_name: document.getElementById('editDpcKetua').value,
            sekretaris_name: document.getElementById('editDpcSekretaris').value,
            bendahara_name: document.getElementById('editDpcBendahara').value,
            office_address: document.getElementById('editDpcAddress').value,
            phone: document.getElementById('editDpcPhone').value,
            total_kader: document.getElementById('editDpcKader').value,
        };

        fetch(`/admin/dpc/${id}`, {
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
            btn.textContent = 'Simpan DPC';
            if (data.success) {
                alert(data.message || 'Data DPC berhasil disimpan!');
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menyimpan data.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.textContent = 'Simpan DPC';
            alert('Terjadi kesalahan jaringan.');
            console.error(err);
        });
    }
</script>

@endsection
