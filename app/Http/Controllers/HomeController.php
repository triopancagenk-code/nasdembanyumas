<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\SiteContentService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected SiteContentService $contentService;

    public function __construct(SiteContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function index()
    {
        $content = $this->contentService->getContent();

        // Ambil berita terbaru yang dipublikasikan oleh Admin
        $latestNews = Article::published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(4)
            ->get();

        return view('pages.home', compact('content', 'latestNews'));
    }
}
