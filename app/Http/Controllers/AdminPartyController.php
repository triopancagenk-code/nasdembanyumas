<?php

namespace App\Http\Controllers;

use App\Models\Dpc;
use App\Models\DpdOfficer;
use App\Models\Dprt;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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

        if (empty($validated['photo'])) {
            $validated['photo'] = null;
            if ($officer->photo && Str::contains($officer->photo, 'images/uploads/')) {
                $oldFile = public_path(ltrim($officer->photo, '/'));
                if (File::exists($oldFile)) {
                    @File::delete($oldFile);
                }
            }
        } elseif ($officer->photo && $officer->photo !== $validated['photo'] && Str::contains($officer->photo, 'images/uploads/')) {
            $oldFile = public_path(ltrim($officer->photo, '/'));
            if (File::exists($oldFile)) {
                @File::delete($oldFile);
            }
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
