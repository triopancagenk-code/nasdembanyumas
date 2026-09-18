<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\SiteContentService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPartyController extends Controller
{
    protected SiteContentService $contentService;

    public function __construct(SiteContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Visi & Misi Partai NasDem (POV Pengguna).
     */
    public function visiMisi(): View
    {
        $content = $this->contentService->getContent();
        return view('pages.visi-misi', compact('content'));
    }

    /**
     * Berita Terkini Partai NasDem (POV Pengguna).
     * Dinamis tersinkronisasi dari berita yang diinput oleh Admin.
     */
    public function berita(Request $request): View
    {
        $content = $this->contentService->getContent();

        $query = Article::published();

        // Search filter (title, excerpt, content)
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Order by latest publication date
        $articles = $query->orderByDesc('published_at')->orderByDesc('id')->paginate(9)->withQueryString();

        // Available categories with published count
        $categories = Article::published()
            ->select('category')
            ->selectRaw('count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Featured highlight (latest article if on first page and no search)
        $featuredArticle = null;
        if (!$request->filled('q') && !$request->filled('category') && $articles->currentPage() === 1 && $articles->isNotEmpty()) {
            $featuredArticle = $articles->first();
        }

        return view('pages.berita', compact('content', 'articles', 'categories', 'featuredArticle'));
    }

    /**
     * Halaman Baca Detail Berita (POV Pengguna).
     */
    public function baca(string $slug): View
    {
        $content = $this->contentService->getContent();

        // Admin can preview draft articles; regular users can only read published
        $article = Article::when(
            !auth()->check() || !auth()->user()->isAdmin(),
            fn($q) => $q->published()
        )->where('slug', $slug)->firstOrFail();

        // Increment views count
        $article->increment('views_count');

        // Recent related news for sidebar/bottom
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->when($article->category, fn($q) => $q->orderByRaw("category = '{$article->category}' DESC"))
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('pages.berita-detail', compact('content', 'article', 'relatedArticles'));
    }
}
