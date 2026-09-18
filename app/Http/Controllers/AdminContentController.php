<?php

namespace App\Http\Controllers;

use App\Services\SiteContentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminContentController extends Controller
{
    protected SiteContentService $contentService;

    public function __construct(SiteContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * Save updated website content JSON.
     */
    public function save(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        if (empty($data)) {
            $data = $request->all();
        }

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Data konten kosong atau format tidak valid.'
            ], 422);
        }

        $saved = $this->contentService->saveContent($data);

        if ($saved) {
            return response()->json([
                'success' => true,
                'message' => 'Semua perubahan konten website berhasil disimpan!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan perubahan ke server.'
        ], 500);
    }

    /**
     * Upload an image file for hero slides, news, or logo.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $uploadDir = public_path('images/uploads');
        if (!File::isDirectory($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        // 1. Standard Multipart File Upload
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:10240',
            ]);

            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'officer_' . time() . '_' . Str::random(8) . '.' . $ext;
            $file->move($uploadDir, $filename);

            $relativeUrl = '/images/uploads/' . $filename;
            $url = asset('images/uploads/' . $filename);

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diunggah.',
                'url' => $url,
                'relative_url' => $relativeUrl,
                'filename' => $filename,
            ]);
        }

        // 2. Base64 Cropped Image Upload (canvas.toDataURL)
        if ($request->filled('image_base64')) {
            $base64Data = $request->input('image_base64');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
                $rawBase64 = substr($base64Data, strpos($base64Data, ',') + 1);
                $ext = strtolower($type[1]);
                if ($ext === 'jpeg') $ext = 'jpg';
                $decoded = base64_decode($rawBase64);

                if ($decoded !== false) {
                    $filename = 'officer_' . time() . '_' . Str::random(8) . '.' . $ext;
                    File::put($uploadDir . '/' . $filename, $decoded);

                    $relativeUrl = '/images/uploads/' . $filename;
                    $url = asset('images/uploads/' . $filename);

                    return response()->json([
                        'success' => true,
                        'message' => 'Gambar hasil crop berhasil diunggah.',
                        'url' => $url,
                        'relative_url' => $relativeUrl,
                        'filename' => $filename,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada berkas gambar yang diunggah.',
        ], 400);
    }

    /**
     * Reset site content to default settings.
     */
    public function reset(): JsonResponse
    {
        $this->contentService->resetContent();

        return response()->json([
            'success' => true,
            'message' => 'Konten situs telah di-reset ke pengaturan awal Partai NasDem.',
            'data' => $this->contentService->getDefaultContent(),
        ]);
    }
}
