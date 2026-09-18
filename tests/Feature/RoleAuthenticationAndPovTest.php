<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PartyDataSeeder;
use Tests\TestCase;

class RoleAuthenticationAndPovTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PartyDataSeeder::class);
    }

    public function test_login_page_is_dedicated_to_admin_portal(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Admin Portal');
        $response->assertSee('Sign In');
        $response->assertSee('Sign In to Dashboard');
        $response->assertDontSee('bapilu2026');
        $response->assertDontSee('admin123');
        $response->assertSee('Username / Email');
    }

    public function test_admin_login_redirects_to_home(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@nasdem.id',
            'password' => 'admin123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isAdmin());
    }

    public function test_bapilu2026_admin_can_login_with_username_or_email(): void
    {
        // 1. Login with username bapilu2026
        $response = $this->post('/login', [
            'email' => 'bapilu2026',
            'password' => 'bapilu2026',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isAdmin());
        $this->assertEquals('bapilu2026', auth()->user()->name);

        auth()->logout();

        // 2. Login with email bapilu2026@nasdem.id
        $response2 = $this->post('/login', [
            'email' => 'bapilu2026@nasdem.id',
            'password' => 'bapilu2026',
        ]);

        $response2->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isAdmin());
    }

    public function test_pengguna_login_redirects_to_home(): void
    {
        $response = $this->post('/login', [
            'email' => 'pengguna@nasdem.id',
            'password' => 'user123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isPengguna());
    }

    public function test_quick_login_works_for_admin_and_pengguna(): void
    {
        // 1. Quick login as admin
        $adminResp = $this->get('/quick-login/admin');
        $adminResp->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isAdmin());

        // 2. Quick login as pengguna
        $userResp = $this->get('/quick-login/pengguna');
        $userResp->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->isPengguna());
    }

    public function test_pengguna_pov_displays_beranda_visi_misi_and_berita_only(): void
    {
        $user = User::where('role', 'pengguna')->first();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Beranda');
        $response->assertSee('Visi &amp; Misi', false);
        $response->assertSee('Berita');
    }

    public function test_admin_pov_displays_dpd_dpc_dprt_statistik_and_berita(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dpd');
        $response->assertStatus(200);
        $response->assertSee('DPD');
        $response->assertSee('DPC');
        $response->assertSee('DPRt');
        $response->assertSee('Statistik');
        $response->assertSee('Berita');
    }

    public function test_admin_dpd_page_renders_official_replica_sections(): void
    {
        $admin = User::where('role', 'admin')->first();

        // 1. DPD database holds 18 officers
        $this->assertGreaterThanOrEqual(18, \App\Models\DpdOfficer::count());

        // 2. DPD page renders official replica sections
        $response = $this->actingAs($admin)->get('/admin/dpd');
        $response->assertStatus(200);
        $response->assertSee('EDRIS SANTOSO, S.E.');
        $response->assertSee('Ketua DPD Partai NasDem Kabupaten Banyumas');
        $response->assertSee('PENGURUS DPD NASDEM BANYUMAS', false);
        $response->assertDontSee('ANGGOTA DEWAN', false);
        $response->assertSee('RUBRIK');
        $response->assertSee('KABAR');
        $response->assertSee('PPID');
        $response->assertSee('GABUNG');
        $response->assertSee('Kolom Aspirasi');
        $response->assertSee('dpd_hero_banner.jpg');
        $response->assertSee('Nata', false);
        $response->assertSee('Siap Melayani Warga Banyumas', false);
    }

    public function test_admin_dpc_page_contains_all_27_kecamatan(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dpc');
        $response->assertStatus(200);
        $response->assertSee('27 Kecamatan');
        $response->assertSee('Kec. Purwokerto Timur');
        $response->assertSee('Kec. Cilongok');
        $response->assertSee('Kec. Banyumas');
        $response->assertSee('Kec. Wangon');
        $response->assertSee('Kec. Sumbang');
    }

    public function test_admin_dprt_page_contains_desa_and_kecamatan_filter(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dprt');
        $response->assertStatus(200);
        $response->assertSee('DPRt Banyumas');
        $response->assertSee('Semua Kecamatan (27)');
        $response->assertSee('Terbentuk SK');
    }

    public function test_admin_statistik_page_contains_wilayah_and_anggota_metrics(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/statistik');
        $response->assertStatus(200);
        $response->assertSee('Statistik Cakupan Wilayah');
        $response->assertSee('6 Dapil');
        $response->assertSee('Dapil 1');
        $response->assertSee('Dapil 2');
        $response->assertSee('Dapil 3');
        $response->assertSee('Dapil 4');
        $response->assertSee('Dapil 5');
        $response->assertSee('Dapil 6');
        $response->assertSee('Statistik Keanggotaan &amp; Kader', false);
        $response->assertSee('Komposisi Gender Anggota');
        $response->assertSee('Grafik Peringkat Kader &amp; Suara Partai 27 Kecamatan se-Kabupaten Banyumas', false);
        $response->assertSee('kader27KecamatanChart');
        $response->assertSee('Kec. Cilongok');
        $response->assertSee('chart.umd.min.js');
    }

    public function test_regular_user_cannot_access_admin_pages(): void
    {
        $user = User::where('role', 'pengguna')->first();

        $response = $this->actingAs($user)->get('/admin/dpd');
        $response->assertStatus(403);
    }

    public function test_guest_is_redirected_to_login_when_accessing_admin_pages(): void
    {
        $response = $this->get('/admin/dpd');
        $response->assertRedirect(route('login'));
    }

    public function test_mobile_hamburger_menu_and_drawer_exist_in_all_povs(): void
    {
        // 1. Guest POV - Bergabung & Login are in navbar for PC/laptop, while on mobile only Bergabung is in front and Login is in sidebar drawer
        $guestResp = $this->get('/');
        $guestResp->assertStatus(200);
        $guestResp->assertSee('id="mobileMenuBtn"', false);
        $guestResp->assertSee('id="mobileDrawer"', false);
        $guestResp->assertSee('id="mobileBackdrop"', false);
        $guestResp->assertSee('nav-btn-join', false);
        $guestResp->assertSee('desktop-only-login', false);
        $guestResp->assertSee(route('login'));

        // 2. Pengguna (Kader) POV
        $kader = User::where('role', 'pengguna')->first();
        $kaderResp = $this->actingAs($kader)->get('/');
        $kaderResp->assertStatus(200);
        $kaderResp->assertSee('id="mobileMenuBtn"', false);
        $kaderResp->assertSee('id="mobileDrawer"', false);
        $kaderResp->assertSee('badge-kader', false);
        $kaderResp->assertSee('KADER');

        // 3. Admin POV on Home and Admin Subpage
        $admin = User::where('role', 'admin')->first();
        $adminHomeResp = $this->actingAs($admin)->get('/');
        $adminHomeResp->assertStatus(200);
        $adminHomeResp->assertSee('id="mobileMenuBtn"', false);
        $adminHomeResp->assertSee('id="mobileDrawer"', false);
        $adminHomeResp->assertSee('badge-admin', false);
        $adminHomeResp->assertSee('ADMIN');

        $adminDpdResp = $this->actingAs($admin)->get('/admin/dpd');
        $adminDpdResp->assertStatus(200);
        $adminDpdResp->assertSee('id="mobileMenuBtn"', false);
        $adminDpdResp->assertSee('id="mobileDrawer"', false);
        $adminDpdResp->assertSee('badge-admin', false);
    }

    public function test_home_page_news_has_visible_dark_titles_and_excerpts_in_all_povs(): void
    {
        // 1. Guest POV on home
        $guestResp = $this->get('/');
        $guestResp->assertStatus(200);
        $guestResp->assertSee('color: #001b4d', false);
        $guestResp->assertDontSee('color: #ffffff; text-decoration: none; font-size: 15px', false);

        // 2. Kader POV on home
        $kader = User::where('role', 'pengguna')->first();
        $kaderResp = $this->actingAs($kader)->get('/');
        $kaderResp->assertStatus(200);
        $kaderResp->assertSee('color: #001b4d', false);

        // 3. Admin POV on home
        $admin = User::where('role', 'admin')->first();
        $adminResp = $this->actingAs($admin)->get('/');
        $adminResp->assertStatus(200);
        $adminResp->assertSee('color: #001b4d', false);
    }
}
