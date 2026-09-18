<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminContentTest extends TestCase
{
    public function test_home_page_renders_with_admin_assets_and_editable_markers(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('nasdemAdminBar', false);
        $response->assertSee('admin-editor.js', false);
        $response->assertSee('admin-editor.css', false);
        $response->assertSee('data-editable=', false);
        $response->assertSee('data-editable-img=', false);
    }

    public function test_can_save_and_retrieve_custom_content(): void
    {
        $newBranchName = 'DPC NasDem Banyumas (Mode Edit Admin Berhasil)';

        $saveResponse = $this->postJson('/admin/save-content', [
            'brand' => [
                'branch' => $newBranchName,
                'logo_url' => '/images/logo-nasdem-tsp.png',
            ],
            'hero_slides' => [
                [
                    'id' => 1,
                    'eyebrow' => 'Gerakan Perubahan Banyumas',
                    'title' => 'INDONESIA|BERSATU|MENANG',
                    'desc' => 'Uji coba penyimpanan konten live edit.',
                    'url' => 'https://partainasdem.id/',
                    'image' => '/images/suryapaloh.jpg',
                    'button_text' => 'Gabung Sekarang',
                    'button_url' => '#',
                ]
            ],
            'values' => [
                [
                    'id' => 1,
                    'title' => 'Restorasi Total',
                    'desc' => 'Perubahan menuju politik bermartabat.',
                ]
            ],
            'news_section' => [
                'title' => 'Kabar Terkini NasDem',
                'view_all_text' => 'Semua Berita',
                'view_all_url' => '#berita',
                'items' => [
                    [
                        'id' => 1,
                        'title' => 'Berita Uji Coba Admin CMS',
                        'date' => '16 Sep 2026',
                        'image' => '/images/congress.jpg',
                        'url' => '#berita'
                    ]
                ]
            ],
            'about' => [
                'label' => 'Tentang Kami',
                'title' => 'Partai NasDem Banyumas',
                'desc' => 'Deskripsi tentang kami setelah diedit.',
                'button_text' => 'Pelajari',
                'button_url' => '#profil'
            ],
            'cta' => [
                'title' => "Bergabunglah bersama kami!",
                'button_text' => 'Daftar Sekarang',
                'button_url' => '#'
            ],
            'footer' => [
                'brand_desc' => 'Footer resmi Partai NasDem',
                'contact_title' => 'DPD NasDem',
                'contact_address' => 'Kantor Cabang',
                'contact_website' => 'www.partainasdem.id',
                'contact_website_url' => 'https://www.partainasdem.id',
                'copyright' => 'Partai NasDem All Rights Reserved.'
            ]
        ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['success' => true]);

        // Verify that visiting the home page reflects the saved content
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee($newBranchName);
        $homeResponse->assertSee('Berita Uji Coba Admin CMS');
        $homeResponse->assertSee('Restorasi Total');

        // Reset back to default
        $resetResponse = $this->postJson('/admin/reset-content');
        $resetResponse->assertStatus(200);
        $resetResponse->assertJson(['success' => true]);

        // Home should revert back
        $revertedResponse = $this->get('/');
        $revertedResponse->assertStatus(200);
        $revertedResponse->assertDontSee($newBranchName);
    }
}
