/**
 * ========================================================
 * PARTAI NASDEM LIVE CMS IN-PLACE EDITOR
 * Activates when typing "login admin" in search overlay/drawer
 * ========================================================
 */

(function () {
    'use strict';

    // State
    let isAdminActive = false;
    let isPreviewActive = false;
    let currentImageTarget = null;
    let selectedImageUrl = null;
    let currentSlideIdx = 0;

    const csrfToken = document.querySelector('meta[name="csrf-token"]') 
        ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
        : '';

    /* ================= INITIALIZATION ================= */
    document.addEventListener('DOMContentLoaded', function () {
        initSearchTrigger();
        initAdminBarActions();
        initMediaModal();
        initNewsManager();
        initSlideManager();
        initKeyboardShortcuts();

        // Check if admin mode was already active (e.g. after refresh)
        if (localStorage.getItem('nasdem_admin_active') === '1') {
            activateAdminMode(false);
        }
    });

    /* ================= SEARCH TRIGGER ("login admin") ================= */
    function initSearchTrigger() {
        const searchForms = document.querySelectorAll('.search-overlay-form, .mobile-drawer-search form, form[role="search"]');

        searchForms.forEach(function (form) {
            const input = form.querySelector('input[type="search"], input[name="s"]');
            if (!input) return;

            // Submit handler
            form.addEventListener('submit', function (e) {
                const query = (input.value || '').trim().toLowerCase();
                if (isLoginAdminQuery(query)) {
                    e.preventDefault();
                    e.stopPropagation();
                    input.value = '';
                    closeAnySearch();
                    activateAdminMode(true);
                }
            });

            // Keydown handler on enter
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    const query = (input.value || '').trim().toLowerCase();
                    if (isLoginAdminQuery(query)) {
                        e.preventDefault();
                        e.stopPropagation();
                        input.value = '';
                        closeAnySearch();
                        activateAdminMode(true);
                    }
                }
            });
        });
    }

    function isLoginAdminQuery(val) {
        const clean = val.replace(/\s+/g, ' ').trim();
        return clean === 'login admin' || clean === 'admin login' || clean === 'login-admin' || clean === 'admin';
    }

    function closeAnySearch() {
        // Close search overlay
        const searchOverlay = document.getElementById('searchOverlay');
        if (searchOverlay) {
            searchOverlay.classList.remove('active');
            searchOverlay.setAttribute('aria-hidden', 'true');
        }

        // Close mobile drawer if open
        const drawer = document.getElementById('mobileDrawer');
        const backdrop = document.getElementById('mobileBackdrop');
        if (drawer) drawer.classList.remove('active');
        if (backdrop) backdrop.classList.remove('active');

        document.body.classList.remove('mobile-menu-open');
    }

    /* ================= ACTIVATE / DEACTIVATE ADMIN MODE ================= */
    function activateAdminMode(showToastNotification = true) {
        isAdminActive = true;
        localStorage.setItem('nasdem_admin_active', '1');
        document.body.classList.add('admin-mode-active');

        const bar = document.getElementById('nasdemAdminBar');
        if (bar) {
            bar.style.display = 'flex';
            bar.setAttribute('aria-hidden', 'false');
        }

        enableEditableElements();
        attachImageEditTriggers();
        attachHeroSlideControls();
        attachNewsDeleteButtons();

        if (showToastNotification) {
            showToast(
                '🛡️ Mode Admin Aktif!',
                'Halaman tetap sama. Klik teks mana saja untuk mengedit langsung, atau klik tombol pada gambar untuk mengganti foto.',
                'success'
            );
        }
    }

    function deactivateAdminMode() {
        isAdminActive = false;
        isPreviewActive = false;
        localStorage.removeItem('nasdem_admin_active');
        document.body.classList.remove('admin-mode-active', 'admin-preview-mode');

        const bar = document.getElementById('nasdemAdminBar');
        if (bar) {
            bar.style.display = 'none';
            bar.setAttribute('aria-hidden', 'true');
        }

        disableEditableElements();
        removeImageEditTriggers();
        removeHeroSlideControls();
        removeNewsDeleteButtons();

        showToast(
            '🚪 Mode Admin Dinonaktifkan',
            'Website kembali ke mode tampilan publik pengunjung biasa.',
            'info'
        );
    }

    /* ================= EDITABLE TEXT ELEMENTS ================= */
    function enableEditableElements() {
        const editables = document.querySelectorAll('[data-editable]');
        editables.forEach(function (el) {
            el.setAttribute('contenteditable', 'true');
            el.setAttribute('spellcheck', 'false');

            // Intercept click on links when in admin mode
            if (el.tagName === 'A' || el.closest('a')) {
                el.addEventListener('click', preventLinkInEditMode);
            }
        });
    }

    function disableEditableElements() {
        const editables = document.querySelectorAll('[data-editable]');
        editables.forEach(function (el) {
            el.removeAttribute('contenteditable');
            if (el.tagName === 'A' || el.closest('a')) {
                el.removeEventListener('click', preventLinkInEditMode);
            }
        });
    }

    function preventLinkInEditMode(e) {
        if (isAdminActive && !isPreviewActive) {
            e.preventDefault();
        }
    }

    /* ================= IMAGE EDIT TRIGGERS ================= */
    function attachImageEditTriggers() {
        const imgElements = document.querySelectorAll('[data-editable-img]');

        imgElements.forEach(function (el) {
            let parent = el.parentElement;
            if (!parent.classList.contains('admin-img-editable-wrap')) {
                parent.classList.add('admin-img-editable-wrap');
            }

            // Check if trigger already exists
            if (!parent.querySelector('.admin-img-edit-trigger')) {
                const trigger = document.createElement('button');
                trigger.type = 'button';
                trigger.className = 'admin-img-edit-trigger';
                trigger.innerHTML = `
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <span>Ganti Foto</span>
                `;

                trigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openMediaModal(el);
                });

                parent.appendChild(trigger);
            }
        });
    }

    function removeImageEditTriggers() {
        document.querySelectorAll('.admin-img-edit-trigger').forEach(function (t) {
            t.remove();
        });
    }

    /* ================= HERO SLIDE CONTROLS ================= */
    function attachHeroSlideControls() {
        const heroSection = document.querySelector('.hero-section');
        if (!heroSection) return;

        if (!heroSection.querySelector('.admin-slide-floating-btn')) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'admin-slide-floating-btn';
            btn.innerHTML = `
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                <span>Kelola Slide Hero</span>
            `;

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                openSlideModal();
            });

            heroSection.appendChild(btn);
        }
    }

    function removeHeroSlideControls() {
        const btn = document.querySelector('.admin-slide-floating-btn');
        if (btn) btn.remove();
    }

    /* ================= NEWS MANAGER & DELETE BUTTONS ================= */
    function attachNewsDeleteButtons() {
        const newsItems = document.querySelectorAll('.news-item');

        newsItems.forEach(function (item) {
            if (!item.querySelector('.admin-news-delete-btn')) {
                const delBtn = document.createElement('button');
                delBtn.type = 'button';
                delBtn.className = 'admin-news-delete-btn';
                delBtn.title = 'Hapus berita ini';
                delBtn.innerHTML = '&times;';

                delBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
                        item.remove();
                        showToast('Berita Dihapus', 'Item berita berhasil dihapus dari daftar.', 'info');
                    }
                });

                item.style.position = 'relative';
                item.appendChild(delBtn);
            }
        });
    }

    function removeNewsDeleteButtons() {
        document.querySelectorAll('.admin-news-delete-btn').forEach(function (b) {
            b.remove();
        });
    }

    /* ================= ADMIN TOP BAR ACTIONS ================= */
    function initAdminBarActions() {
        // Save button
        const btnSave = document.getElementById('btnAdminSave');
        if (btnSave) {
            btnSave.addEventListener('click', saveAllContent);
        }

        // Add news button
        const btnAddNews = document.getElementById('btnAdminAddNews');
        if (btnAddNews) {
            btnAddNews.addEventListener('click', function () {
                openNewsModal();
            });
        }

        // Manage slides button
        const btnManageSlides = document.getElementById('btnAdminManageSlides');
        if (btnManageSlides) {
            btnManageSlides.addEventListener('click', function () {
                openSlideModal();
            });
        }

        // Preview toggle
        const btnPreview = document.getElementById('btnAdminPreviewToggle');
        const previewLabel = document.getElementById('previewBtnLabel');
        if (btnPreview) {
            btnPreview.addEventListener('click', function () {
                isPreviewActive = !isPreviewActive;
                document.body.classList.toggle('admin-preview-mode', isPreviewActive);

                if (isPreviewActive) {
                    previewLabel.textContent = 'Mode Edit';
                    showToast('👁️ Mode Pratinjau', 'Garis panduan disembunyikan. Anda melihat tampilan seperti pengunjung.', 'info');
                } else {
                    previewLabel.textContent = 'Pratinjau';
                    showToast('✏️ Kembali ke Mode Edit', 'Garis panduan dan tombol edit diaktifkan kembali.', 'info');
                }
            });
        }

        // Reset button
        const btnReset = document.getElementById('btnAdminReset');
        if (btnReset) {
            btnReset.addEventListener('click', function () {
                if (confirm('PERINGATAN: Apakah Anda yakin ingin mereset seluruh konten kembali ke bawaan awal Partai NasDem?')) {
                    resetToDefault();
                }
            });
        }

        // Logout button
        const btnLogout = document.getElementById('btnAdminLogout');
        if (btnLogout) {
            btnLogout.addEventListener('click', function () {
                if (confirm('Keluar dari Mode Admin? Perubahan yang belum disimpan mungkin akan hilang.')) {
                    deactivateAdminMode();
                }
            });
        }

        // Toast close
        const btnCloseToast = document.getElementById('btnCloseAdminToast');
        if (btnCloseToast) {
            btnCloseToast.addEventListener('click', function () {
                const toast = document.getElementById('adminToast');
                if (toast) toast.style.display = 'none';
            });
        }
    }

    /* ================= SAVE ALL CONTENT ================= */
    function saveAllContent() {
        const btnSave = document.getElementById('btnAdminSave');
        const originalHtml = btnSave.innerHTML;

        btnSave.disabled = true;
        btnSave.innerHTML = `
            <svg class="admin-spin" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle>
                <path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"></path>
            </svg>
            <span>Menyimpan...</span>
        `;

        const data = collectCurrentSiteData();

        fetch('/admin/save-content', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (res) {
            btnSave.disabled = false;
            btnSave.innerHTML = originalHtml;

            if (res.success) {
                showToast('✅ Berhasil Disimpan!', res.message || 'Seluruh perubahan konten website telah disimpan permanen.', 'success');
            } else {
                showToast('❌ Gagal Menyimpan', res.message || 'Terjadi kesalahan saat menyimpan.', 'error');
            }
        })
        .catch(function (err) {
            btnSave.disabled = false;
            btnSave.innerHTML = originalHtml;
            showToast('❌ Kesalahan Jaringan', 'Gagal terhubung ke server untuk menyimpan perubahan.', 'error');
            console.error(err);
        });
    }

    /* ================= COLLECT DATA FROM DOM ================= */
    function collectCurrentSiteData() {
        const data = {
            brand: {
                branch: getText('[data-editable="brand.branch"]') || 'DPC NasDem Banyumas',
                logo_url: getAttr('[data-editable-img="brand.logo"]', 'src') || '/images/logo-nasdem-tsp.png'
            },
            hero_slides: [],
            values: [],
            news_section: {
                title: getText('[data-editable="news_section.title"]') || 'Update Berita',
                view_all_text: getText('[data-editable="news_section.view_all_text"]') || 'Lihat Semua',
                view_all_url: getAttr('[data-editable="news_section.view_all_text"]', 'href') || '#berita',
                items: []
            },
            about: {
                label: getText('[data-editable="about.label"]') || 'Tentang Kami',
                title: getText('[data-editable="about.title"]') || 'Partai NasDem',
                desc: getText('[data-editable="about.desc"]') || '',
                button_text: getText('[data-editable="about.button_text"]') || 'Pelajari Lebih Lanjut',
                button_url: getAttr('[data-editable="about.button_text"]', 'href') || '#profil'
            },
            cta: {
                title: getText('[data-editable="cta.title"]') || 'Bergabunglah bersama kami\nmenjadi bagian dari perubahan!',
                button_text: getText('[data-editable="cta.button_text"]') || 'Gabung Sekarang',
                button_url: getAttr('[data-editable="cta.button_text"]', 'href') || 'https://digital.partainasdem.id/v1/daftar'
            },
            footer: {
                brand_desc: getText('[data-editable="footer.brand_desc"]') || 'Bersama membangun Indonesia maju, adil, dan sejahtera untuk semua.',
                contact_title: getText('[data-editable="footer.contact_title"]') || 'Kantor DPP Partai NasDem',
                contact_address: getText('[data-editable="footer.contact_address"]') || '',
                contact_website: getText('[data-editable="footer.contact_website"]') || 'www.partainasdem.id',
                contact_website_url: getAttr('[data-editable="footer.contact_website"]', 'href') || 'https://www.partainasdem.id',
                copyright: getText('[data-editable="footer.copyright"]') || 'Partai NasDem. All rights reserved.'
            }
        };

        // Hero Slides
        const slides = document.querySelectorAll('.hero-slide');
        slides.forEach(function (slide, idx) {
            let bg = slide.style.backgroundImage || '';
            let bgUrl = '';
            const match = bg.match(/url\(["']?([^"']*)["']?\)/);
            if (match) bgUrl = match[1];

            data.hero_slides.push({
                id: idx + 1,
                eyebrow: slide.getAttribute('data-eyebrow') || '',
                title: slide.getAttribute('data-title') || '',
                desc: slide.getAttribute('data-desc') || '',
                url: slide.getAttribute('data-url') || '#',
                image: bgUrl,
                button_text: slide.getAttribute('data-btn-text') || 'Gabung Sekarang',
                button_url: slide.getAttribute('data-btn-url') || 'https://digital.partainasdem.id/v1/daftar'
            });
        });

        // 4 Values
        const valueItems = document.querySelectorAll('.values-section .value-item');
        valueItems.forEach(function (item, idx) {
            const h3 = item.querySelector('h3');
            const p = item.querySelector('p');
            data.values.push({
                id: idx + 1,
                title: h3 ? h3.innerText.trim() : '',
                desc: p ? p.innerText.trim() : ''
            });
        });

        // News Items
        const newsCards = document.querySelectorAll('.news-list .news-item');
        newsCards.forEach(function (card, idx) {
            const titleEl = card.querySelector('.news-info h3 a') || card.querySelector('.news-info h3');
            const dateEl = card.querySelector('.news-info span');
            const imgEl = card.querySelector('.news-thumb img');
            const linkEl = card.querySelector('.news-thumb');

            data.news_section.items.push({
                id: idx + 1,
                title: titleEl ? titleEl.innerText.trim() : '',
                date: dateEl ? dateEl.innerText.trim() : '',
                image: imgEl ? imgEl.getAttribute('src') : '',
                url: linkEl ? linkEl.getAttribute('href') : '#berita'
            });
        });

        return data;
    }

    function getText(selector) {
        const el = document.querySelector(selector);
        return el ? el.innerText.trim() : null;
    }

    function getAttr(selector, attr) {
        const el = document.querySelector(selector);
        return el ? el.getAttribute(attr) : null;
    }

    /* ================= RESET TO DEFAULT ================= */
    function resetToDefault() {
        fetch('/admin/reset-content', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                alert('Konten berhasil di-reset. Halaman akan dimuat ulang.');
                window.location.reload();
            }
        })
        .catch(function (err) {
            console.error(err);
            alert('Gagal mereset konten.');
        });
    }

    /* ================= MEDIA MODAL & UPLOAD ================= */
    function initMediaModal() {
        const modal = document.getElementById('adminMediaModal');
        const backdrop = document.getElementById('adminMediaBackdrop');
        const btnClose = document.getElementById('btnCloseMediaModal');
        const btnCancel = document.getElementById('btnCancelMediaModal');
        const btnApply = document.getElementById('btnApplyMedia');

        function closeMediaModal() {
            if (modal) modal.style.display = 'none';
            currentImageTarget = null;
            selectedImageUrl = null;
        }

        if (btnClose) btnClose.addEventListener('click', closeMediaModal);
        if (btnCancel) btnCancel.addEventListener('click', closeMediaModal);
        if (backdrop) backdrop.addEventListener('click', closeMediaModal);

        // Tab Switching
        const tabs = modal ? modal.querySelectorAll('.admin-tab') : [];
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                modal.querySelectorAll('.admin-tab-pane').forEach(p => p.classList.remove('active'));

                tab.classList.add('active');
                const targetId = tab.getAttribute('data-tab');
                const targetPane = document.getElementById(targetId);
                if (targetPane) targetPane.classList.add('active');
            });
        });

        // Gallery card selection
        const galleryCards = modal ? modal.querySelectorAll('.admin-gallery-card') : [];
        galleryCards.forEach(function (card) {
            card.addEventListener('click', function () {
                galleryCards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                const url = card.getAttribute('data-url');
                setPreviewImage(url);
            });
        });

        // URL input change
        const urlInput = document.getElementById('mediaUrlInput');
        if (urlInput) {
            urlInput.addEventListener('input', function () {
                setPreviewImage(urlInput.value.trim());
            });
        }

        // File upload & dropzone
        const dropzone = document.getElementById('adminDropzone');
        const fileInput = document.getElementById('mediaFileInput');
        const statusText = document.getElementById('uploadStatusText');

        if (dropzone && fileInput) {
            dropzone.addEventListener('click', function () {
                fileInput.click();
            });

            fileInput.addEventListener('change', function () {
                if (fileInput.files && fileInput.files[0]) {
                    handleFileUpload(fileInput.files[0]);
                }
            });

            dropzone.addEventListener('dragover', function (e) {
                e.preventDefault();
                dropzone.classList.add('dragover');
            });

            dropzone.addEventListener('dragleave', function () {
                dropzone.classList.remove('dragover');
            });

            dropzone.addEventListener('drop', function (e) {
                e.preventDefault();
                dropzone.classList.remove('dragover');
                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    handleFileUpload(e.dataTransfer.files[0]);
                }
            });
        }

        function handleFileUpload(file) {
            if (!file.type.match('image.*')) {
                alert('Silakan pilih berkas gambar (JPG, PNG, WEBP, SVG).');
                return;
            }

            if (statusText) {
                statusText.style.color = '#ffb700';
                statusText.textContent = 'Mengunggah gambar ke server...';
            }

            const formData = new FormData();
            formData.append('image', file);

            fetch('/admin/upload-image', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.url) {
                    if (statusText) {
                        statusText.style.color = '#10b981';
                        statusText.textContent = '✅ Gambar berhasil diunggah!';
                    }
                    setPreviewImage(data.url);
                } else {
                    if (statusText) {
                        statusText.style.color = '#ef4444';
                        statusText.textContent = '❌ ' + (data.message || 'Gagal mengunggah gambar.');
                    }
                }
            })
            .catch(err => {
                if (statusText) {
                    statusText.style.color = '#ef4444';
                    statusText.textContent = '❌ Terjadi kesalahan saat mengunggah.';
                }
                console.error(err);
            });
        }

        // Apply selected image to target
        if (btnApply) {
            btnApply.addEventListener('click', function () {
                if (!selectedImageUrl) {
                    alert('Pilih gambar terlebih dahulu.');
                    return;
                }

                if (currentImageTarget) {
                    if (typeof currentImageTarget === 'function') {
                        currentImageTarget(selectedImageUrl);
                    } else if (currentImageTarget.tagName === 'IMG') {
                        currentImageTarget.src = selectedImageUrl;
                    } else if (currentImageTarget.classList.contains('hero-slide')) {
                        currentImageTarget.style.backgroundImage = `url('${selectedImageUrl}')`;
                    } else if (currentImageTarget.tagName === 'INPUT') {
                        currentImageTarget.value = selectedImageUrl;
                    }
                    showToast('🖼️ Gambar Diperbarui', 'Gambar telah diganti pada tampilan halaman.', 'success');
                }

                closeMediaModal();
            });
        }
    }

    function openMediaModal(target) {
        currentImageTarget = target;
        selectedImageUrl = null;

        const modal = document.getElementById('adminMediaModal');
        if (!modal) return;

        // Reset inputs
        const statusText = document.getElementById('uploadStatusText');
        if (statusText) statusText.textContent = '';
        const urlInput = document.getElementById('mediaUrlInput');
        if (urlInput) urlInput.value = '';

        // Reset gallery selections
        modal.querySelectorAll('.admin-gallery-card').forEach(c => c.classList.remove('selected'));

        // If target has current image, preview it
        let currentSrc = '';
        if (target && target.tagName === 'IMG') {
            currentSrc = target.getAttribute('src');
        } else if (target && target.classList && target.classList.contains('hero-slide')) {
            const match = (target.style.backgroundImage || '').match(/url\(["']?([^"']*)["']?\)/);
            if (match) currentSrc = match[1];
        }

        if (currentSrc) {
            setPreviewImage(currentSrc);
        } else {
            const previewImg = document.getElementById('mediaPreviewImg');
            const placeholder = document.getElementById('mediaPreviewPlaceholder');
            if (previewImg) previewImg.style.display = 'none';
            if (placeholder) placeholder.style.display = 'block';
        }

        modal.style.display = 'flex';
    }

    function setPreviewImage(url) {
        selectedImageUrl = url;
        const previewImg = document.getElementById('mediaPreviewImg');
        const placeholder = document.getElementById('mediaPreviewPlaceholder');

        if (previewImg && url) {
            previewImg.src = url;
            previewImg.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        }
    }

    /* ================= NEWS MODAL (ADD & EDIT) ================= */
    function initNewsManager() {
        const modal = document.getElementById('adminNewsModal');
        const backdrop = document.getElementById('adminNewsBackdrop');
        const btnClose = document.getElementById('btnCloseNewsModal');
        const btnCancel = document.getElementById('btnCancelNewsModal');
        const btnSave = document.getElementById('btnSaveNewsItem');
        const btnPickImage = document.getElementById('btnPickNewsImage');

        function closeNewsModal() {
            if (modal) modal.style.display = 'none';
        }

        if (btnClose) btnClose.addEventListener('click', closeNewsModal);
        if (btnCancel) btnCancel.addEventListener('click', closeNewsModal);
        if (backdrop) backdrop.addEventListener('click', closeNewsModal);

        if (btnPickImage) {
            btnPickImage.addEventListener('click', function () {
                const imgInput = document.getElementById('newsImageInput');
                openMediaModal(function (url) {
                    if (imgInput) imgInput.value = url;
                });
            });
        }

        if (btnSave) {
            btnSave.addEventListener('click', function () {
                const titleInput = document.getElementById('newsTitleInput');
                const dateInput = document.getElementById('newsDateInput');
                const linkInput = document.getElementById('newsLinkInput');
                const imageInput = document.getElementById('newsImageInput');

                const title = (titleInput.value || '').trim();
                const date = (dateInput.value || '').trim() || getFormattedToday();
                const link = (linkInput.value || '').trim() || '#berita';
                const image = (imageInput.value || '').trim() || '/images/congress.jpg';

                if (!title) {
                    alert('Judul berita tidak boleh kosong.');
                    return;
                }

                // Append new news item to .news-list
                const newsList = document.querySelector('.news-list');
                if (newsList) {
                    const article = document.createElement('article');
                    article.className = 'news-item';
                    article.style.position = 'relative';
                    article.innerHTML = `
                        <a href="${link}" class="news-thumb admin-img-editable-wrap">
                            <img src="${image}" alt="${escapeHtml(title)}" data-editable-img="news.item">
                        </a>
                        <div class="news-info">
                            <h3>
                                <a href="${link}" data-editable="news.title">${escapeHtml(title)}</a>
                            </h3>
                            <span data-editable="news.date">${escapeHtml(date)}</span>
                        </div>
                    `;

                    // Insert at the beginning of the news list
                    newsList.insertBefore(article, newsList.firstChild);

                    // Re-attach edit markers
                    enableEditableElements();
                    attachImageEditTriggers();
                    attachNewsDeleteButtons();

                    showToast('📰 Berita Ditambahkan!', 'Berita baru berhasil ditampilkan di daftar update berita.', 'success');
                }

                closeNewsModal();
            });
        }
    }

    function openNewsModal() {
        const modal = document.getElementById('adminNewsModal');
        if (!modal) return;

        const titleInput = document.getElementById('newsTitleInput');
        const dateInput = document.getElementById('newsDateInput');
        const linkInput = document.getElementById('newsLinkInput');
        const imageInput = document.getElementById('newsImageInput');

        if (titleInput) titleInput.value = '';
        if (dateInput) dateInput.value = getFormattedToday();
        if (linkInput) linkInput.value = '#berita';
        if (imageInput) imageInput.value = '/images/congress.jpg';

        modal.style.display = 'flex';
    }

    function getFormattedToday() {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        const now = new Date();
        return now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
    }

    /* ================= SLIDE MANAGER MODAL ================= */
    function initSlideManager() {
        const modal = document.getElementById('adminSlideModal');
        const backdrop = document.getElementById('adminSlideBackdrop');
        const btnClose = document.getElementById('btnCloseSlideModal');
        const btnCloseBtn = document.getElementById('btnCloseSlideModalBtn');
        const btnSaveSlide = document.getElementById('btnSaveSlideModal');
        const btnPickImage = document.getElementById('btnPickSlideImage');
        const btnAddSlide = document.getElementById('btnAddNewSlide');
        const btnDeleteSlide = document.getElementById('btnDeleteCurrentSlide');

        function closeSlideModal() {
            if (modal) modal.style.display = 'none';
        }

        if (btnClose) btnClose.addEventListener('click', closeSlideModal);
        if (btnCloseBtn) btnCloseBtn.addEventListener('click', closeSlideModal);
        if (backdrop) backdrop.addEventListener('click', closeSlideModal);

        if (btnPickImage) {
            btnPickImage.addEventListener('click', function () {
                const imgInput = document.getElementById('slideImageInput');
                openMediaModal(function (url) {
                    if (imgInput) imgInput.value = url;
                });
            });
        }

        if (btnAddSlide) {
            btnAddSlide.addEventListener('click', function () {
                addNewSlide();
            });
        }

        if (btnDeleteSlide) {
            btnDeleteSlide.addEventListener('click', function () {
                deleteCurrentSlide();
            });
        }

        if (btnSaveSlide) {
            btnSaveSlide.addEventListener('click', function () {
                saveCurrentSlideFromModal();
                closeSlideModal();
            });
        }
    }

    function openSlideModal() {
        const modal = document.getElementById('adminSlideModal');
        if (!modal) return;

        renderSlideTabs();
        loadSlideIntoForm(currentSlideIdx);

        modal.style.display = 'flex';
    }

    function renderSlideTabs() {
        const tabsContainer = document.getElementById('adminSlideTabs');
        if (!tabsContainer) return;

        tabsContainer.innerHTML = '';
        const slides = document.querySelectorAll('.hero-slide');

        slides.forEach(function (slide, idx) {
            const tabBtn = document.createElement('button');
            tabBtn.type = 'button';
            tabBtn.className = 'admin-slide-tab-btn' + (idx === currentSlideIdx ? ' active' : '');
            tabBtn.textContent = 'Slide ' + (idx + 1);

            tabBtn.addEventListener('click', function () {
                // Save current before switching
                saveCurrentSlideFromModal();
                currentSlideIdx = idx;
                renderSlideTabs();
                loadSlideIntoForm(idx);
            });

            tabsContainer.appendChild(tabBtn);
        });
    }

    function loadSlideIntoForm(idx) {
        const slides = document.querySelectorAll('.hero-slide');
        if (!slides[idx]) return;

        const slide = slides[idx];
        const eyebrow = slide.getAttribute('data-eyebrow') || '';
        const title = slide.getAttribute('data-title') || '';
        const desc = slide.getAttribute('data-desc') || '';
        const url = slide.getAttribute('data-url') || '';
        const btnText = slide.getAttribute('data-btn-text') || 'Gabung Sekarang';
        const btnUrl = slide.getAttribute('data-btn-url') || 'https://digital.partainasdem.id/v1/daftar';

        let bgUrl = '';
        const match = (slide.style.backgroundImage || '').match(/url\(["']?([^"']*)["']?\)/);
        if (match) bgUrl = match[1];

        document.getElementById('slideEyebrowInput').value = eyebrow;
        document.getElementById('slideTitleInput').value = title;
        document.getElementById('slideDescInput').value = desc;
        document.getElementById('slideUrlInput').value = url;
        document.getElementById('slideImageInput').value = bgUrl;
        document.getElementById('slideBtnTextInput').value = btnText;
        document.getElementById('slideBtnUrlInput').value = btnUrl;
    }

    function saveCurrentSlideFromModal() {
        const slides = document.querySelectorAll('.hero-slide');
        if (!slides[currentSlideIdx]) return;

        const slide = slides[currentSlideIdx];
        const eyebrow = document.getElementById('slideEyebrowInput').value.trim();
        const title = document.getElementById('slideTitleInput').value.trim();
        const desc = document.getElementById('slideDescInput').value.trim();
        const url = document.getElementById('slideUrlInput').value.trim();
        const img = document.getElementById('slideImageInput').value.trim();
        const btnText = document.getElementById('slideBtnTextInput').value.trim();
        const btnUrl = document.getElementById('slideBtnUrlInput').value.trim();

        slide.setAttribute('data-eyebrow', eyebrow);
        slide.setAttribute('data-title', title);
        slide.setAttribute('data-desc', desc);
        slide.setAttribute('data-url', url);
        slide.setAttribute('data-btn-text', btnText);
        slide.setAttribute('data-btn-url', btnUrl);

        if (img) {
            slide.style.backgroundImage = `url('${img}')`;
        }

        // If this slide is currently active on screen, update content live
        if (slide.classList.contains('active')) {
            const heroEyebrow = document.getElementById('heroEyebrow');
            const heroTitle = document.getElementById('heroTitle');
            const heroDesc = document.getElementById('heroDesc');
            const heroMainBtn = document.getElementById('heroMainBtn');

            if (heroEyebrow) heroEyebrow.textContent = eyebrow;

            if (heroTitle) {
                const parts = title.split('|');
                if (parts.length >= 3) {
                    heroTitle.innerHTML = parts[0] + '<br><span>' + parts[1] + '</span><br>' + parts[2];
                } else {
                    heroTitle.textContent = title;
                }
            }

            if (heroDesc) heroDesc.textContent = desc;
            if (heroMainBtn) {
                heroMainBtn.textContent = btnText;
                heroMainBtn.href = btnUrl;
            }
        }

        showToast('Slide Diperbarui', `Slide ${currentSlideIdx + 1} berhasil diperbarui.`, 'success');
    }

    function addNewSlide() {
        const heroSection = document.querySelector('.hero-section');
        const dotsWrap = document.querySelector('.hero-slider-dots');
        if (!heroSection) return;

        const newSlide = document.createElement('div');
        newSlide.className = 'hero-slide';
        newSlide.setAttribute('data-eyebrow', 'Gerakan Perubahan');
        newSlide.setAttribute('data-title', 'BERSATU|BERJUANG|MENANG');
        newSlide.setAttribute('data-desc', 'Bersama Partai NasDem, kita wujudkan perubahan nyata untuk Indonesia.');
        newSlide.setAttribute('data-url', 'https://partainasdem.id/');
        newSlide.setAttribute('data-btn-text', 'Gabung Sekarang');
        newSlide.setAttribute('data-btn-url', 'https://digital.partainasdem.id/v1/daftar');
        newSlide.style.backgroundImage = "url('/images/nasdem-tower.jpg')";

        // Insert before hero-gradient
        const gradient = heroSection.querySelector('.hero-gradient');
        heroSection.insertBefore(newSlide, gradient);

        // Add dot
        if (dotsWrap) {
            const newDot = document.createElement('button');
            newDot.className = 'hero-dot';
            newDot.type = 'button';
            newDot.setAttribute('aria-label', 'Slide ' + document.querySelectorAll('.hero-slide').length);
            dotsWrap.appendChild(newDot);
        }

        const total = document.querySelectorAll('.hero-slide').length;
        currentSlideIdx = total - 1;
        renderSlideTabs();
        loadSlideIntoForm(currentSlideIdx);

        showToast('➕ Slide Baru Dibuat', `Slide ke-${total} berhasil ditambahkan.`, 'success');
    }

    function deleteCurrentSlide() {
        const slides = document.querySelectorAll('.hero-slide');
        if (slides.length <= 1) {
            alert('Tidak bisa menghapus slide terakhir.');
            return;
        }

        if (confirm(`Apakah Anda yakin ingin menghapus Slide ${currentSlideIdx + 1}?`)) {
            slides[currentSlideIdx].remove();

            // Remove a dot
            const dots = document.querySelectorAll('.hero-dot');
            if (dots.length > 0) dots[dots.length - 1].remove();

            currentSlideIdx = Math.max(0, currentSlideIdx - 1);
            renderSlideTabs();
            loadSlideIntoForm(currentSlideIdx);

            showToast('Slide Dihapus', 'Slide berhasil dihapus.', 'info');
        }
    }

    /* ================= TOAST NOTIFICATION ================= */
    let toastTimeout = null;

    function showToast(title, message, type = 'info') {
        const toast = document.getElementById('adminToast');
        const titleEl = document.getElementById('adminToastTitle');
        const msgEl = document.getElementById('adminToastMessage');
        const iconEl = document.getElementById('adminToastIcon');

        if (!toast || !titleEl || !msgEl) return;

        titleEl.textContent = title;
        msgEl.textContent = message;

        if (type === 'success') {
            iconEl.textContent = '✅';
            toast.style.borderLeftColor = '#10b981';
        } else if (type === 'error') {
            iconEl.textContent = '❌';
            toast.style.borderLeftColor = '#ef4444';
        } else {
            iconEl.textContent = '🛡️';
            toast.style.borderLeftColor = '#ffb700';
        }

        toast.style.display = 'flex';

        if (toastTimeout) clearTimeout(toastTimeout);
        toastTimeout = setTimeout(function () {
            toast.style.display = 'none';
        }, 5000);
    }

    /* ================= KEYBOARD SHORTCUTS ================= */
    function initKeyboardShortcuts() {
        document.addEventListener('keydown', function (e) {
            // Save shortcut (Ctrl+S or Cmd+S)
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                if (isAdminActive) {
                    e.preventDefault();
                    saveAllContent();
                }
            }
        });
    }

    function escapeHtml(str) {
        return str.replace(/[&<>'"]/g, 
            tag => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#39;',
                '"': '&quot;'
            }[tag] || tag)
        );
    }

})();
