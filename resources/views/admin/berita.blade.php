@extends('layouts.app')

@section('title', 'Kelola Berita – POV Admin DPD Partai NasDem Banyumas')

@push('styles')
<style>
    #editArticleModal input,
    #editArticleModal select,
    #editArticleModal textarea,
    #createArticleModal input,
    #createArticleModal select,
    #createArticleModal textarea {
        color: #000000 !important;
        -webkit-text-fill-color: #000000 !important;
        background-color: #ffffff !important;
    }
    #editArticleModal select option,
    #createArticleModal select option {
        color: #000000 !important;
        background-color: #ffffff !important;
    }
    #editArticleModal input::placeholder,
    #editArticleModal textarea::placeholder,
    #createArticleModal input::placeholder,
    #createArticleModal textarea::placeholder {
        color: #64748b !important;
        -webkit-text-fill-color: #64748b !important;
    }
</style>
@endpush

@section('content')

{{-- Admin Top Banner --}}
<div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 110px 20px 40px; border-bottom: 3px solid #ffb700;">
    <div style="max-width: 1300px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                    POV ADMIN
                </span>
                <span style="color: #94a3b8; font-size: 13px;">Manajemen Berita &amp; Publikasi Real-Time</span>
            </div>
            <h1 style="font-size: 32px; font-weight: 900; color: #ffffff; margin: 0 0 6px 0;">
                Kelola Berita &amp; <span style="color: #ffb700;">Publikasi NasDem</span>
            </h1>
            <p style="font-size: 14px; color: #cbd5e1; margin: 0; max-width: 700px;">
                Tambahkan kegiatan, siaran pers, atau kabar fraksi. Berita berstatus <strong>Published</strong> akan otomatis tersebar langsung ke Beranda dan Halaman Berita POV Pengguna.
            </p>
        </div>

        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('berita') }}" target="_blank" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 10px 18px; display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 800;">
                <span>👁️ Lihat di POV Pengguna</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            </a>
            <button type="button" onclick="openCreateModal()" class="btn-yellow" style="padding: 10px 20px; border-radius: 8px; font-weight: 900; font-size: 13.5px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(255, 183, 0, 0.35);">
                <span style="font-size: 16px;">➕</span>
                <span>Tambah Berita Baru</span>
            </button>
        </div>
    </div>
</div>

