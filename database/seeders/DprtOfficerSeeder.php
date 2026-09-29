<?php

namespace Database\Seeders;

use App\Models\Dprt;
use App\Models\DprtOfficer;
use Illuminate\Database\Seeder;

class DprtOfficerSeeder extends Seeder
{
    public function run(): void
    {
        $dprts = Dprt::all();

        foreach ($dprts as $dprt) {
            $existingCount = DprtOfficer::where('dprt_id', $dprt->id)->count();
            if ($existingCount >= 9) {
                continue;
            }

            $prefix = strtoupper(substr($dprt->kecamatan_name, 0, 3)) . '/' . strtoupper(substr(str_replace(' ', '', $dprt->desa_name), 0, 3));

            $officerTemplates = [
                [
                    'sort_order' => 1,
                    'title' => 'Ketua DPRt',
                    'category' => 'inti',
                    'name' => $dprt->ketua_name ?: ('Ketua DPRt ' . $dprt->desa_name),
                    'phone' => $dprt->phone ?: '0858-1234-5678',
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/01',
                    'instagram' => '@nasdem_' . strtolower(str_replace(' ', '', $dprt->desa_name)),
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 2,
                    'title' => 'Wakil Ketua DPRt',
                    'category' => 'inti',
                    'name' => 'Wakil Ketua ' . $dprt->desa_name,
                    'phone' => null,
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/02',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 3,
                    'title' => 'Sekretaris DPRt',
                    'category' => 'inti',
                    'name' => 'Sekretaris ' . $dprt->desa_name,
                    'phone' => '0858-2233-4455',
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/03',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 4,
                    'title' => 'Wakil Sekretaris DPRt',
                    'category' => 'inti',
                    'name' => 'Wakil Sekretaris ' . $dprt->desa_name,
                    'phone' => null,
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/04',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 5,
                    'title' => 'Bendahara DPRt',
                    'category' => 'inti',
                    'name' => 'Bendahara ' . $dprt->desa_name,
                    'phone' => '0858-9988-7766',
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/05',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 6,
                    'title' => 'Wakil Bendahara DPRt',
                    'category' => 'inti',
                    'name' => 'Wakil Bendahara ' . $dprt->desa_name,
                    'phone' => null,
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/06',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 7,
                    'title' => 'Koordinator Bidang Bappilu (Pemenangan Pemilu Desa)',
                    'category' => 'bidang',
                    'name' => 'Koor. Bappilu ' . $dprt->desa_name,
                    'phone' => null,
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/07',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 8,
                    'title' => 'Koordinator Bidang OKK (Kaderisasi Desa)',
                    'category' => 'bidang',
                    'name' => 'Koor. OKK ' . $dprt->desa_name,
                    'phone' => null,
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/08',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
                [
                    'sort_order' => 9,
                    'title' => 'Koordinator Bidang Media & Humas Desa',
                    'category' => 'bidang',
                    'name' => 'Koor. Media & Humas ' . $dprt->desa_name,
                    'phone' => null,
                    'sk_number' => 'SK-DPRT/ND/' . $prefix . '/09',
                    'instagram' => null,
                    'photo' => null,
                    'status' => 'Aktif',
                ],
            ];

            foreach ($officerTemplates as $tmpl) {
                DprtOfficer::firstOrCreate(
                    ['dprt_id' => $dprt->id, 'sort_order' => $tmpl['sort_order']],
                    $tmpl
                );
            }
        }
    }
}
