<!-- Mobile Drawer & Backdrop (Global Layout) -->
<div class="mobile-backdrop" id="mobileBackdrop"></div>

<div class="mobile-drawer" id="mobileDrawer">
    <div class="mobile-drawer-head">
        <div style="display: flex; flex-direction: column;">
            <span style="font-weight: 900; font-size: 15px;">Menu Navigasi</span>
            <span style="font-size: 9px; font-weight: 800; color: var(--yellow); letter-spacing: 1.2px; text-transform: uppercase;" data-editable="brand.branch">{{ $content['brand']['branch'] ?? 'DPD NasDem Banyumas' }}</span>
        </div>
        <button class="mobile-close-btn" id="mobileCloseBtn" type="button" aria-label="Tutup Menu">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M18 6L6 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    @auth
        {{-- Logged in user profile card --}}
        <div class="mobile-drawer-user-card" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255, 183, 0, 0.35); border-radius: 12px; margin-bottom: 16px;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #ffb700, #ff9900); color: #001333; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 15px; flex-shrink: 0; box-shadow: 0 2px 8px rgba(255,183,0,0.3);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="display: flex; flex-direction: column; overflow: hidden; min-width: 0;">
                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
                    @if(auth()->user()->isAdmin())
                        <span style="background: #ffb700; color: #001333; font-size: 9px; font-weight: 900; padding: 1px 6px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">ADMIN</span>
                    @else
                        <span style="background: #10b981; color: #ffffff; font-size: 9px; font-weight: 900; padding: 1px 6px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">KADER</span>
                    @endif
                    <span style="font-size: 13px; font-weight: 800; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ auth()->user()->name }}
                    </span>
                </div>
                <span style="font-size: 11px; color: #94a3b8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ auth()->user()->email }}
                </span>
            </div>
        </div>
    @endauth

    <div class="mobile-drawer-search">
        <form role="search" method="get" action="#">
            <input type="search" name="s" placeholder="Cari berita..." required>
            <button type="submit">Cari</button>
        </form>
    </div>

    <ul id="menu-main-menu-1" class="mobile-menu">
        @auth
            @if(auth()->user()->isAdmin())
                {{-- POV ADMIN --}}
                <li class="menu-item {{ request()->routeIs('admin.dpd*') ? 'current-menu-item' : '' }}"><a href="{{ route('admin.dpd') }}" style="color: #ffffff; font-weight: 800;">DPD (Dewan Pimpinan Daerah)</a></li>
                <li class="menu-item {{ request()->routeIs('admin.dpc*') ? 'current-menu-item' : '' }}"><a href="{{ route('admin.dpc') }}" style="color: #ffffff; font-weight: 800;">DPC (27 Kecamatan)</a></li>
                <li class="menu-item {{ request()->routeIs('admin.dprt*') ? 'current-menu-item' : '' }}"><a href="{{ route('admin.dprt') }}" style="color: #ffffff; font-weight: 800;">DPRt (331 Desa)</a></li>
                <li class="menu-item {{ request()->routeIs('admin.statistik*') ? 'current-menu-item' : '' }}"><a href="{{ route('admin.statistik') }}" style="color: #ffffff; font-weight: 800;">Statistik Wilayah &amp; Anggota</a></li>
                <li class="menu-item {{ request()->routeIs('admin.berita*') ? 'current-menu-item' : '' }}"><a href="{{ route('admin.berita') }}" style="color: #ffffff; font-weight: 800;">Berita (Kelola Berita)</a></li>
            @else
                {{-- POV PENGGUNA (LOGGED IN) --}}
                <li class="menu-item {{ request()->routeIs('home') ? 'current-menu-item' : '' }}"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="menu-item {{ request()->routeIs('visi-misi') ? 'current-menu-item' : '' }}"><a href="{{ route('visi-misi') }}">Visi &amp; Misi</a></li>
                <li class="menu-item {{ request()->routeIs('berita*') ? 'current-menu-item' : '' }}"><a href="{{ route('berita') }}">Berita</a></li>
            @endif
            <li class="menu-item" style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 12px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #fca5a5; font-size: 14px; font-weight: 700; cursor: pointer; padding: 6px 0; display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Keluar (Logout)
                    </button>
                </form>
            </li>
        @else
            {{-- POV PENGGUNA (GUEST) --}}
            <li class="menu-item {{ request()->routeIs('home') ? 'current-menu-item' : '' }}"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="menu-item {{ request()->routeIs('visi-misi') ? 'current-menu-item' : '' }}"><a href="{{ route('visi-misi') }}">Visi &amp; Misi</a></li>
            <li class="menu-item {{ request()->routeIs('berita*') ? 'current-menu-item' : '' }}"><a href="{{ route('berita') }}">Berita</a></li>
            <li class="menu-item" style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 14px; display: flex; flex-direction: column; gap: 8px;">
                <a href="https://digital.partainasdem.id/v1/daftar" target="_blank" style="background: #ff9900; color: #001333; font-weight: 800; padding: 10px 16px; border-radius: 8px; text-align: center; text-decoration: none; font-size: 13.5px; transition: background 0.15s ease;">
                    Bergabung
                </a>
                <a href="{{ route('login') }}" style="border: 1.5px solid #ffffff; color: #ffffff; font-weight: 700; padding: 9px 16px; border-radius: 8px; text-align: center; text-decoration: none; font-size: 13.5px; background: rgba(255,255,255,0.05); transition: background 0.15s ease;">
                    Login
                </a>
            </li>
        @endauth
    </ul>
</div>
