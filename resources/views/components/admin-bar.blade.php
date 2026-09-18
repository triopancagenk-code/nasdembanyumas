<!-- ========================================================
     ADMIN LIVE CMS TOOLBAR & MODALS (PARTAI NASDEM)
     ======================================================== -->
<div id="nasdemAdminBar" class="admin-bar-wrapper" style="display: none;" aria-hidden="true">
    <div class="admin-bar-inner">
        <!-- Brand & Status -->
        <div class="admin-bar-brand">
            <div class="admin-pulse-dot" title="Mode Edit Aktif"></div>
            <span class="admin-badge">ADMIN LIVE CMS</span>
            <span class="admin-mode-text">Mode Edit Halaman</span>
        </div>

        <!-- Action Tools -->
        <div class="admin-bar-actions">
            <button type="button" class="admin-btn admin-btn-save" id="btnAdminSave" title="Simpan perubahan ke website (Ctrl+S)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                <span>Simpan Perubahan</span>
            </button>

            <button type="button" class="admin-btn admin-btn-secondary" id="btnAdminAddNews" title="Tambah Berita Baru">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 5v14M5 12h14"></path>
                </svg>
                <span>Tambah Berita</span>
            </button>

            <button type="button" class="admin-btn admin-btn-secondary" id="btnAdminManageSlides" title="Kelola Slide Hero Banner">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
                <span>Kelola Slide</span>
            </button>

            <button type="button" class="admin-btn admin-btn-secondary" id="btnAdminPreviewToggle" title="Pratinjau tampilan pengunjung tanpa garis panduan">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <span id="previewBtnLabel">Pratinjau</span>
            </button>

            <button type="button" class="admin-btn admin-btn-secondary" id="btnAdminReset" title="Reset konten ke bawaan awal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                    <path d="M3 3v5h5"></path>
                </svg>
                <span>Reset Default</span>
            </button>

            <button type="button" class="admin-btn admin-btn-danger" id="btnAdminLogout" title="Keluar dari mode admin">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Keluar Admin</span>
            </button>
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL: GANTI GAMBAR / MEDIA UPLOAD
     ======================================================== -->
<div class="admin-modal" id="adminMediaModal" aria-hidden="true" style="display: none;">
    <div class="admin-modal-backdrop" id="adminMediaBackdrop"></div>
    <div class="admin-modal-dialog">
        <div class="admin-modal-header">
            <h3>🖼️ Ganti Foto / Gambar</h3>
            <button type="button" class="admin-modal-close" id="btnCloseMediaModal">&times;</button>
        </div>
        <div class="admin-modal-body">
            <!-- Tabs -->
            <div class="admin-tabs">
                <button type="button" class="admin-tab active" data-tab="tabUpload">Unggah Berkas Baru</button>
                <button type="button" class="admin-tab" data-tab="tabGallery">Galeri Bawaan</button>
                <button type="button" class="admin-tab" data-tab="tabUrl">Tautan / URL Gambar</button>
            </div>

            <!-- Tab Content 1: Upload -->
            <div class="admin-tab-pane active" id="tabUpload">
                <div class="admin-dropzone" id="adminDropzone">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    <p><strong>Klik atau Seret Berkas Gambar ke Sini</strong></p>
                    <span>Format: JPG, PNG, WEBP, SVG (Maks. 5MB)</span>
                    <input type="file" id="mediaFileInput" accept="image/*" style="display: none;">
                </div>
                <div id="uploadStatusText" class="admin-upload-status"></div>
            </div>

            <!-- Tab Content 2: Gallery -->
            <div class="admin-tab-pane" id="tabGallery">
                <p style="font-size: 13px; color: #64748b; margin-bottom: 12px;">Pilih salah satu gambar resmi Partai NasDem yang tersedia:</p>
                <div class="admin-gallery-grid">
                    <div class="admin-gallery-card" data-url="{{ asset('images/suryapaloh.jpg') }}">
                        <img src="{{ asset('images/suryapaloh.jpg') }}" alt="Surya Paloh">
                        <span>Surya Paloh</span>
                    </div>
                    <div class="admin-gallery-card" data-url="{{ asset('images/nasdem-tower.jpg') }}">
                        <img src="{{ asset('images/nasdem-tower.jpg') }}" alt="NasDem Tower">
                        <span>NasDem Tower</span>
                    </div>
                    <div class="admin-gallery-card" data-url="{{ asset('images/congress.jpg') }}">
                        <img src="{{ asset('images/congress.jpg') }}" alt="Kongres NasDem">
                        <span>Kongres Nasional</span>
                    </div>
                    <div class="admin-gallery-card" data-url="{{ asset('images/baksos.jpg') }}">
                        <img src="{{ asset('images/baksos.jpg') }}" alt="Baksos NasDem">
                        <span>Baksos Kerakyatan</span>
                    </div>
                    <div class="admin-gallery-card" data-url="{{ asset('images/hero-nasdem.jpg') }}">
                        <img src="{{ asset('images/hero-nasdem.jpg') }}" alt="Hero NasDem">
                        <span>Hero NasDem</span>
                    </div>
                    <div class="admin-gallery-card" data-url="{{ asset('images/logo-nasdem-tsp.png') }}">
                        <img src="{{ asset('images/logo-nasdem-tsp.png') }}" alt="Logo NasDem" style="object-fit: contain; background: #001333; padding: 4px;">
                        <span>Logo NasDem</span>
                    </div>
                </div>
            </div>

            <!-- Tab Content 3: URL -->
            <div class="admin-tab-pane" id="tabUrl">
                <label for="mediaUrlInput" class="admin-form-label">Masukkan URL Gambar Eksternal / Lokal:</label>
                <input type="text" id="mediaUrlInput" class="admin-form-control" placeholder="https://example.com/foto.jpg atau /images/...">
            </div>

            <!-- Preview selected -->
            <div class="admin-preview-box">
                <span class="admin-preview-label">Pratinjau Terpilih:</span>
                <div class="admin-preview-img-wrap">
                    <img id="mediaPreviewImg" src="" alt="Pratinjau" style="display: none;">
                    <span id="mediaPreviewPlaceholder">Belum ada gambar yang dipilih</span>
                </div>
            </div>
        </div>
        <div class="admin-modal-footer">
            <button type="button" class="admin-modal-btn admin-btn-light" id="btnCancelMediaModal">Batal</button>
            <button type="button" class="admin-modal-btn admin-btn-primary" id="btnApplyMedia">Terapkan Gambar</button>
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL: TAMBAH / EDIT BERITA
     ======================================================== -->
