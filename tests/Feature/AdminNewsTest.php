<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Database\Seeders\PartyDataSeeder;
use Tests\TestCase;

class AdminNewsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PartyDataSeeder::class);
    }

    public function test_admin_can_view_news_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/berita');

        $response->assertStatus(200);
        $response->assertSee('Kelola Berita');
        $response->assertSee('Publikasi NasDem');
        $response->assertSee('TOTAL ARTIKEL');
        $response->assertSee('BERITA TERBIT');
        $response->assertSee('Tambah Berita Baru');
    }

    public function test_admin_can_create_new_article_and_it_propagates_to_user_pov(): void
    {
        $admin = User::where('role', 'admin')->first();

        $title = 'Aksi Nyata NasDem Banyumas Membangun Desa Mandiri 2026';
        $excerpt = 'Inisiatif terbaru DPD NasDem Banyumas memberdayakan desa binaan dengan energi terbarukan dan pertanian presisi.';
        $content = '<p>Kegiatan peresmian program desa mandiri restorasi diresmikan langsung oleh jajaran pengurus.</p>';

        // 1. Admin creates article
        $response = $this->actingAs($admin)->post('/admin/berita', [
            'title' => $title,
            'category' => 'Kegiatan Partai',
            'excerpt' => $excerpt,
            'content' => $content,
            'status' => 'Published',
            'author_name' => 'Redaksi NasDem Banyumas',
        ]);

        $response->assertRedirect(route('admin.berita'));
        $response->assertSessionHas('success');

        // Check article exists in DB
        $article = Article::where('title', $title)->first();
        $this->assertNotNull($article);
        $this->assertEquals('Published', $article->status);
        $this->assertEquals('Kegiatan Partai', $article->category);

        // 2. Regular user sees article in News page (/berita)
        $user = User::where('role', 'pengguna')->first();
        $userNewsResp = $this->actingAs($user)->get('/berita');
        $userNewsResp->assertStatus(200);
        $userNewsResp->assertSee($title);

        // 3. Guest / public sees article in Homepage (/ news section)
        $homeResp = $this->get('/');
        $homeResp->assertStatus(200);
        $homeResp->assertSee($title);

        // 4. User can read detail article (/berita/{slug})
        $detailResp = $this->get('/berita/' . $article->slug);
        $detailResp->assertStatus(200);
        $detailResp->assertSee($title);
        $detailResp->assertSee('Kegiatan peresmian program desa mandiri');
        $detailResp->assertSee('Redaksi NasDem Banyumas');

        // Views count should increment
        $article->refresh();
        $this->assertEquals(1, $article->views_count);
    }

    public function test_admin_can_update_article(): void
    {
        $admin = User::where('role', 'admin')->first();
        $article = Article::first();

        $newTitle = 'Judul Berita Diperbarui Oleh Admin';

        $response = $this->actingAs($admin)->post('/admin/berita/' . $article->id, [
            'title' => $newTitle,
            'category' => 'Fraksi NasDem',
            'excerpt' => 'Ringkasan yang sudah direvisi.',
            'content' => '<p>Konten artikel yang baru saja disunting.</p>',
            'status' => 'Published',
            'author_name' => 'Humas Fraksi',
        ]);

        $response->assertRedirect(route('admin.berita'));

        $article->refresh();
        $this->assertEquals($newTitle, $article->title);
        $this->assertEquals('Fraksi NasDem', $article->category);
    }

    public function test_admin_can_delete_article(): void
    {
        $admin = User::where('role', 'admin')->first();
        $article = Article::first();
        $id = $article->id;

        $response = $this->actingAs($admin)->delete('/admin/berita/' . $id);

        $response->assertRedirect(route('admin.berita'));
        $this->assertNull(Article::find($id));
    }

    public function test_regular_user_cannot_access_admin_berita(): void
    {
        $user = User::where('role', 'pengguna')->first();

        $response = $this->actingAs($user)->get('/admin/berita');
        $response->assertStatus(403);
    }

    public function test_draft_articles_are_not_visible_to_public(): void
    {
        $admin = User::where('role', 'admin')->first();

        $draftTitle = 'Rahasia Internal Rapat Koordinasi Tertutup';

        $this->actingAs($admin)->post('/admin/berita', [
            'title' => $draftTitle,
            'category' => 'Internal',
            'excerpt' => 'Hanya untuk pengurus',
            'content' => '<p>Belum boleh dipublikasikan ke publik</p>',
            'status' => 'Draft',
        ]);

        // Regular user should not see draft in /berita
        $user = User::where('role', 'pengguna')->first();
        $userResp = $this->actingAs($user)->get('/berita');
        $userResp->assertStatus(200);
        $userResp->assertDontSee($draftTitle);

        // Guest attempting to access directly by slug gets 404
        $draftArticle = Article::where('title', $draftTitle)->first();
        $guestResp = $this->get('/berita/' . $draftArticle->slug);
        $guestResp->assertStatus(404);
    }
}
