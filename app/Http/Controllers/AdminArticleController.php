<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'author_name' => 'nullable|string|max:100',
            'published_at' => 'nullable|date',
            'status' => 'required|in:Published,Draft',
        ]);

        // Handle Primary Image Upload
        $imagePath = $validated['image'] ?? 'images/congress.jpg';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'news_' . time() . '_' . Str::random(8) . '.' . $ext;
            $path = $file->storeAs('uploads', $filename, 'public');
            $imagePath = 'storage/' . $path;
        }

        // Handle Additional Gallery Images (Multiple Photos)
        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $gExt = strtolower($gFile->getClientOriginalExtension() ?: 'jpg');
                    $gFilename = 'news_gallery_' . time() . '_' . Str::random(8) . '.' . $gExt;
                    $gPath = $gFile->storeAs('uploads', $gFilename, 'public');
                    $gallery[] = 'storage/' . $gPath;
                }
            }
        }

        // Auto Excerpt if empty
        $excerpt = $validated['excerpt'] ?? null;
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
            'gallery' => !empty($gallery) ? $gallery : null,
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
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'existing_gallery' => 'nullable|array',
            'author_name' => 'nullable|string|max:100',
            'published_at' => 'nullable|date',
            'status' => 'required|in:Published,Draft',
        ]);

        // Handle Primary Image Replacement
        if ($request->hasFile('image_file')) {
            // Remove old uploaded image if present
            if ($article->image) {
                if (Str::contains($article->image, 'storage/uploads/')) {
                    $storageRelative = Str::after($article->image, 'storage/');
                    if (Storage::disk('public')->exists($storageRelative)) {
                        Storage::disk('public')->delete($storageRelative);
                    }
                } elseif (Str::contains($article->image, 'images/uploads/')) {
                    $oldFile = public_path(ltrim($article->image, '/'));
                    if (File::exists($oldFile)) {
                        @File::delete($oldFile);
                    }
                }
            }

            $file = $request->file('image_file');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'news_' . time() . '_' . Str::random(8) . '.' . $ext;
            $path = $file->storeAs('uploads', $filename, 'public');
            $article->image = 'storage/' . $path;
        } elseif ($request->filled('image')) {
            $article->image = $request->input('image');
        }

        // Handle Gallery (Multiple Additional Photos)
        $currentGallery = is_array($article->gallery) ? $article->gallery : [];
        $keptGallery = [];

        // Check retained existing gallery items
        if ($request->has('existing_gallery')) {
            $submittedExisting = (array) $request->input('existing_gallery', []);
            foreach ($currentGallery as $oldPath) {
                if (in_array($oldPath, $submittedExisting)) {
                    $keptGallery[] = $oldPath;
                } else {
                    // Removed by user, delete file from storage if it is in uploads
                    if (Str::contains($oldPath, 'storage/uploads/')) {
                        $storageRelative = Str::after($oldPath, 'storage/');
                        if (Storage::disk('public')->exists($storageRelative)) {
                            Storage::disk('public')->delete($storageRelative);
                        }
                    }
                }
            }
        } elseif (!$request->hasFile('gallery_files') && !$request->has('clear_gallery')) {
            // If existing_gallery was not sent and clear_gallery flag not sent, keep existing
            $keptGallery = $currentGallery;
        } elseif ($request->has('clear_gallery')) {
            // User cleared all gallery photos
            foreach ($currentGallery as $oldPath) {
                if (Str::contains($oldPath, 'storage/uploads/')) {
                    $storageRelative = Str::after($oldPath, 'storage/');
                    if (Storage::disk('public')->exists($storageRelative)) {
                        Storage::disk('public')->delete($storageRelative);
                    }
                }
            }
        }

        // Add newly uploaded gallery photos
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $gExt = strtolower($gFile->getClientOriginalExtension() ?: 'jpg');
                    $gFilename = 'news_gallery_' . time() . '_' . Str::random(8) . '.' . $gExt;
                    $gPath = $gFile->storeAs('uploads', $gFilename, 'public');
                    $keptGallery[] = 'storage/' . $gPath;
                }
            }
        }

        $article->gallery = !empty($keptGallery) ? array_values(array_unique($keptGallery)) : null;

        // Regenerate slug if title changed
        if ($article->title !== $validated['title']) {
            $article->slug = Article::makeUniqueSlug($validated['title'], $article->id);
        }

        // Auto Excerpt if empty
        $excerpt = $validated['excerpt'] ?? null;
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

        // Clean up uploaded primary image if exists
        if ($article->image) {
            if (Str::contains($article->image, 'storage/uploads/')) {
                $storageRelative = Str::after($article->image, 'storage/');
                if (Storage::disk('public')->exists($storageRelative)) {
                    Storage::disk('public')->delete($storageRelative);
                }
            } elseif (Str::contains($article->image, 'images/uploads/')) {
                $oldFile = public_path(ltrim($article->image, '/'));
                if (File::exists($oldFile)) {
                    @File::delete($oldFile);
                }
            }
        }

        // Clean up uploaded gallery images if exist
        if (!empty($article->gallery) && is_array($article->gallery)) {
            foreach ($article->gallery as $galPath) {
                if (Str::contains($galPath, 'storage/uploads/')) {
                    $storageRelative = Str::after($galPath, 'storage/');
                    if (Storage::disk('public')->exists($storageRelative)) {
                        Storage::disk('public')->delete($storageRelative);
                    }
                }
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
