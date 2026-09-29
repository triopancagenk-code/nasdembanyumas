<?php

namespace App\Http\Controllers;

use App\Models\Dpc;
use App\Models\DpcOfficer;
use App\Models\DpdOfficer;
use App\Models\Dprt;
use App\Models\DprtOfficer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPartyController extends Controller
{
    /**
     * Display DPD Structure (Ketua, Wakil Ketua, Sekretaris, Wakil Sekretaris, Bendahara, Wakil Bendahara, Bappilu, OKK, dan 10 Ketua Bidang).
     */
    public function dpd(): View
    {
        $officers = DpdOfficer::orderBy('sort_order')->get();
        $intiOfficers = $officers->where('category', 'inti');
        $bidangOfficers = $officers->where('category', 'bidang');

        return view('admin.dpd', compact('officers', 'intiOfficers', 'bidangOfficers'));
    }

    /**
     * Update an officer in DPD structure.
     */
    public function updateDpd(Request $request, $id): JsonResponse
    {
        $officer = DpdOfficer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'sk_number' => 'nullable|string|max:100',
            'photo' => 'nullable|string',
            'status' => 'nullable|string|max:50',
        ]);

        $deleteOldPhoto = function (?string $photoPath) {
            if (empty($photoPath)) return;
            if (Str::contains($photoPath, 'storage/uploads/')) {
                $storageRelative = Str::after($photoPath, 'storage/');
                if (Storage::disk('public')->exists($storageRelative)) {
                    Storage::disk('public')->delete($storageRelative);
                }
            } elseif (Str::contains($photoPath, 'images/uploads/')) {
                $oldFile = public_path(ltrim($photoPath, '/'));
                if (File::exists($oldFile)) {
                    @File::delete($oldFile);
                }
            }
        };

        if (empty($validated['photo'])) {
            $validated['photo'] = null;
            if ($officer->photo) {
                $deleteOldPhoto($officer->photo);
            }
        } elseif ($officer->photo && $officer->photo !== $validated['photo']) {
            $deleteOldPhoto($officer->photo);
        }

        $officer->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Pengurus DPD berhasil diperbarui.',
            'officer' => $officer,
        ]);
    }

    /**
     * Display all 27 DPC (Kecamatan in Kabupaten Banyumas).
     */
    public function dpc(Request $request): View
    {
        $query = Dpc::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('kecamatan_name', 'like', "%{$s}%")
                  ->orWhere('ketua_name', 'like', "%{$s}%")
                  ->orWhere('sekretaris_name', 'like', "%{$s}%");
            });
        }

        if ($request->filled('dapil') && $request->input('dapil') !== 'all') {
            $query->where('dapil', $request->input('dapil'));
        }

        $dpcs = $query->orderBy('kecamatan_name')->get();
        $totalKader = Dpc::sum('total_kader');
        $totalRanting = Dpc::sum('total_ranting');

        return view('admin.dpc', compact('dpcs', 'totalKader', 'totalRanting'));
    }

    /**
     * Update a DPC record.
     */
    public function updateDpc(Request $request, $id): JsonResponse
    {
        $dpc = Dpc::findOrFail($id);

        $validated = $request->validate([
            'ketua_name' => 'required|string|max:255',
            'sekretaris_name' => 'nullable|string|max:255',
            'bendahara_name' => 'nullable|string|max:255',
            'office_address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'sk_number' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'total_kader' => 'nullable|integer',
            'total_suara' => 'nullable|integer',
            'target_suara' => 'nullable|integer',
        ]);

        $dpc->update($validated);

        return response()->json([
            'success' => true,
            'message' => "Data DPC Kecamatan {$dpc->kecamatan_name} berhasil diperbarui.",
            'dpc' => $dpc,
        ]);
    }

    /**
     * Display Pengurus DPC per Kecamatan (9 Kolom Pengurus per Kecamatan) & per Dapil.
     */
    public function dpcOfficers(Request $request): View
    {
        $dapilList = ['Dapil 1', 'Dapil 2', 'Dapil 3', 'Dapil 4', 'Dapil 5', 'Dapil 6'];
        $selectedDapil = $request->input('dapil');

        $allDpcs = Dpc::orderBy('kecamatan_name')->get();

        // Cari kecamatan jika diberikan
        $selectedDpc = null;
        if ($request->filled('kecamatan')) {
            $kecParam = $request->input('kecamatan');
            $selectedDpc = Dpc::where('kecamatan_name', $kecParam)
                ->orWhere('id', $kecParam)
                ->first();
            if ($selectedDpc && empty($selectedDapil)) {
                $selectedDapil = $selectedDpc->dapil;
            }
        }

        // Validasi dapil pilihan
        if (empty($selectedDapil) || (!in_array($selectedDapil, $dapilList) && $selectedDapil !== 'all')) {
            $selectedDapil = $selectedDpc ? $selectedDpc->dapil : 'Dapil 1';
        }

        // Ambil DPC pada Dapil yang dipilih
        if ($selectedDapil === 'all') {
            $dpcsInDapil = $allDpcs;
        } else {
            $dpcsInDapil = Dpc::where('dapil', $selectedDapil)->orderBy('kecamatan_name')->get();
        }

        // Jika selectedDpc belum ada atau tidak sesuai dapil yang dipilih
        if (!$selectedDpc || ($selectedDapil !== 'all' && $selectedDpc->dapil !== $selectedDapil)) {
            $selectedDpc = $dpcsInDapil->first() ?? $allDpcs->first();
        }

        // Pastikan DPC yang dipilih memiliki 9 slot pengurus
        if ($selectedDpc) {
            $count = DpcOfficer::where('dpc_id', $selectedDpc->id)->count();
            if ($count < 9) {
                $defaultPositions = [
                    ['sort_order' => 1, 'title' => 'Ketua DPC', 'category' => 'inti', 'name' => $selectedDpc->ketua_name ?: ('Ketua DPC Kec. ' . $selectedDpc->kecamatan_name), 'phone' => $selectedDpc->phone, 'sk_number' => $selectedDpc->sk_number],
                    ['sort_order' => 2, 'title' => 'Wakil Ketua DPC', 'category' => 'inti', 'name' => 'Wakil Ketua ' . $selectedDpc->kecamatan_name],
                    ['sort_order' => 3, 'title' => 'Sekretaris DPC', 'category' => 'inti', 'name' => $selectedDpc->sekretaris_name ?: ('Sekretaris Kec. ' . $selectedDpc->kecamatan_name)],
                    ['sort_order' => 4, 'title' => 'Wakil Sekretaris DPC', 'category' => 'inti', 'name' => 'Wakil Sekretaris ' . $selectedDpc->kecamatan_name],
                    ['sort_order' => 5, 'title' => 'Bendahara DPC', 'category' => 'inti', 'name' => $selectedDpc->bendahara_name ?: ('Bendahara Kec. ' . $selectedDpc->kecamatan_name)],
                    ['sort_order' => 6, 'title' => 'Wakil Bendahara DPC', 'category' => 'inti', 'name' => 'Wakil Bendahara ' . $selectedDpc->kecamatan_name],
                    ['sort_order' => 7, 'title' => 'Koordinator Bidang Pemenangan Pemilu (Bappilu)', 'category' => 'bidang', 'name' => 'Koor. Bappilu ' . $selectedDpc->kecamatan_name],
                    ['sort_order' => 8, 'title' => 'Koordinator Bidang OKK', 'category' => 'bidang', 'name' => 'Koor. OKK ' . $selectedDpc->kecamatan_name],
                    ['sort_order' => 9, 'title' => 'Koordinator Bidang Media & Humas', 'category' => 'bidang', 'name' => 'Koor. Media & Humas ' . $selectedDpc->kecamatan_name],
                ];

                foreach ($defaultPositions as $pos) {
                    DpcOfficer::firstOrCreate(
                        ['dpc_id' => $selectedDpc->id, 'sort_order' => $pos['sort_order']],
                        array_merge($pos, [
                            'sk_number' => $pos['sk_number'] ?? 'SK-DPC/ND-BMS/' . strtoupper(substr($selectedDpc->kecamatan_name, 0, 3)) . '/' . sprintf('%02d', $pos['sort_order']),
                            'status' => 'Aktif',
                        ])
                    );
                }
            }
        }

        $officers = $selectedDpc ? $selectedDpc->officers()->orderBy('sort_order')->get() : collect();
        $intiOfficers = $officers->where('category', 'inti');
        $bidangOfficers = $officers->where('category', 'bidang');

        // Total metrik pengurus di dapil ini
        $allOfficersInDapil = DpcOfficer::whereIn('dpc_id', $dpcsInDapil->pluck('id'))
            ->orderBy('sort_order')
            ->get()
            ->groupBy('dpc_id');

        return view('admin.dpc-officers', compact(
            'dapilList',
            'selectedDapil',
            'dpcsInDapil',
            'selectedDpc',
            'officers',
            'intiOfficers',
            'bidangOfficers',
            'allOfficersInDapil',
            'allDpcs'
        ));
    }

    /**
     * Update an officer in DPC structure (9 Kolom Pengurus).
     */
    public function updateDpcOfficer(Request $request, $id): JsonResponse
    {
        $officer = DpcOfficer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'sk_number' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:255',
            'photo' => 'nullable|string',
            'status' => 'nullable|string|max:50',
        ]);

        $deleteOldPhoto = function (?string $photoPath) {
            if (empty($photoPath)) return;
            if (Str::contains($photoPath, 'storage/uploads/')) {
                $storageRelative = Str::after($photoPath, 'storage/');
                if (Storage::disk('public')->exists($storageRelative)) {
                    Storage::disk('public')->delete($storageRelative);
                }
            } elseif (Str::contains($photoPath, 'images/uploads/')) {
                $oldFile = public_path(ltrim($photoPath, '/'));
                if (File::exists($oldFile)) {
                    @File::delete($oldFile);
                }
            }
        };

        if (empty($validated['photo'])) {
            $validated['photo'] = null;
            if ($officer->photo) {
                $deleteOldPhoto($officer->photo);
            }
        } elseif ($officer->photo && $officer->photo !== $validated['photo']) {
            $deleteOldPhoto($officer->photo);
        }

        $officer->update($validated);

        // Sinkronkan ke tabel DPC jika yang diupdate adalah Ketua, Sekretaris, atau Bendahara
        $dpc = $officer->dpc;
        if ($dpc) {
            $titleLower = strtolower($officer->title);
            if ($officer->sort_order === 1 || Str::contains($titleLower, 'ketua') && !Str::contains($titleLower, 'wakil')) {
                $dpc->update([
                    'ketua_name' => $officer->name,
                    'phone' => $officer->phone ?: $dpc->phone,
                    'sk_number' => $officer->sk_number ?: $dpc->sk_number,
                ]);
            } elseif ($officer->sort_order === 3 || Str::contains($titleLower, 'sekretaris') && !Str::contains($titleLower, 'wakil')) {
                $dpc->update(['sekretaris_name' => $officer->name]);
            } elseif ($officer->sort_order === 5 || Str::contains($titleLower, 'bendahara') && !Str::contains($titleLower, 'wakil')) {
                $dpc->update(['bendahara_name' => $officer->name]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Data Pengurus DPC {$officer->title} berhasil diperbarui.",
            'officer' => $officer,
        ]);
    }

    /**
     * Display all DPRt (Desa/Kelurahan in Kabupaten Banyumas).
     */
    public function dprt(Request $request): View
    {
        $query = Dprt::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('desa_name', 'like', "%{$s}%")
                  ->orWhere('ketua_name', 'like', "%{$s}%");
            });
        }

        if ($request->filled('kecamatan') && $request->input('kecamatan') !== 'all') {
            $query->where('kecamatan_name', $request->input('kecamatan'));
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $kecamatans = Dpc::orderBy('kecamatan_name')->pluck('kecamatan_name');
        $dprts = $query->orderBy('kecamatan_name')->orderBy('desa_name')->paginate(25)->withQueryString();

        $totalDesa = Dprt::count();
        $totalTerbentuk = Dprt::where('status', 'Terbentuk SK')->count();
        $totalMandataris = Dprt::where('status', 'Mandataris')->count();

        return view('admin.dprt', compact('dprts', 'kecamatans', 'totalDesa', 'totalTerbentuk', 'totalMandataris'));
    }

    /**
     * Update a DPRt record.
     */
    public function updateDprt(Request $request, $id): JsonResponse
    {
        $dprt = Dprt::findOrFail($id);

        $validated = $request->validate([
            'ketua_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'status' => 'required|string|max:50',
            'total_kader' => 'nullable|integer',
        ]);

        $dprt->update($validated);

        // Update total kader pada DPC induk agar selalu sinkron
        if ($dprt->dpc_id) {
            $totalDpcKader = Dprt::where('dpc_id', $dprt->dpc_id)->sum('total_kader');
            Dpc::where('id', $dprt->dpc_id)->update(['total_kader' => $totalDpcKader]);
        }

        return response()->json([
            'success' => true,
            'message' => "Data DPRt {$dprt->type} {$dprt->desa_name} berhasil diperbarui.",
            'dprt' => $dprt,
        ]);
    }

    /**
     * Display Pengurus DPRt per Desa/Kelurahan (9 Kolom Pengurus per Desa).
     */
    public function dprtOfficers(Request $request): View
    {
        $allKecamatans = Dpc::orderBy('kecamatan_name')->get();
        $selectedKecamatan = $request->input('kecamatan');
        $selectedDprt = null;

        // Jika diberikan ID langsung
        if ($request->filled('id')) {
            $selectedDprt = Dprt::with('dpc')->find($request->input('id'));
            if ($selectedDprt) {
                $selectedKecamatan = $selectedDprt->kecamatan_name;
            }
        }

        // Tentukan kecamatan
        if (empty($selectedKecamatan) || !$allKecamatans->contains('kecamatan_name', $selectedKecamatan)) {
            $selectedKecamatan = $selectedDprt ? $selectedDprt->kecamatan_name : ($allKecamatans->first()->kecamatan_name ?? 'Ajibarang');
        }

        // Ambil seluruh desa dalam kecamatan ini
        $desasInKecamatan = Dprt::where('kecamatan_name', $selectedKecamatan)->orderBy('desa_name')->get();

        // Jika selectedDprt belum ditemukan, cek dari parameter desa
        if (!$selectedDprt) {
            if ($request->filled('desa')) {
                $selectedDprt = $desasInKecamatan->where('desa_name', $request->input('desa'))->first();
            }
            if (!$selectedDprt) {
                $selectedDprt = $desasInKecamatan->first();
            }
        }

        // Pastikan DPC induk tersedia
        $parentDpc = $selectedDprt ? ($selectedDprt->dpc ?? Dpc::where('kecamatan_name', $selectedDprt->kecamatan_name)->first()) : null;

        // Pastikan ada 9 pengurus pada DPRt yang dipilih
        if ($selectedDprt) {
            $count = DprtOfficer::where('dprt_id', $selectedDprt->id)->count();
            if ($count < 9) {
                $prefix = strtoupper(substr($selectedDprt->kecamatan_name, 0, 3)) . '/' . strtoupper(substr(str_replace(' ', '', $selectedDprt->desa_name), 0, 3));
                $defaultPositions = [
                    ['sort_order' => 1, 'title' => 'Ketua DPRt', 'category' => 'inti', 'name' => $selectedDprt->ketua_name ?: ('Ketua DPRt ' . $selectedDprt->desa_name), 'phone' => $selectedDprt->phone],
                    ['sort_order' => 2, 'title' => 'Wakil Ketua DPRt', 'category' => 'inti', 'name' => 'Wakil Ketua ' . $selectedDprt->desa_name],
                    ['sort_order' => 3, 'title' => 'Sekretaris DPRt', 'category' => 'inti', 'name' => 'Sekretaris ' . $selectedDprt->desa_name],
                    ['sort_order' => 4, 'title' => 'Wakil Sekretaris DPRt', 'category' => 'inti', 'name' => 'Wakil Sekretaris ' . $selectedDprt->desa_name],
                    ['sort_order' => 5, 'title' => 'Bendahara DPRt', 'category' => 'inti', 'name' => 'Bendahara ' . $selectedDprt->desa_name],
                    ['sort_order' => 6, 'title' => 'Wakil Bendahara DPRt', 'category' => 'inti', 'name' => 'Wakil Bendahara ' . $selectedDprt->desa_name],
                    ['sort_order' => 7, 'title' => 'Koordinator Bidang Bappilu (Pemenangan Pemilu Desa)', 'category' => 'bidang', 'name' => 'Koor. Bappilu ' . $selectedDprt->desa_name],
                    ['sort_order' => 8, 'title' => 'Koordinator Bidang OKK (Kaderisasi Desa)', 'category' => 'bidang', 'name' => 'Koor. OKK ' . $selectedDprt->desa_name],
                    ['sort_order' => 9, 'title' => 'Koordinator Bidang Media & Humas Desa', 'category' => 'bidang', 'name' => 'Koor. Humas ' . $selectedDprt->desa_name],
                ];

                foreach ($defaultPositions as $pos) {
                    DprtOfficer::firstOrCreate(
                        ['dprt_id' => $selectedDprt->id, 'sort_order' => $pos['sort_order']],
                        array_merge($pos, [
                            'sk_number' => 'SK-DPRT/ND/' . $prefix . '/' . sprintf('%02d', $pos['sort_order']),
                            'status' => 'Aktif',
                        ])
                    );
                }
            }
        }

        $officers = $selectedDprt ? $selectedDprt->officers()->orderBy('sort_order')->get() : collect();
        $intiOfficers = $officers->where('category', 'inti');
        $bidangOfficers = $officers->where('category', 'bidang');

        return view('admin.dprt-officers', compact(
            'allKecamatans',
            'selectedKecamatan',
            'desasInKecamatan',
            'selectedDprt',
            'parentDpc',
            'officers',
            'intiOfficers',
            'bidangOfficers'
        ));
    }

    /**
     * Update an officer in DPRt structure (9 Kolom Pengurus Desa).
     */
    public function updateDprtOfficer(Request $request, $id): JsonResponse
    {
        $officer = DprtOfficer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'sk_number' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:255',
            'photo' => 'nullable|string',
            'status' => 'nullable|string|max:50',
        ]);

        $deleteOldPhoto = function (?string $photoPath) {
            if (empty($photoPath)) return;
            if (Str::contains($photoPath, 'storage/uploads/')) {
                $storageRelative = Str::after($photoPath, 'storage/');
                if (Storage::disk('public')->exists($storageRelative)) {
                    Storage::disk('public')->delete($storageRelative);
                }
            } elseif (Str::contains($photoPath, 'images/uploads/')) {
                $oldFile = public_path(ltrim($photoPath, '/'));
                if (File::exists($oldFile)) {
                    @File::delete($oldFile);
                }
            }
        };

        if (empty($validated['photo'])) {
            $validated['photo'] = null;
            if ($officer->photo) {
                $deleteOldPhoto($officer->photo);
            }
        } elseif ($officer->photo && $officer->photo !== $validated['photo']) {
            $deleteOldPhoto($officer->photo);
        }

        $officer->update($validated);

        // Sinkronkan ke tabel dprts jika yang diupdate adalah Ketua DPRt
        $dprt = $officer->dprt;
        if ($dprt) {
            $titleLower = strtolower($officer->title);
            if ($officer->sort_order === 1 || Str::contains($titleLower, 'ketua') && !Str::contains($titleLower, 'wakil')) {
                $dprt->update([
                    'ketua_name' => $officer->name,
                    'phone' => $officer->phone ?: $dprt->phone,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Data Pengurus DPRt {$officer->title} berhasil diperbarui.",
            'officer' => $officer,
        ]);
    }

    /**
     * Display Party Statistics (Wilayah, Kader & Suara).
     */
    public function statistik(): View
    {
        // 1. Statistik Wilayah
        $totalDpd = 1;
        $totalDpc = Dpc::count(); // 27
        $totalDprt = Dprt::count(); // 331 desa/kelurahan
        $dprtTerbentuk = Dprt::where('status', 'Terbentuk SK')->count();
        $dprtMandataris = Dprt::where('status', 'Mandataris')->count();
        $persentaseWilayah = round(($dprtTerbentuk / max(1, $totalDprt)) * 100, 1);

        // Dapil breakdown (Kecamatan, Desa, Kader, Suara)
        $dapilStats = Dpc::selectRaw('dapil, count(*) as total_dpc, sum(total_ranting) as total_ranting, sum(total_kader) as total_kader, sum(total_suara) as total_suara, sum(target_suara) as total_target')
            ->groupBy('dapil')
            ->orderBy('dapil')
            ->get();

        // 2. Statistik Anggota & Kader
        $totalKader = (int) Dpc::sum('total_kader');
        $ktaVerified = round($totalKader * 0.92);
        $kaderPria = round($totalKader * 0.54);
        $kaderWanita = $totalKader - $kaderPria;
        $persenWanita = round(($kaderWanita / max(1, $totalKader)) * 100, 1);

        // Demografi Usia
        $usiaGenZ = round($totalKader * 0.42); // 17 - 35
        $usiaDewasa = round($totalKader * 0.38); // 36 - 50
        $usiaSenior = max(0, $totalKader - ($usiaGenZ + $usiaDewasa)); // > 50

        // 3. Statistik Suara Partai / Kader di 27 Kecamatan
        $totalSuara = (int) Dpc::sum('total_suara');
        $totalTargetSuara = (int) Dpc::sum('target_suara');
        $avgKader = round(Dpc::avg('total_kader'));
        $avgSuara = round(Dpc::avg('total_suara'));
        $rasioKabupaten = round($totalSuara / max(1, $totalKader), 2);
        $persenTargetKabupaten = round(($totalSuara / max(1, $totalTargetSuara)) * 100, 1);

        // 27 Kecamatan lengkap dengan data kader & suara
        $allDpc = Dpc::orderByDesc('total_suara')->get();
        $allDpcKader = Dpc::orderByDesc('total_kader')->get();
        $topDpc = $allDpcKader->take(5);

        // Ringkasan Juara & Potensi
        $maxDpc = $allDpcKader->first(); // Terbanyak kader
        $minDpc = $allDpcKader->last();  // Terendah kader
        $maxSuaraDpc = $allDpc->first(); // Terbanyak suara
        $minSuaraDpc = $allDpc->last();  // Terendah suara

        return view('admin.statistik', compact(
            'totalDpd', 'totalDpc', 'totalDprt', 'dprtTerbentuk', 'dprtMandataris', 'persentaseWilayah',
            'dapilStats', 'totalKader', 'ktaVerified', 'kaderPria', 'kaderWanita', 'persenWanita',
            'usiaGenZ', 'usiaDewasa', 'usiaSenior', 'topDpc',
            'allDpc', 'allDpcKader', 'maxDpc', 'minDpc', 'avgKader',
            'totalSuara', 'totalTargetSuara', 'avgSuara', 'maxSuaraDpc', 'minSuaraDpc',
            'rasioKabupaten', 'persenTargetKabupaten'
        ));
    }
}
