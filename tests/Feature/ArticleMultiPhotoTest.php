<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleMultiPhotoTest extends TestCase
{
    public function test_admin_can_update_article_with_multiple_gallery_photos(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $article = Article::create([
            'title' => 'Uji Coba Multi Foto Berita',
            'slug' => 'uji-coba-multi-foto-berita',
            'category' => 'Kegiatan Partai',
            'excerpt' => 'Ringkasan berita uji coba multi foto',
            'content' => '<p>Konten berita uji coba multi foto dokumentasi.</p>',
            'image' => 'images/congress.jpg',
            'author_name' => 'Humas NasDem',
            'published_at' => now(),
            'status' => 'Published',
        ]);

        $photo1 = UploadedFile::fake()->image('foto1.jpg', 600, 400);
        $photo2 = UploadedFile::fake()->image('foto2.png', 600, 400);
        $photo3 = UploadedFile::fake()->image('foto3.webp', 600, 400);

        $response = $this->actingAs($admin)
            ->post("/admin/berita/{$article->id}", [
                'title' => 'Uji Coba Multi Foto Berita Updated',
                'category' => 'Kegiatan Partai',
                'content' => '<p>Konten berita uji coba multi foto dokumentasi.</p>',
                'status' => 'Published',
                'gallery_files' => [$photo1, $photo2, $photo3],
            ]);

        $response->assertRedirect(route('admin.berita'));
        $response->assertSessionHas('success');

        $article->refresh();
        $this->assertNotNull($article->gallery);
        $this->assertIsArray($article->gallery);
        $this->assertCount(3, $article->gallery);
        $this->assertCount(3, $article->gallery_urls);

        // Verify public detail view shows the gallery
        $detailResponse = $this->get("/berita/{$article->slug}");
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Galeri Foto Dokumentasi Kegiatan');
        $detailResponse->assertSee('3 FOTO');

        // Test removing one photo and keeping two
        $keptGallery = [$article->gallery[0], $article->gallery[1]];
        $updateResponse = $this->actingAs($admin)
            ->post("/admin/berita/{$article->id}", [
                'title' => 'Uji Coba Multi Foto Berita Updated',
                'category' => 'Kegiatan Partai',
                'content' => '<p>Konten berita uji coba multi foto dokumentasi.</p>',
                'status' => 'Published',
                'existing_gallery' => $keptGallery,
            ]);

        $article->refresh();
        $this->assertCount(2, $article->gallery);
    }
}
