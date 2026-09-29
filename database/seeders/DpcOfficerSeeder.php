<?php

namespace Database\Seeders;

use App\Models\Dpc;
use App\Models\DpcOfficer;
use Illuminate\Database\Seeder;

class DpcOfficerSeeder extends Seeder
{
    public function run(): void
    {
        $dpcs = Dpc::all();

        foreach ($dpcs as $dpc) {
            // Cek apakah pengurus DPC ini sudah memiliki 9 slot
            $existingCount = DpcOfficer::where('dpc_id', $dpc->id)->count();
            if ($existingCount >= 9) {
                continue;
            }

            // Jika belum ada atau kurang, kita hapus dan buat 9 slot resmi
            DpcOfficer::where('dpc_id', $dpc->id)->delete();

            $officerTemplates = [
                [
                    'sort_order' => 1,
                    'title' => 'Ketua DPC',
                    'category' => 'inti',
                    'name' => $dpc->ketua_name ?: ('Ketua DPC Kec. ' . $dpc->kecamatan_name),
                    'phone' => $dpc->phone ?: '0812-3456-7891',
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/01',
                    'instagram' => '@nasdem_' . strtolower(str_replace(' ', '', $dpc->kecamatan_name)),
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 2,
                    'title' => 'Wakil Ketua DPC',
                    'category' => 'inti',
                    'name' => 'Wakil Ketua ' . $dpc->kecamatan_name,
                    'phone' => null,
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/02',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 3,
                    'title' => 'Sekretaris DPC',
                    'category' => 'inti',
                    'name' => $dpc->sekretaris_name ?: ('Sekretaris Kec. ' . $dpc->kecamatan_name),
                    'phone' => '0813-2233-4455',
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/03',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 4,
                    'title' => 'Wakil Sekretaris DPC',
                    'category' => 'inti',
                    'name' => 'Wakil Sekretaris ' . $dpc->kecamatan_name,
                    'phone' => null,
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/04',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 5,
                    'title' => 'Bendahara DPC',
                    'category' => 'inti',
                    'name' => $dpc->bendahara_name ?: ('Bendahara Kec. ' . $dpc->kecamatan_name),
                    'phone' => '0812-9988-7766',
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/05',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 6,
                    'title' => 'Wakil Bendahara DPC',
                    'category' => 'inti',
                    'name' => 'Wakil Bendahara ' . $dpc->kecamatan_name,
                    'phone' => null,
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/06',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 7,
                    'title' => 'Koordinator Bidang Pemenangan Pemilu (Bappilu)',
                    'category' => 'bidang',
                    'name' => 'Koor. Bappilu ' . $dpc->kecamatan_name,
                    'phone' => null,
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/07',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 8,
                    'title' => 'Koordinator Bidang OKK',
                    'category' => 'bidang',
                    'name' => 'Koor. OKK ' . $dpc->kecamatan_name,
                    'phone' => null,
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/08',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 9,
                    'title' => 'Koordinator Bidang Media & Humas',
                    'category' => 'bidang',
                    'name' => 'Koor. Media & Humas ' . $dpc->kecamatan_name,
                    'phone' => null,
                    'sk_number' => $dpc->sk_number ?: 'SK-DPC/ND-BMS/' . strtoupper(substr($dpc->kecamatan_name, 0, 3)) . '/09',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
            ];

            foreach ($officerTemplates as $tmpl) {
                DpcOfficer::create(array_merge($tmpl, ['dpc_id' => $dpc->id]));
            }
        }
    }
}