<div style="max-width: 1300px; margin: 40px auto 80px; padding: 0 20px;">

    {{-- Flash Notifications --}}
    @if(session('success'))
        <div style="background: linear-gradient(135deg, #065f46 0%, #047857 100%); color: #ffffff; padding: 16px 20px; border-radius: 12px; margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 8px 20px rgba(6, 95, 70, 0.2); border-left: 6px solid #34d399;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span style="font-size: 24px;">✅</span>
                <div>
                    <div style="font-weight: 800; font-size: 15px;">Berhasil Diperbarui!</div>
                    <div style="font-size: 13.5px; opacity: 0.95;">{{ session('success') }}</div>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ffffff; font-size: 20px; cursor: pointer; opacity: 0.8;">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div style="background: #ef4444; color: #ffffff; padding: 16px 20px; border-radius: 12px; margin-bottom: 28px;">
            <div style="font-weight: 800; margin-bottom: 6px;">⚠️ Terdapat kesalahan pengisian data:</div>
            <ul style="margin: 0; padding-left: 20px; font-size: 13.5px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 4 Stats Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 32px;">
        <div style="background: #ffffff; border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px;">TOTAL ARTIKEL</span>
                <span style="font-size: 22px;">📰</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #001333; margin: 8px 0 4px;">{{ $stats['total'] }} Berita</div>
            <span style="font-size: 12px; color: #64748b; font-weight: 600;">Arsip lengkap partai</span>
        </div>

        <div style="background: #ffffff; border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); border-top: 4px solid #10b981;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #047857; text-transform: uppercase; letter-spacing: 0.8px;">BERITA TERBIT (LIVE)</span>
                <span style="font-size: 22px;">🟢</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #047857; margin: 8px 0 4px;">{{ $stats['published'] }} Berita</div>
            <span style="font-size: 12px; color: #059669; font-weight: 700;">Tampil langsung di POV Pengguna</span>
        </div>

        <div style="background: #ffffff; border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); border-top: 4px solid #f59e0b;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #b45309; text-transform: uppercase; letter-spacing: 0.8px;">DRAF BELUM TERBIT</span>
                <span style="font-size: 22px;">📝</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #b45309; margin: 8px 0 4px;">{{ $stats['draft'] }} Berita</div>
            <span style="font-size: 12px; color: #d97706; font-weight: 600;">Tersimpan privat di admin</span>
        </div>

        <div style="background: #ffffff; border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 22px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); border-top: 4px solid #3b82f6;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 11px; font-weight: 800; color: #1d4ed8; text-transform: uppercase; letter-spacing: 0.8px;">TOTAL PEMBACA (VIEWS)</span>
                <span style="font-size: 22px;">👁️</span>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #1e3a8a; margin: 8px 0 4px;">{{ number_format($stats['views']) }}</div>
            <span style="font-size: 12px; color: #2563eb; font-weight: 600;">Jangkauan tayangan kader &amp; publik</span>
        </div>
    </div>

    {{-- Filter & Search Panel --}}
    <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 20px; margin-bottom: 26px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
        <form action="{{ route('admin.berita') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 14px; align-items: center;">
            <div style="flex: 1; min-width: 250px; position: relative;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita, penulis, isi konten..." style="width: 100%; padding: 11px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
            </div>

            <div style="min-width: 180px;">
                <select name="category" style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background-color: #ffffff; color: #000000; -webkit-text-fill-color: #000000;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div style="min-width: 140px;">
                <select name="status" style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background-color: #ffffff; color: #000000; -webkit-text-fill-color: #000000;">
                    <option value="">Semua Status</option>
                    <option value="Published" {{ request('status') == 'Published' ? 'selected' : '' }}>🟢 Published</option>
                    <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>🟡 Draft</option>
                </select>
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" class="admin-btn admin-btn-primary" style="padding: 11px 20px; font-weight: 800; font-size: 13.5px;">
                    Filter
                </button>
                @if(request('q') || request('category') || request('status'))
                    <a href="{{ route('admin.berita') }}" class="admin-btn admin-btn-light" style="text-decoration: none; padding: 11px 16px; font-size: 13.5px;">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- News Table / List --}}
    <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.03);">
        <div style="padding: 18px 24px; background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 900; color: #001333; font-size: 16px;">
                Daftar Berita ({{ $articles->total() }} Data)
            </div>
            <span style="font-size: 13px; color: #64748b;">
                Menampilkan halaman {{ $articles->currentPage() }} dari {{ $articles->lastPage() }}
            </span>
        </div>

        @if($articles->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="background: #f1f5f9; color: #475569; font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px; border-bottom: 1.5px solid #e2e8f0;">
                            <th style="padding: 14px 18px; width: 80px;">Foto</th>
                            <th style="padding: 14px 18px;">Judul &amp; Ringkasan</th>
                            <th style="padding: 14px 18px; width: 170px;">Kategori</th>
                            <th style="padding: 14px 18px; width: 130px;">Status</th>
                            <th style="padding: 14px 18px; width: 150px;">Publikasi &amp; Penulis</th>
                            <th style="padding: 14px 18px; width: 90px; text-align: center;">Views</th>
                            <th style="padding: 14px 18px; width: 180px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="divide-y: 1px solid #f1f5f9;">
                        @foreach($articles as $art)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='#ffffff';">
                                {{-- Thumbnail --}}
                                <td style="padding: 16px 18px; vertical-align: top;">
                                    <div style="width: 72px; height: 50px; border-radius: 8px; overflow: hidden; background: #001333; border: 1px solid #cbd5e1;">
                                        <img src="{{ $art->image_url }}" alt="{{ $art->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </td>

                                {{-- Title & Excerpt --}}
                                <td style="padding: 16px 18px; vertical-align: top;">
                                    <div style="font-weight: 800; color: #001333; font-size: 15px; line-height: 1.4; margin-bottom: 6px;">
                                        {{ $art->title }}
                                    </div>
                                    <div style="font-size: 13px; color: #64748b; line-height: 1.5; max-width: 520px;">
                                        {{ Str::limit($art->excerpt, 120) }}
                                    </div>
                                    <div style="margin-top: 6px; font-size: 11.5px; color: #94a3b8;">
                                        Slug: <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #475569;">{{ $art->slug }}</code>
                                    </div>
                                </td>

                                {{-- Category --}}
                                <td style="padding: 16px 18px; vertical-align: top;">
                                    <span style="display: inline-block; background: rgba(0, 19, 51, 0.08); color: #001333; font-weight: 800; font-size: 11.5px; padding: 4px 10px; border-radius: 6px; border: 1px solid rgba(0, 19, 51, 0.15);">
                                        {{ $art->category }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td style="padding: 16px 18px; vertical-align: top;">
                                    @if($art->status === 'Published')
                                        <span style="display: inline-flex; align-items: center; gap: 6px; background: #d1fae5; color: #065f46; font-weight: 800; font-size: 11.5px; padding: 4px 10px; border-radius: 20px; border: 1px solid #a7f3d0;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                                            Terbit (Live)
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; gap: 6px; background: #fef3c7; color: #92400e; font-weight: 800; font-size: 11.5px; padding: 4px 10px; border-radius: 20px; border: 1px solid #fde68a;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #f59e0b;"></span>
                                            Draf
                                        </span>
                                    @endif
                                </td>

                                {{-- Date & Author --}}
                                <td style="padding: 16px 18px; vertical-align: top;">
                                    <div style="font-weight: 700; color: #1e293b; font-size: 13px;">
                                        {{ $art->published_at ? $art->published_at->translatedFormat('d M Y') : '-' }}
                                    </div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                        ✍️ {{ $art->author_name }}
                                    </div>
                                </td>

                                {{-- Views --}}
                                <td style="padding: 16px 18px; vertical-align: top; text-align: center;">
                                    <span style="font-weight: 800; color: #001333; font-size: 14px;">
                                        {{ number_format($art->views_count) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td style="padding: 16px 18px; vertical-align: top; text-align: center;">
                                    <div style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                        <a href="{{ route('berita.detail', $art->slug) }}" target="_blank" title="Lihat di Pengguna" style="background: #e2e8f0; color: #1e293b; padding: 6px 10px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center;">
                                            👁️
                                        </a>

                                        <button type="button" onclick="openEditModal({{ json_encode($art) }})" title="Edit Berita" style="background: #001333; color: #ffb700; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 800; cursor: pointer;">
                                            ✏️ Edit
                                        </button>

                                        <form action="{{ route('admin.berita.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.');" style="margin: 0; display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Berita" style="background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; padding: 6px 10px; border-radius: 6px; font-size: 12px; font-weight: 800; cursor: pointer;">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding: 20px 24px; border-top: 1.5px solid #e2e8f0; background: #ffffff;">
                {{ $articles->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <span style="font-size: 48px; display: block; margin-bottom: 12px;">📰</span>
                <h3 style="color: #001333; font-size: 18px; margin: 0 0 8px 0;">Belum Ada Berita Ditemukan</h3>
                <p style="font-size: 14px; max-width: 500px; margin: 0 auto 20px;">
                    @if(request('q') || request('category') || request('status'))
                        Tidak ada berita yang sesuai dengan filter yang Anda tentukan.
                    @else
                        Mulai tambahkan artikel atau kegiatan partai pertama untuk membagikan informasi kepada seluruh kader dan masyarakat Banyumas.
                    @endif
                </p>
                <button type="button" onclick="openCreateModal()" class="btn-yellow" style="padding: 10px 22px; border-radius: 8px; font-weight: 800; border: none; cursor: pointer;">
                    ➕ Tambah Berita Baru Sekarang
                </button>
            </div>
        @endif
    </div>

</div>

{{-- ========================================================
     MODAL 1: TAMBAH BERITA BARU
     ======================================================== --}}
<div id="createArticleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeCreateModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>

    <div style="position: relative; background: #ffffff; border-radius: 16px; max-width: 820px; width: 100%; max-height: 92vh; overflow-y: auto; z-index: 2; box-shadow: 0 25px 60px rgba(0,0,0,0.45); border: 2px solid #ffb700;">
        <div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 22px 28px; border-bottom: 2px solid #ffb700; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                    PUBLIKASI REAL-TIME
                </span>
                <h3 style="font-size: 20px; font-weight: 900; color: #ffffff; margin: 6px 0 0 0;">
                    ➕ Tambah Berita Baru
                </h3>
            </div>
            <button type="button" onclick="closeCreateModal()" style="background: rgba(255,255,255,0.1); border: none; color: #ffffff; width: 36px; height: 36px; border-radius: 50%; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" style="padding: 28px;">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 20px;">
                {{-- Judul Berita --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 14px; color: #001333; margin-bottom: 6px;">
                        Judul Berita <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="title" required placeholder="Contoh: DPD NasDem Banyumas Gelar Aksi Sosial Peduli Warga..." style="width: 100%; padding: 12px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; outline: none; box-sizing: border-box; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
                </div>

                {{-- Row 2: Kategori & Status & Tanggal --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px;">
                    <div>
                        <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                            Kategori Berita <span style="color: #ef4444;">*</span>
                        </label>
                        <select name="category" required style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background-color: #ffffff; color: #000000; -webkit-text-fill-color: #000000;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                            Status Publikasi <span style="color: #ef4444;">*</span>
                        </label>
                        <select name="status" required style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background-color: #ffffff; color: #000000; -webkit-text-fill-color: #000000;">
                            <option value="Published" selected>🟢 Published (Tampil di POV Pengguna)</option>
                            <option value="Draft">🟡 Draft (Simpan Dulu di Admin)</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                            Tanggal Terbit
                        </label>
                        <input type="date" name="published_at" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 10.5px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
                    </div>
                </div>

                {{-- Penulis / Redaksi --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                        Penulis / Redaksi Berita
                    </label>
                    <input type="text" name="author_name" value="Humas DPD NasDem Banyumas" placeholder="Humas DPD NasDem Banyumas" style="width: 100%; padding: 11px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
                </div>

                {{-- Foto Utama Berita --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                        Foto Utama Berita
                    </label>
                    <div style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                        <input type="file" name="image_file" accept="image/*" onchange="previewImage(this, 'createImgPreview')" style="flex: 1; padding: 9px; border: 1.5px dashed #cbd5e1; border-radius: 8px; font-size: 13.5px; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
                        <div style="width: 100px; height: 65px; border-radius: 8px; overflow: hidden; background: #001333; border: 1px solid #cbd5e1; display: flex; align-items: center; justify-content: center;">
                            <img id="createImgPreview" src="{{ asset('images/congress.jpg') }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>
                    <span style="font-size: 12px; color: #64748b; margin-top: 4px; display: block;">Format didukung: JPG, PNG, WEBP (Maksimal 10MB). Jika dikosongkan, gambar default akan digunakan.</span>
                </div>

                {{-- Ringkasan / Excerpt --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                        Ringkasan Berita (Lead / Excerpt)
                    </label>
                    <textarea name="excerpt" rows="2" placeholder="Tuliskan 1-2 kalimat ringkasan yang menarik pembaca..." style="width: 100%; padding: 11px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; resize: vertical; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;"></textarea>
                </div>

                {{-- Konten Lengkap --}}
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label style="font-weight: 800; font-size: 13.5px; color: #001333;">
                            Isi Berita Lengkap <span style="color: #ef4444;">*</span>
                        </label>
                        <span style="font-size: 12px; color: #64748b;">Mendukung tag HTML &lt;p&gt;, &lt;strong&gt;, &lt;em&gt;</span>
                    </div>
                    <textarea name="content" rows="8" required placeholder="Tuliskan laporan lengkap jalannya kegiatan, kutipan narasumber, dan informasi penting lainnya..." style="width: 100%; padding: 14px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; line-height: 1.6; outline: none; box-sizing: border-box; resize: vertical; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;"></textarea>
                </div>
            </div>

            <div style="margin-top: 28px; padding-top: 20px; border-top: 1.5px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeCreateModal()" style="padding: 10px 20px; border-radius: 8px; font-weight: 800; font-size: 13.5px; border: 1.5px solid #cbd5e1; background: #f8fafc; color: #475569; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" class="btn-yellow" style="padding: 10px 24px; border-radius: 8px; font-weight: 900; font-size: 14px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(255, 183, 0, 0.4);">
                    🚀 Terbitkan Berita Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================
     MODAL 2: EDIT BERITA
     ======================================================== --}}
<div id="editArticleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div onclick="closeEditModal()" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 19, 51, 0.85); backdrop-filter: blur(4px);"></div>

    <div style="position: relative; background: #ffffff; border-radius: 16px; max-width: 820px; width: 100%; max-height: 92vh; overflow-y: auto; z-index: 2; box-shadow: 0 25px 60px rgba(0,0,0,0.45); border: 2px solid #ffb700;">
        <div style="background: linear-gradient(135deg, #000c22 0%, #001f4d 100%); padding: 22px 28px; border-bottom: 2px solid #ffb700; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="background: #ffb700; color: #001333; font-size: 11px; font-weight: 900; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">
                    PERBARUI BERITA
                </span>
                <h3 style="font-size: 20px; font-weight: 900; color: #ffffff; margin: 6px 0 0 0;">
                    ✏️ Edit Berita
                </h3>
            </div>
            <button type="button" onclick="closeEditModal()" style="background: rgba(255,255,255,0.1); border: none; color: #ffffff; width: 36px; height: 36px; border-radius: 50%; font-size: 20px; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>

        <form id="editArticleForm" method="POST" enctype="multipart/form-data" style="padding: 28px;">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 20px;">
                {{-- Judul Berita --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 14px; color: #001333; margin-bottom: 6px;">
                        Judul Berita <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" id="editTitle" name="title" required style="width: 100%; padding: 12px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14.5px; outline: none; box-sizing: border-box; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
                </div>

                {{-- Row 2: Kategori & Status & Tanggal --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px;">
                    <div>
                        <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                            Kategori Berita <span style="color: #ef4444;">*</span>
                        </label>
                        <select id="editCategory" name="category" required style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background-color: #ffffff; color: #000000; -webkit-text-fill-color: #000000;">
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                            Status Publikasi <span style="color: #ef4444;">*</span>
                        </label>
                        <select id="editStatus" name="status" required style="width: 100%; padding: 11px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background-color: #ffffff; color: #000000; -webkit-text-fill-color: #000000;">
                            <option value="Published">🟢 Published (Tampil di POV Pengguna)</option>
                            <option value="Draft">🟡 Draft (Simpan Dulu di Admin)</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                            Tanggal Terbit
                        </label>
                        <input type="date" id="editPublishedAt" name="published_at" style="width: 100%; padding: 10.5px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
                    </div>
                </div>

                {{-- Penulis / Redaksi --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                        Penulis / Redaksi Berita
                    </label>
                    <input type="text" id="editAuthor" name="author_name" style="width: 100%; padding: 11px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
                </div>

                {{-- Foto Utama Berita --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                        Ganti Foto Utama Berita (Opsional)
                    </label>
                    <div style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                        <input type="file" name="image_file" accept="image/*" onchange="previewImage(this, 'editImgPreview')" style="flex: 1; padding: 9px; border: 1.5px dashed #cbd5e1; border-radius: 8px; font-size: 13.5px; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;">
                        <div style="width: 100px; height: 65px; border-radius: 8px; overflow: hidden; background: #001333; border: 1px solid #cbd5e1; display: flex; align-items: center; justify-content: center;">
                            <img id="editImgPreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>
                </div>

                {{-- Ringkasan / Excerpt --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                        Ringkasan Berita (Lead / Excerpt)
                    </label>
                    <textarea id="editExcerpt" name="excerpt" rows="2" style="width: 100%; padding: 11px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; resize: vertical; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;"></textarea>
                </div>

                {{-- Konten Lengkap --}}
                <div>
                    <label style="display: block; font-weight: 800; font-size: 13.5px; color: #001333; margin-bottom: 6px;">
                        Isi Berita Lengkap <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea id="editContent" name="content" rows="8" required style="width: 100%; padding: 14px 16px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 14px; line-height: 1.6; outline: none; box-sizing: border-box; resize: vertical; color: #000000; background-color: #ffffff; -webkit-text-fill-color: #000000;"></textarea>
                </div>
            </div>

            <div style="margin-top: 28px; padding-top: 20px; border-top: 1.5px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeEditModal()" style="padding: 10px 20px; border-radius: 8px; font-weight: 800; font-size: 13.5px; border: 1.5px solid #cbd5e1; background: #f8fafc; color: #475569; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" class="btn-yellow" style="padding: 10px 24px; border-radius: 8px; font-weight: 900; font-size: 14px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(255, 183, 0, 0.4);">
                    💾 Simpan Perubahan Berita
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createArticleModal').style.display = 'flex';
    }

    function closeCreateModal() {
        document.getElementById('createArticleModal').style.display = 'none';
    }

    function openEditModal(art) {
        const form = document.getElementById('editArticleForm');
        form.action = `/admin/berita/${art.id}`;

        document.getElementById('editTitle').value = art.title || '';
        document.getElementById('editCategory').value = art.category || '';
        document.getElementById('editStatus').value = art.status || 'Published';
        document.getElementById('editAuthor').value = art.author_name || '';
        document.getElementById('editExcerpt').value = art.excerpt || '';
        document.getElementById('editContent').value = art.content || '';

        if (art.published_at) {
            const d = new Date(art.published_at);
            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            document.getElementById('editPublishedAt').value = `${yyyy}-${mm}-${dd}`;
        } else {
            document.getElementById('editPublishedAt').value = '';
        }

        const previewImg = document.getElementById('editImgPreview');
        if (art.image) {
            if (art.image.startsWith('http')) {
                previewImg.src = art.image;
            } else {
                previewImg.src = '/' + art.image.replace(/^\/+/, '');
            }
        } else {
            previewImg.src = '{{ asset("images/congress.jpg") }}';
        }

        document.getElementById('editArticleModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editArticleModal').style.display = 'none';
    }

    function previewImage(input, targetImgId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(targetImgId).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