<div class="admin-modal" id="adminNewsModal" aria-hidden="true" style="display: none;">
    <div class="admin-modal-backdrop" id="adminNewsBackdrop"></div>
    <div class="admin-modal-dialog">
        <div class="admin-modal-header">
            <h3 id="newsModalTitle">📰 Tambah Berita Baru</h3>
            <button type="button" class="admin-modal-close" id="btnCloseNewsModal">&times;</button>
        </div>
        <div class="admin-modal-body">
            <input type="hidden" id="newsEditIndex" value="-1">
            <div class="admin-form-group">
                <label for="newsTitleInput" class="admin-form-label">Judul Berita *</label>
                <textarea id="newsTitleInput" class="admin-form-control" rows="3" placeholder="Masukkan judul berita partai..." required></textarea>
            </div>
            <div class="admin-form-row">
                <div class="admin-form-group" style="flex: 1;">
                    <label for="newsDateInput" class="admin-form-label">Tanggal Publikasi</label>
                    <input type="text" id="newsDateInput" class="admin-form-control" placeholder="Contoh: 16 Sep 2026">
                </div>
                <div class="admin-form-group" style="flex: 1;">
                    <label for="newsLinkInput" class="admin-form-label">Link Berita</label>
                    <input type="text" id="newsLinkInput" class="admin-form-control" value="#berita" placeholder="#berita atau https://...">
                </div>
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Gambar Berita</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" id="newsImageInput" class="admin-form-control" placeholder="/images/congress.jpg atau https://..." style="flex: 1;">
                    <button type="button" class="admin-btn admin-btn-secondary" id="btnPickNewsImage" style="white-space: nowrap;">🖼️ Pilih / Upload</button>
                </div>
            </div>
        </div>
        <div class="admin-modal-footer">
            <button type="button" class="admin-modal-btn admin-btn-light" id="btnCancelNewsModal">Batal</button>
            <button type="button" class="admin-modal-btn admin-btn-primary" id="btnSaveNewsItem">Simpan Berita</button>
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL: KELOLA HERO SLIDES
     ======================================================== -->
