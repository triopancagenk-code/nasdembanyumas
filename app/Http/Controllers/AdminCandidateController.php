<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Dpc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCandidateController extends Controller
{
    /**
     * Display Calon Legislatif Management Dashboard (POV Admin).
     */
    public function index(Request $request): View
    {
        $query = Candidate::query();

        // 1. Search filter
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('jabatan', 'like', "%{$q}%")
                    ->orWhere('basis_wilayah', 'like', "%{$q}%")
                    ->orWhere('slogan', 'like', "%{$q}%")
                    ->orWhere('nomor_urut', $q);
            });
        }

        // 2. Dapil filter
        if ($request->filled('dapil') && $request->dapil !== 'all') {
            $query->where('dapil', $request->dapil);
        }

        // 3. Gender filter
        if ($request->filled('gender') && in_array($request->gender, ['L', 'P'])) {
            $query->where('jenis_kelamin', $request->gender);
        }

        // 4. Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 5. Tingkat filter
        if ($request->filled('tingkat') && $request->tingkat !== 'all') {
            $query->where('tingkat', $request->tingkat);
        }

        // Sort by Dapil then Nomor Urut
        $candidates = $query->orderBy('dapil')->orderBy('nomor_urut')->get();

        // Summary Metrics
        $totalCandidates = Candidate::count();
        $totalPria = Candidate::where('jenis_kelamin', 'L')->count();
        $totalWanita = Candidate::where('jenis_kelamin', 'P')->count();
        $persenWanita = $totalCandidates > 0 ? round(($totalWanita / $totalCandidates) * 100, 1) : 0;

        $totalTargetSuara = Candidate::sum('target_suara');
        $totalSuaraMasuk = Candidate::sum('suara_masuk');
        $totalTerpilih = Candidate::where('status', 'Caleg Terpilih')->count();

        // Dapil statistics summary
        $dapilList = ['Dapil 1', 'Dapil 2', 'Dapil 3', 'Dapil 4', 'Dapil 5', 'Dapil 6'];
        $dapilStats = [];
        foreach ($dapilList as $d) {
            $cCount = Candidate::where('dapil', $d)->count();
            $wCount = Candidate::where('dapil', $d)->where('jenis_kelamin', 'P')->count();
            $dTarget = Candidate::where('dapil', $d)->sum('target_suara');
            $dSuara = Candidate::where('dapil', $d)->sum('suara_masuk');
            $dapilStats[$d] = [
                'count' => $cCount,
                'wanita' => $wCount,
                'target' => $dTarget,
                'suara' => $dSuara,
            ];
        }

        // 27 Kecamatan names for selection
        $kecamatans = Dpc::orderBy('kecamatan_name')->pluck('kecamatan_name');

        return view('admin.calon-legislatif', compact(
            'candidates', 'totalCandidates', 'totalPria', 'totalWanita', 'persenWanita',
            'totalTargetSuara', 'totalSuaraMasuk', 'totalTerpilih',
            'dapilList', 'dapilStats', 'kecamatans'
        ));
    }

    /**
     * Store new Candidate.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|string|max:100',
            'dapil' => 'required|string|max:50',
            'nomor_urut' => 'required|integer|min:1|max:50',
            'jenis_kelamin' => 'required|string|in:L,P',
            'jabatan' => 'nullable|string|max:255',
            'basis_wilayah' => 'nullable|string|max:255',
            'target_suara' => 'nullable|integer|min:0',
            'suara_masuk' => 'nullable|integer|min:0',
            'status' => 'required|string|in:DCT,Caleg Terpilih,Aktif,Mundur',
            'slogan' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'foto_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_file') && $request->file('foto_file')->isValid()) {
            $file = $request->file('foto_file');
            $filename = 'caleg_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/caleg', $filename, 'public');
            $fotoPath = '/storage/' . $path;
        }

        $candidate = Candidate::create([
            'nama' => $validated['nama'],
            'tingkat' => $validated['tingkat'],
            'dapil' => $validated['dapil'],
            'nomor_urut' => $validated['nomor_urut'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'foto' => $fotoPath,
            'jabatan' => $validated['jabatan'] ?? null,
            'basis_wilayah' => $validated['basis_wilayah'] ?? null,
            'target_suara' => $validated['target_suara'] ?? 5000,
            'suara_masuk' => $validated['suara_masuk'] ?? 0,
            'status' => $validated['status'],
            'slogan' => $validated['slogan'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
        ]);

        $message = "Calon Legislatif '{$candidate->nama}' (No. {$candidate->nomor_urut} {$candidate->dapil}) berhasil ditambahkan!";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $candidate,
            ]);
        }

        return redirect()->route('admin.calon-legislatif')->with('success', $message);
    }

    /**
     * Update an existing Candidate.
     */
    public function update(Request $request, $id): RedirectResponse|JsonResponse
    {
        $candidate = Candidate::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|string|max:100',
            'dapil' => 'required|string|max:50',
            'nomor_urut' => 'required|integer|min:1|max:50',
            'jenis_kelamin' => 'required|string|in:L,P',
            'jabatan' => 'nullable|string|max:255',
            'basis_wilayah' => 'nullable|string|max:255',
            'target_suara' => 'nullable|integer|min:0',
            'suara_masuk' => 'nullable|integer|min:0',
            'status' => 'required|string|in:DCT,Caleg Terpilih,Aktif,Mundur',
            'slogan' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'foto_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        if ($request->hasFile('foto_file') && $request->file('foto_file')->isValid()) {
            $file = $request->file('foto_file');
            $filename = 'caleg_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/caleg', $filename, 'public');
            $validated['foto'] = '/storage/' . $path;
        }

        $candidate->update($validated);

        $message = "Data Calon Legislatif '{$candidate->nama}' berhasil diperbarui.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $candidate,
            ]);
        }

        return redirect()->route('admin.calon-legislatif')->with('success', $message);
    }

    /**
     * Toggle elected status.
     */
    public function toggleElected($id): JsonResponse
    {
        $candidate = Candidate::findOrFail($id);
        $newStatus = ($candidate->status === 'Caleg Terpilih') ? 'DCT' : 'Caleg Terpilih';
        $candidate->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => "Status {$candidate->nama} berhasil diubah menjadi: {$newStatus}!",
        ]);
    }

    /**
     * Delete Candidate.
     */
    public function destroy($id): JsonResponse|RedirectResponse
    {
        $candidate = Candidate::findOrFail($id);
        $name = $candidate->nama;
        $candidate->delete();

        $message = "Calon Legislatif '{$name}' telah dihapus.";

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.calon-legislatif')->with('success', $message);
    }
}
