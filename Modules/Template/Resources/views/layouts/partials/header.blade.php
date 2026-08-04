<header class="jp-header">
    <div class="l-container jp-header__inner">
        <a href="{{ url('/') }}" class="jp-brand">
            @if(file_exists(public_path('img/brand/logo-jarsiplus.svg')) || file_exists(public_path('images/logo-jarsiplus.svg')))
                <img src="{{ asset(file_exists(public_path('img/brand/logo-jarsiplus.svg')) ? 'img/brand/logo-jarsiplus.svg' : 'images/logo-jarsiplus.svg') }}" alt="Logo JARSIPLUS" style="height: 38px; width: auto; max-width: 180px; object-fit: contain;" />
            @else
                <span class="jp-brand__icon">J</span>
                <div>
                    <span class="jp-brand__title">JARSIPLUS</span>
                    <span class="jp-brand__tag">Kota Samarinda</span>
                </div>
            @endif
        </a>

        <nav class="jp-nav" aria-label="Navigasi Utama">
            <a href="{{ url('/') }}" class="jp-nav__item {{ request()->is('/') ? 'is-active' : '' }}">Beranda</a>
            <a href="{{ url('/informasi') }}" class="jp-nav__item {{ request()->is('informasi*') ? 'is-active' : '' }}">Informasi</a>
            <a href="{{ url('/statistik') }}" class="jp-nav__item {{ request()->is('statistik*') ? 'is-active' : '' }}">Statistik</a>
            <a href="{{ url('/faq') }}" class="jp-nav__item {{ request()->is('faq*') ? 'is-active' : '' }}">FAQ</a>
        </nav>

        <div class="jp-header__actions">
            @if(Auth::check())
                <div class="jp-user-dropdown">
                    <button type="button" class="jp-user-toggle" id="userMenuBtn" aria-expanded="false" aria-haspopup="true">
                        <span class="jp-avatar-circle">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                        </span>
                        <span class="jp-user-name">{{ Auth::user()->name }}</span>
                        <x-icon name="chevron-down" size="14" />
                    </button>
                    <div class="jp-dropdown-menu" id="userMenuDropdown" role="menu">
                        <div class="jp-dropdown-header">
                            <strong class="jp-dropdown-name">{{ Auth::user()->name }}</strong>
                            <small class="jp-dropdown-email" style="color:var(--c-text-muted)">{{ Auth::user()->email }}</small>
                        </div>
                        <hr class="jp-dropdown-divider">
                        <a href="{{ url('/permohonan') }}" class="jp-dropdown-item">
                            <x-icon name="document" size="16" />
                            Portal Permohonan
                        </a>
                        <a href="{{ route('settings.profile.index') }}" class="jp-dropdown-item">
                            <x-icon name="user" size="16" />
                            Pengaturan Profil
                        </a>
                        <hr class="jp-dropdown-divider">
                        <a href="{{ route('sso.logout') }}" class="jp-dropdown-item jp-dropdown-item--danger">
                            <x-icon name="close" size="16" />
                            Keluar (Logout)
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ url('/login') }}" class="jp-btn jp-btn--accent">
                    <x-icon name="lock" size="16" />
                    Masuk SSO
                </a>
            @endif

            <button type="button" class="jp-menu-toggle" aria-label="Buka menu navigasi" aria-expanded="false">
                <x-icon name="menu" size="24" />
            </button>
        </div>
    </div>
</header>

{{-- Mobile Drawer Overlay & Nav --}}
<div class="jp-drawer-overlay"></div>
<div class="jp-drawer" role="dialog" aria-modal="true" aria-label="Menu Navigasi Mobile">
    <div class="jp-drawer__header">
        <a href="{{ url('/') }}" class="jp-brand">
            @if(file_exists(public_path('img/brand/logo-jarsiplus.svg')) || file_exists(public_path('images/logo-jarsiplus.svg')))
                <img src="{{ asset(file_exists(public_path('img/brand/logo-jarsiplus.svg')) ? 'img/brand/logo-jarsiplus.svg' : 'images/logo-jarsiplus.svg') }}" alt="Logo JARSIPLUS" style="height: 34px; width: auto;" />
            @else
                <span class="jp-brand__icon">J</span>
                <span class="jp-brand__title">JARSIPLUS</span>
            @endif
        </a>
        <button type="button" class="jp-drawer-close" aria-label="Tutup menu">
            <x-icon name="close" size="20" />
        </button>
    </div>
    <div class="jp-drawer__body">
        <nav class="jp-drawer-nav">
            <a href="{{ url('/') }}" class="jp-drawer-nav__item {{ request()->is('/') ? 'is-active' : '' }}">Beranda</a>
            <a href="{{ url('/informasi') }}" class="jp-drawer-nav__item {{ request()->is('informasi*') ? 'is-active' : '' }}">Informasi</a>
            <a href="{{ url('/statistik') }}" class="jp-drawer-nav__item {{ request()->is('statistik*') ? 'is-active' : '' }}">Statistik</a>
            <a href="{{ url('/faq') }}" class="jp-drawer-nav__item {{ request()->is('faq*') ? 'is-active' : '' }}">FAQ</a>
            @if(Auth::check())
                <a href="{{ url('/permohonan') }}" class="jp-drawer-nav__item {{ request()->is('permohonan*') ? 'is-active' : '' }}">Portal Permohonan</a>
            @endif
            <hr class="jp-dropdown-divider">
            <a href="{{ url('/jarsiplus') }}" class="jp-drawer-nav__item">E-Panel Admin &rarr;</a>
        </nav>
    </div>
    <div class="jp-drawer__footer">
        @if(Auth::check())
            <div class="u-flex u-flex-col u-gap-sm">
                <span class="jp-text-sm" style="color:var(--c-text-muted)">Masuk sebagai: <strong>{{ Auth::user()->name }}</strong></span>
                <a href="{{ route('sso.logout') }}" class="jp-btn jp-btn--ghost u-w-100">Keluar / Logout</a>
            </div>
        @else
            <a href="{{ url('/login') }}" class="jp-btn jp-btn--accent u-w-100">Masuk SSO Pemkot</a>
        @endif
    </div>
</div>
