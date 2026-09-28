<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PartyDataSeeder;
use Tests\TestCase;

class MobileNavigationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PartyDataSeeder::class);
    }

    public function test_mobile_navigation_and_drawer_render_for_admin(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('home'));

        $response->assertStatus(200);

        // Verify hamburger button (garis 3) exists in navbar
        $response->assertSee('id="mobileMenuBtn"', false);
        $response->assertSee('mobile-menu-btn', false);
        $response->assertSee('M4 6.5H20', false);
        $response->assertSee('M4 12H20', false);
        $response->assertSee('M4 17.5H20', false);

        // Verify mobile drawer exists
        $response->assertSee('id="mobileDrawer"', false);
        $response->assertSee('id="mobileCloseBtn"', false);
        $response->assertSee('id="mobileBackdrop"', false);

        // Verify all 8 requested items exist in mobile navigation for admin
        $response->assertSee(route('admin.dpd'));
        $response->assertSee(route('admin.dpc'));
        $response->assertSee(route('admin.dprt'));
        $response->assertSee(route('admin.quick-count'));
        $response->assertSee(route('admin.statistik'));
        $response->assertSee(route('admin.calon-legislatif'));
        $response->assertSee(route('admin.berita'));
        $response->assertSee(route('logout'));

        // Labels
        $response->assertSee('DPD');
        $response->assertSee('DPC');
        $response->assertSee('DPRt');
        $response->assertSee('Quick Count');
        $response->assertSee('Statistik');
        $response->assertSee('Calon Legislatif');
        $response->assertSee('Berita');
        $response->assertSee('Keluar (Logout)');
    }

    public function test_mobile_navigation_renders_on_admin_pages(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.dpd'));

        $response->assertStatus(200);
        $response->assertSee('id="mobileMenuBtn"', false);
        $response->assertSee('id="mobileDrawer"', false);
        $response->assertSee(route('admin.quick-count'));
        $response->assertSee(route('admin.calon-legislatif'));
    }
}
