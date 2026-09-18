<!-- Mobile Drawer & Backdrop (Global Layout) -->
<div class="mobile-backdrop" id="mobileBackdrop"></div>

<div class="mobile-drawer" id="mobileDrawer">
    <div class="mobile-drawer-head">
        <div style="display: flex; flex-direction: column;">
            <span style="font-weight: 900; font-size: 15px;">Menu</span>
            <span style="font-size: 9px; font-weight: 800; color: var(--yellow); letter-spacing: 1.2px; text-transform: uppercase;" data-editable="brand.branch">{{ $content['brand']['branch'] ?? 'DPD NasDem Banyumas' }}</span>
        </div>
        <button class="mobile-close-btn" id="mobileCloseBtn" type="button" aria-label="Tutup Menu">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M18 6L6 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    <div class="mobile-drawer-search">
        <form role="search" method="get" action="#">
            <input type="search" name="s" placeholder="Cari berita..." required>
            <button type="submit">Cari</button>
        </form>
    </div>

    <ul id="menu-main-menu-1" class="mobile-menu">
        @auth
            @if(auth()->user()->isAdmin())
                <li class="menu-item"><a href="{{ route('admin.dpd') }}" style="color: #ffffff; font-weight: 800;">DPD (Dewan Pimpinan Daerah)</a></li>
                <li class="menu-item"><a href="{{ route('admin.dpc') }}" style="color: #ffffff; font-weight: 800;">DPC (27 Kecamatan)</a></li>
                <li class="menu-item"><a href="{{ route('admin.dprt') }}" style="color: #ffffff; font-weight: 800;">DPRt (331 Desa)</a></li>
                <li class="menu-item"><a href="{{ route('admin.statistik') }}" style="color: #ffffff; font-weight: 800;">Statistik Wilayah &amp; Anggota</a></li>
                <li class="menu-item"><a href="{{ route('admin.berita') }}" style="color: #ffffff; font-weight: 800;">Berita (Kelola Berita)</a></li>
            @else
                <li class="menu-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="menu-item"><a href="{{ route('visi-misi') }}">Visi &amp; Misi</a></li>
                <li class="menu-item"><a href="{{ route('berita') }}">Berita</a></li>
            @endif
            <li class="menu-item" style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #fca5a5; font-size: 14px; font-weight: 700; cursor: pointer; padding: 5px 0;">
                        🚪 Keluar (Logout)
                    </button>
                </form>
            </li>
        @else
            <li class="menu-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="menu-item"><a href="{{ route('visi-misi') }}">Visi &amp; Misi</a></li>
            <li class="menu-item"><a href="{{ route('berita') }}">Berita</a></li>
            <li class="menu-item" style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 14px; display: flex; flex-direction: column; gap: 8px;">
                <a href="https://digital.partainasdem.id/v1/daftar" target="_blank" style="background: #ff9900; color: #001333; font-weight: 800; padding: 9px 16px; border-radius: 8px; text-align: center; text-decoration: none; font-size: 13.5px;">
                    Bergabung
                </a>
                <a href="{{ route('login') }}" style="border: 1.5px solid #ffffff; color: #ffffff; font-weight: 700; padding: 8px 16px; border-radius: 8px; text-align: center; text-decoration: none; font-size: 13.5px; background: rgba(255,255,255,0.05);">
                    Login
                </a>
            </li>
        @endauth
    </ul>
</div>
