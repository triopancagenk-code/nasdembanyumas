<div class="hero-navbar">
    <div class="logo">
        <a href="{{ route('home') }}" style="display: flex; align-items: center; text-decoration: none;">
            <img src="{{ asset('images/nasdem_trace.svg') }}" alt="Partai NasDem Banyumas" style="height: 50px; width: auto;" data-editable-img="brand.logo">
        </a>
    </div>

    <nav class="desktop-menu">
        <ul id="menu-main-menu" class="main-menu">
            @auth
                @if(auth()->user()->isAdmin())
                    {{-- ================= POV ADMIN ================= --}}
                    <li class="menu-item {{ request()->routeIs('admin.dpd*') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('admin.dpd') }}" style="color: #ffffff; font-weight: 800;">DPD</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.dpc*') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('admin.dpc') }}" style="color: #ffffff; font-weight: 800;">DPC</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.dprt*') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('admin.dprt') }}" style="color: #ffffff; font-weight: 800;">DPRt</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.statistik*') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('admin.statistik') }}" style="color: #ffffff; font-weight: 800;">Statistik</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.berita*') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('admin.berita') }}" style="color: #ffffff; font-weight: 800;">Berita</a>
                    </li>
                @else
                    {{-- ================= POV PENGGUNA (LOGGED IN) ================= --}}
                    <li class="menu-item {{ request()->routeIs('home') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('visi-misi') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('visi-misi') }}">Visi &amp; Misi</a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('berita') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('berita') }}">Berita</a>
                    </li>
                @endif
            @else
                {{-- ================= POV PENGGUNA (GUEST) ================= --}}
                <li class="menu-item {{ request()->routeIs('home') ? 'current-menu-item' : '' }}">
                    <a href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="menu-item {{ request()->routeIs('visi-misi') ? 'current-menu-item' : '' }}">
                    <a href="{{ route('visi-misi') }}">Visi &amp; Misi</a>
                </li>
                <li class="menu-item {{ request()->routeIs('berita') ? 'current-menu-item' : '' }}">
                    <a href="{{ route('berita') }}">Berita</a>
                </li>
            @endauth
        </ul>
    </nav>

    <!-- Right Side Actions: Auth & Search -->
    <div style="display: flex; align-items: center; gap: 12px;">
        @auth
            <div class="user-pill" style="display: flex; align-items: center; gap: 8px; background: rgba(0, 19, 51, 0.7); border: 1px solid rgba(255, 183, 0, 0.4); padding: 5px 12px; border-radius: 20px;">
                @if(auth()->user()->isAdmin())
                    <span style="background: #ffb700; color: #001333; font-size: 10px; font-weight: 900; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">ADMIN</span>
                @else
                    <span style="background: #10b981; color: #ffffff; font-size: 10px; font-weight: 900; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">KADER</span>
                @endif
                <span style="font-size: 12px; font-weight: 700; color: #f8fafc; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    <button type="submit" title="Keluar / Logout" style="background: none; border: none; color: #fca5a5; cursor: pointer; display: flex; align-items: center; padding: 2px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </button>
                </form>
            </div>
        @else
            <div style="display: flex; align-items: center; gap: 8px;">
                <a href="https://digital.partainasdem.id/v1/daftar" target="_blank" class="nav-btn-join" style="background: #ff9900; color: #001333; font-size: 13px; font-weight: 800; padding: 7px 16px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: all 0.15s ease; white-space: nowrap;" onmouseover="this.style.background='#e68a00'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#ff9900'; this.style.transform='none';">
                    Bergabung
                </a>
                <a href="{{ route('login') }}" class="nav-btn-login" style="background: rgba(255, 255, 255, 0.05); color: #ffffff; font-size: 13px; font-weight: 700; padding: 6px 16px; border-radius: 8px; border: 1.5px solid #ffffff; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; transition: all 0.15s ease; white-space: nowrap;" onmouseover="this.style.background='rgba(255, 255, 255, 0.15)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.05)';">
                    Login
                </a>
            </div>
        @endauth

        <button class="header-search-btn" id="openSearchBtn" type="button" aria-label="Cari">
            <svg viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2.5"/>
                <path d="M20 20L16.5 16.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </button>

        <button class="mobile-menu-btn" id="mobileMenuBtn" type="button" aria-label="Buka Menu">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M4 7H20" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M4 12H20" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M4 17H20" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
</div>