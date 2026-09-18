<?php

use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\AdminPartyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicPartyController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Partai NasDem Banyumas)
|--------------------------------------------------------------------------
*/

// POV Pengguna & Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/visi-misi', [PublicPartyController::class, 'visiMisi'])->name('visi-misi');
Route::get('/berita', [PublicPartyController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [PublicPartyController::class, 'baca'])->name('berita.detail');

// Quick Demo Login for instant role switching
Route::get('/quick-login/{role}', [AuthenticatedSessionController::class, 'quickLogin'])->name('quick-login');

// Admin in-place editor API routes
Route::post('/admin/save-content', [AdminContentController::class, 'save'])->name('admin.content.save');
Route::post('/admin/upload-image', [AdminContentController::class, 'uploadImage'])->name('admin.content.upload');
Route::post('/admin/reset-content', [AdminContentController::class, 'reset'])->name('admin.content.reset');

// POV Admin Feature Routes (DPD, DPC, DPRt, Statistik, Berita)
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // 1. DPD
    Route::get('/dpd', [AdminPartyController::class, 'dpd'])->name('dpd');
    Route::post('/dpd/{id}', [AdminPartyController::class, 'updateDpd'])->name('dpd.update');

    // 2. DPC (27 Kecamatan)
    Route::get('/dpc', [AdminPartyController::class, 'dpc'])->name('dpc');
    Route::post('/dpc/{id}', [AdminPartyController::class, 'updateDpc'])->name('dpc.update');

    // 3. DPRt (331 Desa/Kelurahan)
    Route::get('/dprt', [AdminPartyController::class, 'dprt'])->name('dprt');
    Route::post('/dprt/{id}', [AdminPartyController::class, 'updateDprt'])->name('dprt.update');

    // 4. Statistik (Wilayah & Anggota)
    Route::get('/statistik', [AdminPartyController::class, 'statistik'])->name('statistik');

    // 5. Berita (Manajemen Berita & Publikasi ke POV Pengguna)
    Route::get('/berita', [AdminArticleController::class, 'index'])->name('berita');
    Route::post('/berita', [AdminArticleController::class, 'store'])->name('berita.store');
    Route::post('/berita/{id}', [AdminArticleController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [AdminArticleController::class, 'destroy'])->name('berita.destroy');
});

// Dashboard alias for Breeze redirects
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
