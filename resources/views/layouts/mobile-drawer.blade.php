<!-- Mobile Drawer & Backdrop (Global Layout) -->
<div class="mobile-backdrop" id="mobileBackdrop"></div>

<div class="mobile-drawer" id="mobileDrawer">
    <!-- Header Drawer -->
    <div class="mobile-drawer-head">
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('images/logo-nasdem-tsp.png') }}" alt="NasDem" style="height: 32px; width: auto;">
            <div style="display: flex; flex-direction: column;">
                <span style="font-weight: 900; font-size: 15px; color: #ffffff; line-height: 1.2;">Menu Navigasi</span>
                <span style="font-size: 9px; font-weight: 800; color: #ffb700; letter-spacing: 1px; text-transform: uppercase;" data-editable="brand.branch">{{ $content['brand']['branch'] ?? 'DPD NasDem Banyumas' }}</span>
            </div>
        </div>
        <button class="mobile-close-btn" id="mobileCloseBtn" type="button" aria-label="Tutup Menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <path d="M6 6L18 18"/>
                <path d="M18 6L6 18"/>
            </svg>
        </button>
    </div>

    <!-- User Profile Header if Logged In -->
    @auth
        <div class="mobile-drawer-user-card">
            <div class="user-avatar-circle">
                @if(auth()->user()->isAdmin())
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #ffb700;">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                    </svg>
                @else
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #10b981;">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                @endif
            </div>
            <div class="user-info-text">
                <div style="display: flex; align-items: center; gap: 6px;">
                    @if(auth()->user()->isAdmin())
                        <span class="user-role-badge admin">ADMIN</span>
                    @else
                        <span class="user-role-badge kader">KADER</span>
                    @endif
                    <span class="user-full-name">{{ auth()->user()->name }}</span>
                </div>
                <span class="user-subtext">{{ auth()->user()->email }}</span>
            </div>
        </div>
    @endauth

    <!-- Mobile Navigation Section -->
    <div class="mobile-drawer-nav-section">
        <span class="nav-section-title">Navigasi Utama</span>
        <ul id="menu-main-menu-1" class="mobile-menu mobile-menu-list">
            @auth
                @if(auth()->user()->isAdmin())
                    {{-- 1. DPD --}}
                    <li class="mobile-nav-item {{ request()->routeIs('admin.dpd*') ? 'active' : '' }}">
                        <a href="{{ route('admin.dpd') }}" class="mobile-nav-link">
                            <span class="nav-item-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h1M14 10h1M9 14h1M14 14h1M9 18h1M14 18h1"/>
                                </svg>
                            </span>
                            <div class="nav-item-text">
                                <span class="nav-title">DPD</span>
                                <span class="nav-subtitle">Dewan Pimpinan Daerah</span>
                            </div>
                            <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </li>

                    {{-- 2. DPC --}}
                    <li class="mobile-nav-item {{ request()->routeIs('admin.dpc*') ? 'active' : '' }}">
                        <a href="{{ route('admin.dpc') }}" class="mobile-nav-link">
                            <span class="nav-item-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </span>
                            <div class="nav-item-text">
                                <span class="nav-title">DPC</span>
                                <span class="nav-subtitle">27 Kecamatan</span>
                            </div>
                            <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </li>

                    {{-- 3. DPRt --}}
                    <li class="mobile-nav-item {{ request()->routeIs('admin.dprt*') ? 'active' : '' }}">
                        <a href="{{ route('admin.dprt') }}" class="mobile-nav-link">
                            <span class="nav-item-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </span>
                            <div class="nav-item-text">
                                <span class="nav-title">DPRt</span>
                                <span class="nav-subtitle">331 Desa &amp; Kelurahan</span>
                            </div>
                            <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </li>

                    {{-- 4. Quick Count --}}
                    <li class="mobile-nav-item {{ request()->routeIs('admin.quick-count*') ? 'active' : '' }}">
                        <a href="{{ route('admin.quick-count') }}" class="mobile-nav-link">
                            <span class="nav-item-icon highlight">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 20V10M12 20V4M6 20v-6"/>
                                </svg>
                            </span>
                            <div class="nav-item-text">
                                <span class="nav-title">Quick Count</span>
                                <span class="nav-subtitle">Hitung Cepat &amp; Real Count Pemilu</span>
                            </div>
                            <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </li>

                    {{-- 5. Statistik --}}
                    <li class="mobile-nav-item {{ request()->routeIs('admin.statistik*') ? 'active' : '' }}">
                        <a href="{{ route('admin.statistik') }}" class="mobile-nav-link">
                            <span class="nav-item-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                            </span>
                            <div class="nav-item-text">
                                <span class="nav-title">Statistik</span>
                                <span class="nav-subtitle">Demografi Wilayah &amp; Anggota</span>
                            </div>
                            <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </li>

                    {{-- 6. Calon Legislatif --}}
                    <li class="mobile-nav-item {{ request()->routeIs('admin.calon-legislatif*') ? 'active' : '' }}">
                        <a href="{{ route('admin.calon-legislatif') }}" class="mobile-nav-link">
                            <span class="nav-item-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </span>
                            <div class="nav-item-text">
                                <span class="nav-title">Calon Legislatif</span>
                                <span class="nav-subtitle">Dapil 1 - 6 Banyumas</span>
                            </div>
                            <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </li>

                    {{-- 7. Berita --}}
                    <li class="mobile-nav-item {{ request()->routeIs('admin.berita*') ? 'active' : '' }}">
                        <a href="{{ route('admin.berita') }}" class="mobile-nav-link">
                            <span class="nav-item-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </span>
                            <div class="nav-item-text">
                                <span class="nav-title">Berita</span>
                                <span class="nav-subtitle">Kelola Berita &amp; Artikel</span>
                            </div>
                            <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </li>

                    {{-- Link ke Beranda Website --}}
                    <li class="mobile-nav-item secondary {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="mobile-nav-link">
                            <span class="nav-item-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </span>
                            <div class="nav-item-text">
                                <span class="nav-title">Beranda Website</span>
                                <span class="nav-subtitle">Halaman Depan Publik</span>
                            </div>
                            <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </li>
                @else
                    <li class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="mobile-nav-link">
                            <span class="nav-item-text"><span class="nav-title">Beranda</span></span>
                        </a>
                    </li>
                    <li class="mobile-nav-item {{ request()->routeIs('visi-misi') ? 'active' : '' }}">
                        <a href="{{ route('visi-misi') }}" class="mobile-nav-link">
                            <span class="nav-item-text"><span class="nav-title">Visi &amp; Misi</span></span>
                        </a>
                    </li>
                    <li class="mobile-nav-item {{ request()->routeIs('berita') ? 'active' : '' }}">
                        <a href="{{ route('berita') }}" class="mobile-nav-link">
                            <span class="nav-item-text"><span class="nav-title">Berita</span></span>
                        </a>
                    </li>
                @endif
            @else
                <li class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="mobile-nav-link">
                        <span class="nav-item-text"><span class="nav-title">Beranda</span></span>
                    </a>
                </li>
                <li class="mobile-nav-item {{ request()->routeIs('visi-misi') ? 'active' : '' }}">
                    <a href="{{ route('visi-misi') }}" class="mobile-nav-link">
                        <span class="nav-item-text"><span class="nav-title">Visi &amp; Misi</span></span>
                    </a>
                </li>
                <li class="mobile-nav-item {{ request()->routeIs('berita') ? 'active' : '' }}">
                    <a href="{{ route('berita') }}" class="mobile-nav-link">
                        <span class="nav-item-text"><span class="nav-title">Berita</span></span>
                    </a>
                </li>
            @endauth
        </ul>
    </div>

    <!-- 8. Logout Section (Dedicated) -->
    @auth
        <div class="mobile-drawer-footer">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
                @csrf
                <button type="submit" class="mobile-drawer-logout-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    @else
        <div class="mobile-drawer-guest-footer">
            <a href="https://digital.partainasdem.id/v1/daftar" target="_blank" class="mobile-drawer-btn-join">
                Bergabung (E-KTA)
            </a>
            <a href="{{ route('login') }}" class="mobile-drawer-btn-login">
                Login Admin / Kader
            </a>
        </div>
    @endauth
</div>