<div class="admin-modal" id="adminSlideModal" aria-hidden="true" style="display: none;">
    <div class="admin-modal-backdrop" id="adminSlideBackdrop"></div>
    <div class="admin-modal-dialog admin-modal-lg">
        <div class="admin-modal-header">
            <h3>🎠 Kelola Slide Hero Banner</h3>
            <button type="button" class="admin-modal-close" id="btnCloseSlideModal">&times;</button>
        </div>
        <div class="admin-modal-body">
            <!-- Slide Selector / Nav -->
            <div class="admin-slide-tabs-wrap">
                <div class="admin-slide-tabs" id="adminSlideTabs">
                    <!-- Filled dynamically: Slide 1, Slide 2, ... -->
                </div>
                <button type="button" class="admin-btn admin-btn-secondary" id="btnAddNewSlide" style="font-size: 12px; padding: 6px 12px;">
                    ➕ Tambah Slide Baru
                </button>
            </div>

            <!-- Slide Edit Form -->
            <div class="admin-slide-form" id="adminSlideForm">
                <input type="hidden" id="currentSlideIndex" value="0">
                <div class="admin-form-group">
                    <label for="slideEyebrowInput" class="admin-form-label">Teks Atas (Eyebrow)</label>
                    <input type="text" id="slideEyebrowInput" class="admin-form-control" placeholder="Contoh: Bersama Mewujudkan / Gerakan Perubahan / Berita Terkini">
                </div>
                <div class="admin-form-group">
                    <label for="slideTitleInput" class="admin-form-label">Judul Utama Slide (Gunakan pemisah | untuk baris dan warna kuning: Baris 1|Baris 2 Kuning|Baris 3)</label>
                    <input type="text" id="slideTitleInput" class="admin-form-control" placeholder="INDONESIA|MAJU|& BERKEADILAN">
                </div>
                <div class="admin-form-group">
                    <label for="slideDescInput" class="admin-form-label">Deskripsi Singkat</label>
                    <textarea id="slideDescInput" class="admin-form-control" rows="2" placeholder="Teks keterangan slide..."></textarea>
                </div>
                <div class="admin-form-row">
                    <div class="admin-form-group" style="flex: 2;">
                        <label class="admin-form-label">Gambar Latar Belakang (Background Image)</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="slideImageInput" class="admin-form-control" placeholder="/images/suryapaloh.jpg">
                            <button type="button" class="admin-btn admin-btn-secondary" id="btnPickSlideImage">🖼️ Pilih</button>
                        </div>
                    </div>
                    <div class="admin-form-group" style="flex: 1;">
                        <label for="slideUrlInput" class="admin-form-label">Tautan Slide</label>
                        <input type="text" id="slideUrlInput" class="admin-form-control" placeholder="https://partainasdem.id/">
                    </div>
                </div>
                <div class="admin-form-row">
                    <div class="admin-form-group" style="flex: 1;">
                        <label for="slideBtnTextInput" class="admin-form-label">Teks Tombol Utama</label>
                        <input type="text" id="slideBtnTextInput" class="admin-form-control" placeholder="Gabung Sekarang">
                    </div>
                    <div class="admin-form-group" style="flex: 1;">
                        <label for="slideBtnUrlInput" class="admin-form-label">Tautan Tombol Utama</label>
                        <input type="text" id="slideBtnUrlInput" class="admin-form-control" placeholder="https://digital.partainasdem.id/v1/daftar">
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="admin-btn admin-btn-danger" id="btnDeleteCurrentSlide">
                        🗑️ Hapus Slide Ini
                    </button>
                    <span style="font-size: 12px; color: #64748b;">Perubahan slide langsung diaplikasikan ke tampilan</span>
                </div>
            </div>
        </div>
        <div class="admin-modal-footer">
            <button type="button" class="admin-modal-btn admin-btn-light" id="btnCloseSlideModalBtn">Tutup</button>
            <button type="button" class="admin-modal-btn admin-btn-primary" id="btnSaveSlideModal">Terapkan Perubahan Slide</button>
        </div>
    </div>
</div>

<!-- ========================================================
     TOAST NOTIFICATION POPUP
     ======================================================== -->
<div id="adminToast" class="admin-toast" style="display: none;">
    <div class="admin-toast-icon" id="adminToastIcon">✨</div>
    <div class="admin-toast-content">
        <strong id="adminToastTitle">Pemberitahuan</strong>
        <p id="adminToastMessage">Pesan informasi</p>
    </div>
    <button type="button" class="admin-toast-close" id="btnCloseAdminToast">&times;</button>
</div>
