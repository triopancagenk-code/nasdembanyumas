<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image',
        'gallery',
        'author_name',
        'published_at',
        'status',
        'views_count',
    ];

    protected $casts = [
        'published_at' => 'date',
        'views_count' => 'integer',
        'gallery' => 'array',
    ];

    protected $appends = [
        'image_url',
        'gallery_urls',
    ];

    /**
     * Scope query untuk berita terpublikasi.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }

    /**
     * Generate unique slug from title.
     */
    public static function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        if (empty($base)) {
            $base = 'berita-' . time();
        }

        $slug = $base;
        $count = 1;

        while (static::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Helper URL gambar utama.
     */
    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            if (Str::startsWith($this->image, ['http://', 'https://'])) {
                return $this->image;
            }
            return asset(ltrim($this->image, '/'));
        }

        return asset('images/congress.jpg');
    }

    /**
     * Helper URL array untuk galeri foto dokumentasi.
     *
     * @return array<int, string>
     */
    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery) || !is_array($this->gallery)) {
            return [];
        }

        return array_values(array_filter(array_map(function ($path) {
            if (empty($path)) {
                return null;
            }
            if (Str::startsWith($path, ['http://', 'https://'])) {
                return $path;
            }
            return asset(ltrim($path, '/'));
        }, $this->gallery)));
    }
}
