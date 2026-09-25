<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Hasil Quick Count C1 – DPD Partai NasDem Banyumas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #001333;
            background: #ffffff;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #001333;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            color: #001333;
        }
        .header h2 {
            margin: 4px 0;
            font-size: 15px;
            color: #334155;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
            color: #64748b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-verified {
            background: #dcfce7;
            color: #15803d;
        }
        .badge-pending {
            background: #fef3c7;
            color: #b45309;
        }
        .print-btn {
            background: #001333;
            color: #ffb700;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 15px;
        }
        @media print {
            .print-btn { display: none; }
        }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">🖨️ Cetak Dokumen / Simpan PDF</button>

    <div class="header">
        <h1>Dewan Pimpinan Daerah Partai NasDem</h1>
        <h2>Kabupaten Banyumas – Bappilu &amp; Tim Saksi Tabulasi Pemilu</h2>
        <p>REKAPITULASI RESMI FORMULIR C1 DAN QUICK COUNT HASIL TPS (DAPIL {{ strtoupper($dapil) }})</p>
        <p style="font-size: 11px;">Dicetak pada: {{ now()->translatedFormat('d F Y - H:i:s') }} WIB</p>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 12px;">
        <div><strong>Total Sampel TPS Masuk:</strong> {{ $tpsList->count() }} TPS</div>
        <div><strong>Akumulasi Suara NasDem:</strong> {{ number_format($tpsList->sum('suara_nasdem'), 0, ',', '.') }} Suara</div>
        <div><strong>Total Suara Sah Terdata:</strong> {{ number_format($tpsList->sum('suara_sah'), 0, ',', '.') }} Suara</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Dapil</th>
                <th>Kecamatan</th>
                <th>Desa/Kelurahan</th>
                <th>TPS</th>
                <th style="text-align: right;">DPT</th>
                <th style="text-align: right;">Suara NasDem</th>
                <th style="text-align: right;">Suara Sah</th>
                <th style="text-align: center;">% NasDem</th>
                <th>Saksi TPS</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tpsList as $tps)
                @php
                    $pct = $tps->suara_sah > 0 ? round(($tps->suara_nasdem / $tps->suara_sah) * 100, 1) : 0;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tps->dapil }}</td>
                    <td><strong>{{ $tps->kecamatan_name }}</strong></td>
                    <td>{{ $tps->desa_name }}</td>
                    <td><strong>{{ $tps->tps_number }}</strong></td>
                    <td style="text-align: right;">{{ $tps->total_dpt }}</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($tps->suara_nasdem, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($tps->suara_sah, 0, ',', '.') }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $pct }}%</td>
                    <td>{{ $tps->saksi_name ?: '-' }}</td>
                    <td style="text-align: center;">
                        <span class="badge {{ $tps->status === 'Terverifikasi' ? 'badge-verified' : 'badge-pending' }}">
                            {{ $tps->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center; padding: 20px;">Belum ada data rekaman TPS.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px; display: flex; justify-content: space-between; font-size: 12px;">
        <div style="text-align: center; width: 200px;">
            <p>Mengetahui,</p>
            <p><strong>Ketua DPD Partai NasDem</strong></p>
            <div style="height: 60px;"></div>
            <p><strong>( Dr. H. Edris Santoso, S.E. )</strong></p>
        </div>
        <div style="text-align: center; width: 200px;">
            <p>Purwokerto, {{ now()->translatedFormat('d F Y') }}</p>
            <p><strong>Bappilu DPD NasDem Banyumas</strong></p>
            <div style="height: 60px;"></div>
            <p><strong>( Nurokhman )</strong></p>
        </div>
    </div>

</body>
</html>
