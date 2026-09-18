<?php

namespace Database\Seeders;

use App\Models\Dpc;
use App\Models\Dprt;
use Illuminate\Database\Seeder;

class UpdateKecamatanSuaraSeeder extends Seeder
{
    /**
     * Data akurat dan presisi: Jumlah Kader & Suara Partai/Kader di 27 Kecamatan se-Kabupaten Banyumas.
     */
    public function run(): void
    {
        $kecamatanMetrics = [
            // DAPIL 6 (Basis Utama / Kursi DPRD Banyumas Fraksi NasDem - Nartam Andrea Nusa)
            'Cilongok' => ['kader' => 2140, 'suara' => 6850, 'target' => 7500],
            'Kedungbanteng' => ['kader' => 1480, 'suara' => 4420, 'target' => 5000],
            'Karanglewas' => ['kader' => 1450, 'suara' => 3980, 'target' => 4500],
            'Purwojati' => ['kader' => 1120, 'suara' => 3150, 'target' => 3500],

            // DAPIL 1 (Kawasan Perkotaan Purwokerto & Patikraja)
            'Purwokerto Selatan' => ['kader' => 1260, 'suara' => 3250, 'target' => 3800],
            'Purwokerto Barat' => ['kader' => 1180, 'suara' => 2840, 'target' => 3400],
            'Patikraja' => ['kader' => 1390, 'suara' => 2760, 'target' => 3300],
            'Purwokerto Timur' => ['kader' => 1040, 'suara' => 2620, 'target' => 3200],
            'Purwokerto Utara' => ['kader' => 1150, 'suara' => 2480, 'target' => 3000],

            // DAPIL 2 (Sumbang, Sokaraja, Kembaran, Baturraden)
            'Sokaraja' => ['kader' => 1950, 'suara' => 3120, 'target' => 3800],
            'Sumbang' => ['kader' => 2020, 'suara' => 2940, 'target' => 3600],
            'Kembaran' => ['kader' => 1640, 'suara' => 2450, 'target' => 3000],
            'Baturraden' => ['kader' => 1250, 'suara' => 2150, 'target' => 2600],

            // DAPIL 5 (Ajibarang, Pekuncen, Lumbir, Gumelar)
            'Ajibarang' => ['kader' => 1680, 'suara' => 3450, 'target' => 4000],
            'Pekuncen' => ['kader' => 1720, 'suara' => 2890, 'target' => 3500],
            'Lumbir' => ['kader' => 1050, 'suara' => 1860, 'target' => 2200],
            'Gumelar' => ['kader' => 980, 'suara' => 1640, 'target' => 2000],

            // DAPIL 4 (Wangon, Jatilawang, Kebasen, Rawalo)
            'Wangon' => ['kader' => 1420, 'suara' => 2950, 'target' => 3500],
            'Jatilawang' => ['kader' => 1280, 'suara' => 2320, 'target' => 2800],
            'Kebasen' => ['kader' => 1220, 'suara' => 2180, 'target' => 2600],
            'Rawalo' => ['kader' => 960, 'suara' => 1740, 'target' => 2200],

            // DAPIL 3 (Kemranjen, Sumpiuh, Banyumas, Kalibagor, Tambak, Somagede)
            'Kemranjen' => ['kader' => 1580, 'suara' => 2420, 'target' => 2900],
            'Sumpiuh' => ['kader' => 1360, 'suara' => 2380, 'target' => 2900],
            'Banyumas' => ['kader' => 1240, 'suara' => 1950, 'target' => 2400],
            'Kalibagor' => ['kader' => 1310, 'suara' => 1880, 'target' => 2300],
            'Tambak' => ['kader' => 1160, 'suara' => 1620, 'target' => 2000],
            'Somagede' => ['kader' => 890, 'suara' => 1340, 'target' => 1700],
        ];

        foreach ($kecamatanMetrics as $kecamatan => $metric) {
            $dpc = Dpc::where('kecamatan_name', $kecamatan)->first();
            if (!$dpc) {
                continue;
            }

            $dpc->update([
                'total_kader' => $metric['kader'],
                'total_suara' => $metric['suara'],
                'target_suara' => $metric['target'],
            ]);

            // Sinkronkan DPRt agar jumlah total kader per ranting/desa tepat sama dengan total_kader DPC
            $dprts = Dprt::where('dpc_id', $dpc->id)->get();
            $count = $dprts->count();
            if ($count > 0) {
                $base = intdiv($metric['kader'], $count);
                $rem = $metric['kader'] % $count;

                foreach ($dprts as $idx => $dprt) {
                    $desaKader = $base + ($idx < $rem ? 1 : 0);
                    $dprt->update(['total_kader' => $desaKader]);
                }
            }
        }
    }
}
