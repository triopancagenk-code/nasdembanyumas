document.addEventListener('DOMContentLoaded', function () {

    /* ================= MOBILE MENU (GARIS 3 & SIDEBAR) ================= */
    const drawer = document.getElementById('mobileDrawer');
    const backdrop = document.getElementById('mobileBackdrop');

    function openMobileMenu() {
        if (!drawer || !backdrop) return;
        drawer.classList.add('active');
        backdrop.classList.add('active');
        document.body.classList.add('mobile-menu-open');
    }

    function closeMobileMenu() {
        if (!drawer || !backdrop) return;
        drawer.classList.remove('active');
        backdrop.classList.remove('active');
        document.body.classList.remove('mobile-menu-open');
    }

    // Bind all hamburger buttons (Garis 3)
    document.querySelectorAll('#mobileMenuBtn, .mobile-menu-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            openMobileMenu();
        });
    });

    // Bind all close buttons
    document.querySelectorAll('#mobileCloseBtn, .mobile-close-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            closeMobileMenu();
        });
    });

    if (backdrop) {
        backdrop.addEventListener('click', closeMobileMenu);
    }

    if (drawer) {
        drawer.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer && drawer.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileMenu) {
        const allItems = mobileMenu.querySelectorAll('li');

        allItems.forEach(function (li) {
            const submenu = li.querySelector(':scope > ul');
            const link = li.querySelector(':scope > a');

            if (!submenu || !link) return;

            const toggle = document.createElement('button');
            toggle.type = 'button';
            toggle.className = 'submenu-toggle';
            toggle.innerHTML = '+';

            li.insertBefore(toggle, submenu);

            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                li.classList.toggle('open');
            });

            link.addEventListener('click', function (e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    li.classList.toggle('open');
                }
            });
        });
    }

    /* ================= HERO SLIDER ================= */
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');

    const heroEyebrow = document.getElementById('heroEyebrow');
    const heroTitle = document.getElementById('heroTitle');
    const heroDesc = document.getElementById('heroDesc');
    const heroMainBtn = document.getElementById('heroMainBtn');
    const heroSection = document.querySelector('.hero-section');

    if (slides.length > 1) {
        let current = 0;
        let sliderTimer;

        function updateHeroContent(slide) {
			if (!slide) return;

			const eyebrow = slide.getAttribute('data-eyebrow') || 'Bersama Mewujudkan';
			const title = slide.getAttribute('data-title') || 'INDONESIA|MAJU|& BERKEADILAN';
			const desc = slide.getAttribute('data-desc') || '';
			const url = slide.getAttribute('data-url') || '#';

			const isNewsSlide = eyebrow === 'Berita Terkini';

			if (heroSection) {
				heroSection.classList.toggle('is-news-slide', isNewsSlide);
			}

			if (heroEyebrow) {
				heroEyebrow.textContent = eyebrow;
			}

			if (heroTitle) {
				const parts = title.split('|');

				if (parts.length >= 3) {
					heroTitle.innerHTML =
						parts[0] + '<br>' +
						'<span>' + parts[1] + '</span><br>' +
						parts[2];
				} else {
					heroTitle.textContent = title;
				}
			}

			if (heroDesc) {
				heroDesc.textContent = desc;
			}

			const heroButtons = document.querySelector('.hero-buttons');

			if (heroButtons) {
				if (isNewsSlide) {
					heroButtons.style.display = 'none';
				} else {
					heroButtons.style.display = 'flex';
				}
			}

			if (heroMainBtn) {
				heroMainBtn.textContent = 'Gabung Sekarang';
				heroMainBtn.href = 'https://digital.partainasdem.id/v1/daftar';
			}
		}

        function showSlide(index) {
            slides[current].classList.remove('active');

            if (dots[current]) {
                dots[current].classList.remove('active');
            }

            current = index;

            slides[current].classList.add('active');

            if (dots[current]) {
                dots[current].classList.add('active');
            }

            updateHeroContent(slides[current]);
        }

        function startHeroSlider() {
            sliderTimer = setInterval(function () {
                showSlide((current + 1) % slides.length);
            }, 5000);
        }

        function resetHeroSlider() {
            clearInterval(sliderTimer);
            startHeroSlider();
        }

        updateHeroContent(slides[current]);
        startHeroSlider();

        dots.forEach(function (dot, index) {
            dot.addEventListener('click', function () {
                showSlide(index);
                resetHeroSlider();
            });
        });

        /* Klik hero artikel masuk ke detail berita */
        if (heroSection) {
            heroSection.addEventListener('click', function (e) {
                const blockedClick = e.target.closest(
                    'a, button, nav, input, form, .mobile-drawer, .mobile-backdrop, .hero-dot, .hero-slider-dots, .header-search-btn, .mobile-menu-btn'
                );

                if (blockedClick) return;

                const activeSlide = document.querySelector('.hero-slide.active');
                if (!activeSlide) return;

                const eyebrow = activeSlide.getAttribute('data-eyebrow');
                const url = activeSlide.getAttribute('data-url');

                if (eyebrow === 'Berita Terkini' && url && url !== '#') {
                    window.location.href = url;
                }
            });
        }

        /* Swipe kiri/kanan untuk mobile */
        let touchStartX = 0;
        let touchEndX = 0;

        if (heroSection) {
            heroSection.addEventListener('touchstart', function (e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            heroSection.addEventListener('touchend', function (e) {
                touchEndX = e.changedTouches[0].screenX;

                const swipeDistance = touchEndX - touchStartX;

                if (Math.abs(swipeDistance) < 50) return;

                if (swipeDistance < 0) {
                    showSlide((current + 1) % slides.length);
                } else {
                    showSlide((current - 1 + slides.length) % slides.length);
                }

                resetHeroSlider();
            }, { passive: true });
        }

		        /* ================= DESKTOP DRAG SLIDE ================= */

				let mouseDown = false;
				let dragStartX = 0;
				let dragEndX = 0;

				if (heroSection) {

					heroSection.addEventListener('mousedown', function (e) {

						const blocked = e.target.closest(
							'a, button, nav, input, form, .hero-buttons, .hero-dot, .hero-slider-dots, .mobile-drawer, .header-search-btn, .mobile-menu-btn'
						);

						if (blocked) return;

						mouseDown = true;
						dragStartX = e.clientX;

						heroSection.classList.add('dragging');
					});

					window.addEventListener('mouseup', function (e) {

						if (!mouseDown) return;

						mouseDown = false;
						dragEndX = e.clientX;

						heroSection.classList.remove('dragging');

						const dragDistance = dragEndX - dragStartX;

						if (Math.abs(dragDistance) < 60) return;

						if (dragDistance < 0) {
							showSlide((current + 1) % slides.length);
						} else {
							showSlide((current - 1 + slides.length) % slides.length);
						}

						resetHeroSlider();
					});
				}

    }

    /* ================= SCROLL TO TOP ================= */
    const scrollTopBtn = document.getElementById('scrollTopBtn');

    if (scrollTopBtn) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });

        scrollTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /* ================= SEARCH OVERLAY ================= */
    const searchOverlay = document.getElementById('searchOverlay');
    const openSearchBtn = document.getElementById('openSearchBtn');
    const openSearchBtnMobile = document.getElementById('openSearchBtnMobile');
    const openSearchBtnPage = document.getElementById('openSearchBtnPage');
    const closeSearchBtn = document.getElementById('closeSearchBtn');

    function openSearchOverlay() {
        if (!searchOverlay) return;

        searchOverlay.classList.add('active');
        searchOverlay.setAttribute('aria-hidden', 'false');
        document.body.classList.add('mobile-menu-open');

        const input = searchOverlay.querySelector('input[type="search"]');

        if (input) {
            setTimeout(function () {
                input.focus();
            }, 200);
        }
    }

    function closeSearchOverlay() {
        if (!searchOverlay) return;

        searchOverlay.classList.remove('active');
        searchOverlay.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('mobile-menu-open');
    }

    if (openSearchBtn) {
        openSearchBtn.addEventListener('click', openSearchOverlay);
    }

    if (openSearchBtnMobile) {
        openSearchBtnMobile.addEventListener('click', openSearchOverlay);
    }

    if (openSearchBtnPage) {
        openSearchBtnPage.addEventListener('click', openSearchOverlay);
    }

    if (closeSearchBtn) {
        closeSearchBtn.addEventListener('click', closeSearchOverlay);
    }

    if (searchOverlay) {
        searchOverlay.addEventListener('click', function (e) {
            if (e.target === searchOverlay) {
                closeSearchOverlay();
            }
        });
    }

    /* ================= FOOTER ACCORDION ================= */
    document.querySelectorAll('.footer-acc-item button').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const item = btn.closest('.footer-acc-item');
            if (!item) return;

            item.classList.toggle('active');
        });
    });

    /* ================= VIDEO MODAL ================= */
    const videoCards = document.querySelectorAll('.anthem-video-card');
    const videoModal = document.getElementById('videoModal');
    const videoBackdrop = document.getElementById('videoModalBackdrop');
    const videoFrame = document.getElementById('videoModalFrame');
    const closeVideoModal = document.getElementById('closeVideoModal');

    function openModalVideo(videoUrl) {
        if (!videoUrl || !videoModal || !videoFrame) return;

        videoFrame.src = videoUrl;
        videoModal.classList.add('active');
        videoModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('video-modal-open');
    }

    function closeModalVideo() {
        if (videoModal) {
            videoModal.classList.remove('active');
            videoModal.setAttribute('aria-hidden', 'true');
        }

        if (videoFrame) {
            videoFrame.src = '';
        }

        document.body.classList.remove('video-modal-open');
    }

    videoCards.forEach(function (card) {
        card.addEventListener('click', function () {
            openModalVideo(card.dataset.video);
        });
    });

    if (closeVideoModal) {
        closeVideoModal.addEventListener('click', closeModalVideo);
    }

    if (videoBackdrop) {
        videoBackdrop.addEventListener('click', closeModalVideo);
    }

    /* ================= FRONT PAGE LOAD MORE NEWS ================= */
    const frontNewsLoadMore = document.getElementById('frontNewsLoadMore');
    const frontNewsList = document.querySelector('.news-list');

    if (frontNewsLoadMore && frontNewsList && typeof nasdemAjax !== 'undefined') {
        frontNewsLoadMore.addEventListener('click', function () {
            const btn = frontNewsLoadMore;
            const currentPage = parseInt(btn.dataset.page || '1', 10);
            const perPage = parseInt(btn.dataset.perPage || '10', 10);

            btn.classList.add('loading');
            btn.disabled = true;
            btn.querySelector('span').textContent = 'Memuat...';

            const formData = new FormData();
            formData.append('action', 'nasdem_load_more_news');
            formData.append('page', currentPage);
            formData.append('per_page', perPage);

            fetch(nasdemAjax.ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (html) {
                const cleanHtml = html.trim();

                if (!cleanHtml) {
                    btn.querySelector('span').textContent = 'Semua Berita Sudah Tampil';
                    btn.classList.add('finished');
                    return;
                }

                frontNewsList.insertAdjacentHTML('beforeend', cleanHtml);

                btn.dataset.page = String(currentPage + 1);
                btn.querySelector('span').textContent = 'Muat Berita Lainnya';
                btn.disabled = false;
                btn.classList.remove('loading');
            })
            .catch(function () {
                btn.querySelector('span').textContent = 'Coba Lagi';
                btn.disabled = false;
                btn.classList.remove('loading');
            });
        });
    }

    /* ================= GLOBAL ESCAPE CLOSE ================= */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
            closeSearchOverlay();
            closeModalVideo();
        }
    });

});