<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class SiteContentService
{
    protected string $storagePath;

    public function __construct()
    {
        $this->storagePath = storage_path('app/site_content.json');
    }

    /**
     * Get the current site content (or default if not customized yet).
     */
    public function getContent(): array
    {
        if (File::exists($this->storagePath)) {
            $json = File::get($this->storagePath);
            $data = json_decode($json, true);
            if (is_array($data)) {
                return array_replace_recursive($this->getDefaultContent(), $data);
            }
        }

        return $this->getDefaultContent();
    }

    /**
     * Save updated site content to JSON file.
     */
    public function saveContent(array $data): bool
    {
        $dir = dirname($this->storagePath);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return File::put($this->storagePath, $json) !== false;
    }

    /**
     * Reset content to default values.
     */
    public function resetContent(): bool
    {
        if (File::exists($this->storagePath)) {
            return File::delete($this->storagePath);
        }
        return true;
    }

    /**
     * Default content structure matching official Partai NasDem template.
     */
    public function getDefaultContent(): array
    {
        return [
            'brand' => [
                'branch' => 'DPD Partai NasDem Banyumas',
                'logo_url' => '/images/logo-nasdem-tsp.png',
            ],
            'hero_slides' => [
                [
                    'id' => 1,
                    'eyebrow' => 'Bersama Mewujudkan',
                    'title' => 'INDONESIA|MAJU|& BERKEADILAN',
                    'desc' => 'Partai NasDem berkomitmen untuk mewujudkan masyarakat yang sejahtera, berkeadilan, dan bermartabat melalui politik yang bersih dan kerja nyata.',
                    'url' => 'https://partainasdem.id/',
                    'image' => '/images/suryapaloh.jpg',
                    'button_text' => 'Gabung Sekarang',
                    'button_url' => 'https://digital.partainasdem.id/v1/daftar',
                    'video_url' => 'https://www.youtube.com/@officialnasdem',
                ],
                [
                    'id' => 2,
                    'eyebrow' => 'Gerakan Perubahan',
                    'title' => 'BERSATU|BERJUANG|MENANG',
                    'desc' => 'Bersama Partai NasDem, kita wujudkan Indonesia yang maju, adil, dan bermartabat.',
                    'url' => 'https://partainasdem.id/',
                    'image' => '/images/nasdem-tower.jpg',
                    'button_text' => 'Gabung Sekarang',
                    'button_url' => 'https://digital.partainasdem.id/v1/daftar',
                    'video_url' => 'https://www.youtube.com/@officialnasdem',
                ],
                [
                    'id' => 3,
                    'eyebrow' => 'Berita Terkini',
                    'title' => 'Konsolidasi Nasional Partai NasDem Memperkuat Restorasi',
                    'desc' => 'Ribuan kader dan jajaran pengurus dari 38 DPW se-Indonesia berpadu dalam tekad mewujudkan perubahan nyata.',
                    'url' => '#berita',
                    'image' => '/images/congress.jpg',
                    'button_text' => 'Baca Selengkapnya',
                    'button_url' => '#berita',
                    'video_url' => '',
                ],
                [
                    'id' => 4,
                    'eyebrow' => 'Berita Terkini',
                    'title' => 'Aksi Kemanusiaan NasDem Peduli Bagikan Bantuan ke Desa-Desa',
                    'desc' => 'Komitmen hadir di tengah masyarakat melalui aksi sosial nyata dan pelayanan kesehatan gratis.',
                    'url' => '#berita',
                    'image' => '/images/baksos.jpg',
                    'button_text' => 'Baca Selengkapnya',
                    'button_url' => '#berita',
                    'video_url' => '',
                ],
            ],
            'values' => [
                [
                    'id' => 1,
                    'title' => 'Restorasi',
                    'desc' => 'Memulihkan politik kebangsaan yang beretika dan bermartabat.',
                ],
                [
                    'id' => 2,
                    'title' => 'Keadilan',
                    'desc' => 'Memperjuangkan keadilan sosial bagi seluruh rakyat Indonesia.',
                ],
                [
                    'id' => 3,
                    'title' => 'Kemajuan',
                    'desc' => 'Mendorong kemajuan bangsa melalui inovasi dan kerja nyata.',
                ],
                [
                    'id' => 4,
                    'title' => 'Kebersamaan',
                    'desc' => 'Bersama rakyat, membangun masa depan Indonesia yang lebih baik.',
                ],
            ],
            'news_section' => [
                'title' => 'Update Berita',
                'view_all_text' => 'Lihat Semua',
                'view_all_url' => '#berita',
                'items' => [
                    [
                        'id' => 1,
                        'title' => 'Konsolidasi Nasional: Surya Paloh Tegaskan Politik Tanpa Mahar untuk Restorasi Indonesia',
                        'date' => '15 Sep 2026',
                        'image' => '/images/congress.jpg',
                        'url' => '#berita',
                    ],
                    [
                        'id' => 2,
                        'title' => 'Gerakan Restorasi Peduli Salurkan Bantuan Pangan dan Layanan Kesehatan untuk Warga Desa',
                        'date' => '14 Sep 2026',
                        'image' => '/images/baksos.jpg',
                        'url' => '#berita',
                    ],
                    [
                        'id' => 3,
                        'title' => 'Diskusi Kebangsaan di Perpustakaan Panglima Itam NasDem Tower Hadirkan Tokoh Nasional',
                        'date' => '14 Sep 2026',
                        'image' => '/images/nasdem-tower.jpg',
                        'url' => '#berita',
                    ],
                    [
                        'id' => 4,
                        'title' => 'RUU Desain Industri Harus Adaptif terhadap Perkembangan Teknologi Masa Depan',
                        'date' => '14 Sep 2026',
                        'image' => '/images/suryapaloh.jpg',
                        'url' => '#berita',
                    ],
                ],
            ],
            'about' => [
                'label' => 'Tentang Kami',
                'title' => 'Partai NasDem',
                'desc' => 'Partai NasDem adalah gerakan perubahan yang lahir dari semangat kebangsaan untuk membawa Indonesia ke arah yang lebih baik. Kami percaya bahwa perubahan besar dimulai dari kerja nyata, keberanian berpikir, dan ketulusan melayani.',
                'button_text' => 'Pelajari Lebih Lanjut',
                'button_url' => '#profil',
            ],
            'cta' => [
                'title' => "Bergabunglah bersama kami\nmenjadi bagian dari perubahan!",
                'button_text' => 'Gabung Sekarang',
                'button_url' => 'https://digital.partainasdem.id/v1/daftar',
            ],
            'footer' => [
                'brand_desc' => 'Bersama membangun Indonesia maju, adil, dan sejahtera untuk semua.',
                'contact_title' => 'Kantor DPP Partai NasDem',
                'contact_address' => "NasDem Tower\nJalan R.P. Soeroso No. 42-46\nGondangdia, Kecamatan Menteng\nJakarta Pusat, DKI Jakarta 10350",
                'contact_website' => 'www.partainasdem.id',
                'contact_website_url' => 'https://www.partainasdem.id',
                'copyright' => 'Partai NasDem. All rights reserved.',
            ],
        ];
    }
}
