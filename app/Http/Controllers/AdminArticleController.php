<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminArticleController extends Controller
{
    /**
     * Default list of news categories.
     */
    protected array $defaultCategories = [
        'Kegiatan Partai',
        'Konsolidasi & Kaderisasi',
        'Fraksi NasDem',
        'NasDem Peduli',
        'DPD NasDem Banyumas',
        'Sayap Partai',
        'Kebijakan Publik',
        'Pendidikan Politik',
    ];

    /**
     * Display News Management Dashboard (POV Admin).
     */
    public function index(Request $request): View
    {
        $query = Article::query();

        // Search filter (title, excerpt, content, author)
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%")
                    ->orWhere('author_name', 'like', "%{$q}%");
            });
        }

        // Category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Status filter
        if ($request->filled('status') && in_array($request->status, ['Published', 'Draft'])) {
            $query->where('status', $request->status);
        }

        // Sort by publication date desc
        $articles = $query->orderByDesc('published_at')->orderByDesc('id')->paginate(10)->withQueryString();

        // Summary statistics
        $stats = [
            'total' => Article::count(),
            'published' => Article::where('status', 'Published')->count(),
            'draft' => Article::where('status', 'Draft')->count(),
            'views' => (int) Article::sum('views_count'),
        ];

        // Unique categories from database merged with default
        $dbCategories = Article::select('category')->distinct()->pluck('category')->filter()->toArray();
        $categories = array_values(array_unique(array_merge($this->defaultCategories, $dbCategories)));

        return view('admin.berita', compact('articles', 'stats', 'categories'));
    }

    /**
     * Store a newly created article (POV Admin).
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:600',
            'content' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'image' => 'nullable|string',
            'author_name' => 'nullable|string|max:100',
            'published_at' => 'nullable|date',
            'status' => 'required|in:Published,Draft',
        ]);

        // Handle Image Upload
        $imagePath = $validated['image'] ?? 'images/congress.jpg';

        if ($request->hasFile('image_file')) {
            $uploadDir = public_path('images/uploads');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $file = $request->file('image_file');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'news_' . time() . '_' . Str::random(8) . '.' . $ext;
            $file->move($uploadDir, $filename);
            $imagePath = 'images/uploads/' . $filename;
        }

        // Auto Excerpt if empty
        $excerpt = $validated['excerpt'];
        if (empty($excerpt)) {
            $plainText = strip_tags($validated['content']);
            $excerpt = Str::limit($plainText, 160);
        }

        $author = !empty($validated['author_name'])
            ? $validated['author_name']
            : (auth()->user()->name ?? 'Humas DPD NasDem Banyumas');

        $publishedAt = !empty($validated['published_at'])
            ? $validated['published_at']
            : now()->toDateString();

        $slug = Article::makeUniqueSlug($validated['title']);

        $article = Article::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'excerpt' => $excerpt,
            'content' => $validated['content'],
            'image' => $imagePath,
            'author_name' => $author,
            'published_at' => $publishedAt,
            'status' => $validated['status'],
            'views_count' => 0,
        ]);

        $message = "Berita '{$article->title}' berhasil ditambahkan dan langsung tersebar ke POV Pengguna!";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'article' => $article,
            ]);
        }

        return redirect()->route('admin.berita')->with('success', $message);
    }

    /**
     * Update an existing article (POV Admin).
     */
    public function update(Request $request, $id): RedirectResponse|JsonResponse
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:600',
            'content' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'image' => 'nullable|string',
            'author_name' => 'nullable|string|max:100',
            'published_at' => 'nullable|date',
            'status' => 'required|in:Published,Draft',
        ]);

        // Handle Image Replacement
        if ($request->hasFile('image_file')) {
            $uploadDir = public_path('images/uploads');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            // Remove old uploaded image if present
            if ($article->image && Str::contains($article->image, 'images/uploads/')) {
                $oldFile = public_path(ltrim($article->image, '/'));
                if (File::exists($oldFile)) {
                    @File::delete($oldFile);
                }
            }

            $file = $request->file('image_file');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'news_' . time() . '_' . Str::random(8) . '.' . $ext;
            $file->move($uploadDir, $filename);
            $article->image = 'images/uploads/' . $filename;
        } elseif ($request->filled('image')) {
            $article->image = $request->input('image');
        }

        // Regenerate slug if title changed
        if ($article->title !== $validated['title']) {
            $article->slug = Article::makeUniqueSlug($validated['title'], $article->id);
        }

        // Auto Excerpt if empty
        $excerpt = $validated['excerpt'];
        if (empty($excerpt)) {
            $plainText = strip_tags($validated['content']);
            $excerpt = Str::limit($plainText, 160);
        }

        $article->title = $validated['title'];
        $article->category = $validated['category'];
        $article->excerpt = $excerpt;
        $article->content = $validated['content'];
        $article->author_name = !empty($validated['author_name']) ? $validated['author_name'] : $article->author_name;
        $article->published_at = !empty($validated['published_at']) ? $validated['published_at'] : $article->published_at;
        $article->status = $validated['status'];
        $article->save();

        $message = "Berita '{$article->title}' berhasil diperbarui!";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'article' => $article,
            ]);
        }

        return redirect()->route('admin.berita')->with('success', $message);
    }

    /**
     * Delete an article (POV Admin).
     */
    public function destroy(Request $request, $id): RedirectResponse|JsonResponse
    {
        $article = Article::findOrFail($id);
        $title = $article->title;

        // Clean up uploaded image if exists
        if ($article->image && Str::contains($article->image, 'images/uploads/')) {
            $oldFile = public_path(ltrim($article->image, '/'));
            if (File::exists($oldFile)) {
                @File::delete($oldFile);
            }
        }

        $article->delete();

        $message = "Berita '{$title}' berhasil dihapus.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.berita')->with('success', $message);
    }
}
