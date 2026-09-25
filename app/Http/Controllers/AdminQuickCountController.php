<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Dpc;
use App\Models\Dprt;
use App\Models\QuickCountParty;
use App\Models\QuickCountTps;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminQuickCountController extends Controller
{
    /**
     * Display the Quick Count Dashboard (POV Admin).
     */
    public function index(Request $request): View
    {
        // 1. Leaderboard Partai Politik di Banyumas
        $parties = QuickCountParty::orderByDesc('total_suara')->get();
        $totalSuaraSemuaPartai = max(1, $parties->sum('total_suara'));

        $nasdemParty = $parties->firstWhere('party_name', 'Partai NasDem');
        $nasdemSuara = $nasdemParty ? $nasdemParty->total_suara : 74850;
        $nasdemKursi = $nasdemParty ? $nasdemParty->kursi_dprd : 6;
        $nasdemPersen = round(($nasdemSuara / $totalSuaraSemuaPartai) * 100, 1);

        // 2. Metrik Banyumas (5.587 Total TPS di Kabupaten Banyumas)
        $totalTpsBanyumas = 5587;
        $tpsMasukCount = 4726 + QuickCountTps::count(); // Sample + real TPS
        $persenTpsMasuk = min(100.0, round(($tpsMasukCount / $totalTpsBanyumas) * 100, 1));

        // 3. Breakdown per 6 Dapil Banyumas
        $dapils = [
            'Dapil 1' => [
                'nama' => 'Dapil Banyumas 1',
                'wilayah' => 'Purwokerto Barat, Pwt Timur, Pwt Selatan, Pwt Utara, Patikraja',
                'kursi' => 8,
                'target' => 28000,
                'suara' => 18450,
                'tps_total' => 964,
                'tps_masuk' => 820,
            ],
            'Dapil 2' => [
                'nama' => 'Dapil Banyumas 2',
                'wilayah' => 'Sokaraja, Kembaran, Sumbang, Baturraden',
                'kursi' => 9,
                'target' => 31000,
                'suara' => 19820,
                'tps_total' => 1012,
                'tps_masuk' => 860,
            ],
            'Dapil 3' => [
                'nama' => 'Dapil Banyumas 3',
                'wilayah' => 'Kemranjen, Sumpiuh, Tambak, Somagede, Banyumas, Kalibagor',
                'kursi' => 9,
                'target' => 30000,
                'suara' => 18940,
                'tps_total' => 998,
                'tps_masuk' => 842,
            ],
            'Dapil 4' => [
                'nama' => 'Dapil Banyumas 4',
                'wilayah' => 'Wangon, Jatilawang, Rawalo, Kebasen',
                'kursi' => 8,
                'target' => 27000,
                'suara' => 17850,
                'tps_total' => 876,
                'tps_masuk' => 740,
            ],
            'Dapil 5' => [
                'nama' => 'Dapil Banyumas 5',
                'wilayah' => 'Ajibarang, Gumelar, Pekuncen, Lumbir',
                'kursi' => 8,
                'target' => 28000,
                'suara' => 18320,
                'tps_total' => 862,
                'tps_masuk' => 735,
            ],
            'Dapil 6' => [
                'nama' => 'Dapil Banyumas 6',
                'wilayah' => 'Cilongok, Karanglewas, Kedungbanteng, Purwojati',
                'kursi' => 8,
                'target' => 29000,
                'suara' => 21470,
                'tps_total' => 875,
                'tps_masuk' => 729,
            ],
        ];

        // Enrich dapil dengan caleg tertinggi
        foreach ($dapils as $dapilKey => &$dapilVal) {
            $topCandidate = Candidate::where('dapil', $dapilKey)
                ->orderByDesc('suara_masuk')
                ->first();
            $dapilVal['top_candidate'] = $topCandidate ? $topCandidate->nama : '-';
            $dapilVal['top_candidate_suara'] = $topCandidate ? $topCandidate->suara_masuk : 0;
            $dapilVal['persen_masuk'] = round(($dapilVal['tps_masuk'] / max(1, $dapilVal['tps_total'])) * 100, 1);
        }
        unset($dapilVal);

        // 4. Query Data TPS Terinput
        $query = QuickCountTps::query();

        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('kecamatan_name', 'like', "%{$q}%")
                    ->orWhere('desa_name', 'like', "%{$q}%")
                    ->orWhere('tps_number', 'like', "%{$q}%")
                    ->orWhere('saksi_name', 'like', "%{$q}%");
            });
        }

        if ($request->filled('dapil') && $request->dapil !== 'all') {
            $query->where('dapil', $request->dapil);
        }

        if ($request->filled('kecamatan') && $request->kecamatan !== 'all') {
            $query->where('kecamatan_name', $request->kecamatan);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $sort = $request->input('sort', 'wilayah');
        if ($sort === 'newest') {
            $query->orderByDesc('id');
        } elseif ($sort === 'suara_desc') {
            $query->orderByDesc('suara_nasdem');
        } else {
            $query->orderBy('dapil')->orderBy('kecamatan_name')->orderBy('tps_number');
        }

        $perPage = (int) $request->input('per_page', 30);
        $tpsList = $query->paginate($perPage)->withQueryString();

        // 5. Data Referensi Wilayah untuk Form Input (27 Kecamatan & Desa)
        $dpcs = Dpc::orderBy('kecamatan_name')->get();
        $desaByKecamatan = [];
        $dprts = Dprt::select('kecamatan_name', 'desa_name')->orderBy('desa_name')->get();
        foreach ($dprts as $dprt) {
            $desaByKecamatan[$dprt->kecamatan_name][] = $dprt->desa_name;
        }

        // Hitung total suara dari TPS yang tercatat di tabel
        $recordedTpsCount = QuickCountTps::count();
        $verifiedTpsCount = QuickCountTps::where('status', 'Terverifikasi')->count();
        $pendingTpsCount = QuickCountTps::where('status', 'Menunggu Verifikasi')->count();
        $totalSuaraNasdemTps = QuickCountTps::sum('suara_nasdem');
        $totalSuaraSahTps = QuickCountTps::sum('suara_sah');
        $allTpsList = QuickCountTps::orderBy('kecamatan_name')->orderBy('desa_name')->orderBy('tps_number')->get();

        return view('admin.quick-count', compact(
            'parties', 'totalSuaraSemuaPartai', 'nasdemSuara', 'nasdemKursi', 'nasdemPersen',
            'totalTpsBanyumas', 'tpsMasukCount', 'persenTpsMasuk',
            'dapils', 'tpsList', 'dpcs', 'desaByKecamatan',
            'recordedTpsCount', 'verifiedTpsCount', 'pendingTpsCount',
            'totalSuaraNasdemTps', 'totalSuaraSahTps', 'allTpsList'
        ));
    }

    /**
     * Dedicated Upload C1 PDF handler.
     */
    public function uploadC1Pdf(Request $request): RedirectResponse|JsonResponse
    {
        $mode = $request->input('mode', 'existing');

        if ($mode === 'existing') {
            $validated = $request->validate([
                'tps_id' => 'required|exists:quick_count_tps,id',
                'c1_pdf_file' => 'required|file|mimes:pdf|max:20480',
                'notes' => 'nullable|string|max:1000',
            ], [
                'tps_id.required' => 'Silakan pilih TPS yang ingin ditautkan dokumen C1 PDF.',
                'c1_pdf_file.required' => 'Berkas C1 PDF wajib diunggah.',
                'c1_pdf_file.mimes' => 'Berkas harus dalam format dokumen PDF (.pdf).',
                'c1_pdf_file.max' => 'Ukuran berkas C1 PDF maksimal 20 MB.',
            ]);

            $tps = QuickCountTps::findOrFail($validated['tps_id']);

            $file = $request->file('c1_pdf_file');
            $filename = 'c1_' . time() . '_' . Str::random(8) . '.pdf';
            $path = $file->storeAs('uploads/c1', $filename, 'public');

            $updateData = ['c1_photo' => '/storage/' . $path];
            if (!empty($validated['notes'])) {
                $updateData['notes'] = $tps->notes ? ($tps->notes . ' | ' . $validated['notes']) : $validated['notes'];
            }
            $tps->update($updateData);

            $message = "Dokumen C1 PDF berhasil diunggah dan ditautkan ke {$tps->tps_number} Desa {$tps->desa_name}!";
        } else {
            $validated = $request->validate([
                'dapil' => 'required|string|max:50',
                'kecamatan_name' => 'required|string|max:100',
                'desa_name' => 'required|string|max:100',
                'tps_number' => 'required|string|max:50',
                'total_dpt' => 'nullable|integer|min:0',
                'suara_nasdem' => 'required|integer|min:0',
                'suara_sah' => 'required|integer|min:0',
                'suara_tidak_sah' => 'nullable|integer|min:0',
                'saksi_name' => 'nullable|string|max:150',
                'saksi_phone' => 'nullable|string|max:50',
                'status' => 'required|string|in:Terverifikasi,Menunggu Verifikasi,Perlu Koreksi',
                'notes' => 'nullable|string|max:1000',
                'c1_pdf_file' => 'required|file|mimes:pdf|max:20480',
            ], [
                'c1_pdf_file.required' => 'Berkas C1 PDF wajib diunggah.',
                'c1_pdf_file.mimes' => 'Berkas harus berupa format dokumen PDF (.pdf).',
                'c1_pdf_file.max' => 'Ukuran berkas C1 PDF maksimal 20 MB.',
            ]);

            $file = $request->file('c1_pdf_file');
            $filename = 'c1_' . time() . '_' . Str::random(8) . '.pdf';
            $path = $file->storeAs('uploads/c1', $filename, 'public');

            $tps = QuickCountTps::create([
                'dapil' => $validated['dapil'],
                'kecamatan_name' => $validated['kecamatan_name'],
                'desa_name' => $validated['desa_name'],
                'tps_number' => $validated['tps_number'],
                'total_dpt' => $validated['total_dpt'] ?? 250,
                'suara_nasdem' => $validated['suara_nasdem'],
                'suara_sah' => $validated['suara_sah'],
                'suara_tidak_sah' => $validated['suara_tidak_sah'] ?? 0,
                'saksi_name' => $validated['saksi_name'] ?? null,
                'saksi_phone' => $validated['saksi_phone'] ?? null,
                'c1_photo' => '/storage/' . $path,
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $message = "Hasil TPS {$tps->tps_number} Desa {$tps->desa_name} beserta berkas C1 PDF berhasil disimpan!";
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $tps,
            ]);
        }

        return redirect()->route('admin.quick-count')->with('success', $message);
    }

    /**
     * Store new Quick Count TPS entry.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'dapil' => 'required|string|max:50',
            'kecamatan_name' => 'required|string|max:100',
            'desa_name' => 'required|string|max:100',
            'tps_number' => 'required|string|max:50',
            'total_dpt' => 'nullable|integer|min:0',
            'suara_nasdem' => 'required|integer|min:0',
            'suara_sah' => 'required|integer|min:0',
            'suara_tidak_sah' => 'nullable|integer|min:0',
            'saksi_name' => 'nullable|string|max:150',
            'saksi_phone' => 'nullable|string|max:50',
            'status' => 'required|string|in:Terverifikasi,Menunggu Verifikasi,Perlu Koreksi',
            'notes' => 'nullable|string|max:1000',
            'c1_photo_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:20480',
        ]);

        $photoPath = null;
        if ($request->hasFile('c1_photo_file') && $request->file('c1_photo_file')->isValid()) {
            $file = $request->file('c1_photo_file');
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = 'c1_' . time() . '_' . Str::random(8) . '.' . $ext;
            $path = $file->storeAs('uploads/c1', $filename, 'public');
            $photoPath = '/storage/' . $path;
        }

        $tps = QuickCountTps::create([
            'dapil' => $validated['dapil'],
            'kecamatan_name' => $validated['kecamatan_name'],
            'desa_name' => $validated['desa_name'],
            'tps_number' => $validated['tps_number'],
            'total_dpt' => $validated['total_dpt'] ?? 250,
            'suara_nasdem' => $validated['suara_nasdem'],
            'suara_sah' => $validated['suara_sah'],
            'suara_tidak_sah' => $validated['suara_tidak_sah'] ?? 0,
            'saksi_name' => $validated['saksi_name'] ?? null,
            'saksi_phone' => $validated['saksi_phone'] ?? null,
            'c1_photo' => $photoPath,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        $message = "Hasil Quick Count untuk {$tps->tps_number} Desa {$tps->desa_name}, Kec. {$tps->kecamatan_name} berhasil disimpan!";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $tps,
            ]);
        }

        return redirect()->route('admin.quick-count')->with('success', $message);
    }

    /**
     * Update an existing Quick Count TPS record.
     */
    public function update(Request $request, $id): RedirectResponse|JsonResponse
    {
        $tps = QuickCountTps::findOrFail($id);

        $validated = $request->validate([
            'dapil' => 'required|string|max:50',
            'kecamatan_name' => 'required|string|max:100',
            'desa_name' => 'required|string|max:100',
            'tps_number' => 'required|string|max:50',
            'total_dpt' => 'nullable|integer|min:0',
            'suara_nasdem' => 'required|integer|min:0',
            'suara_sah' => 'required|integer|min:0',
            'suara_tidak_sah' => 'nullable|integer|min:0',
            'saksi_name' => 'nullable|string|max:150',
            'saksi_phone' => 'nullable|string|max:50',
            'status' => 'required|string|in:Terverifikasi,Menunggu Verifikasi,Perlu Koreksi',
            'notes' => 'nullable|string|max:1000',
            'c1_photo_file' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:20480',
        ]);

        if ($request->hasFile('c1_photo_file') && $request->file('c1_photo_file')->isValid()) {
            $file = $request->file('c1_photo_file');
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = 'c1_' . time() . '_' . Str::random(8) . '.' . $ext;
            $path = $file->storeAs('uploads/c1', $filename, 'public');
            $validated['c1_photo'] = '/storage/' . $path;
        }

        $tps->update($validated);

        $message = "Data Quick Count {$tps->tps_number} Desa {$tps->desa_name} berhasil diperbarui.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $tps,
            ]);
        }

        return redirect()->route('admin.quick-count')->with('success', $message);
    }

    /**
     * Fast Verification button.
     */
    public function verify($id): JsonResponse
    {
        $tps = QuickCountTps::findOrFail($id);
        $tps->update(['status' => 'Terverifikasi']);

        return response()->json([
            'success' => true,
            'message' => "Data {$tps->tps_number} Desa {$tps->desa_name} telah BERHASIL DIVERIFIKASI!",
            'data' => $tps,
        ]);
    }

    /**
     * Delete a TPS entry.
     */
    public function destroy($id): JsonResponse|RedirectResponse
    {
        $tps = QuickCountTps::findOrFail($id);
        $tpsNum = $tps->tps_number;
        $desa = $tps->desa_name;
        $tps->delete();

        $message = "Data {$tpsNum} Desa {$desa} telah dihapus dari Quick Count.";

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.quick-count')->with('success', $message);
    }

    /**
     * Export / Print Rekapitulasi Suara C1.
     */
    public function export(Request $request): View
    {
        $dapil = $request->input('dapil', 'all');
        $query = QuickCountTps::query();
        if ($dapil !== 'all') {
            $query->where('dapil', $dapil);
        }
        $tpsList = $query->orderBy('kecamatan_name')->orderBy('desa_name')->orderBy('tps_number')->get();
        $parties = QuickCountParty::orderByDesc('total_suara')->get();

        return view('admin.quick-count-export', compact('tpsList', 'parties', 'dapil'));
    }
}
