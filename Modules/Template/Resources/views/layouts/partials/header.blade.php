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
                            <div style="margin-top: 6px;">
                                <span class="jp-badge jp-badge--accent" style="font-size: 11px; padding: 2px 8px;">
                                    {{ role_me() == 3 ? 'Tim Verifikator' : (role_me() == 4 ? 'Pemohon Inovasi' : (role_me() == 1 ? 'Administrator' : (role_me() == 2 ? 'Superadmin' : 'Pengguna'))) }}
                                </span>
                            </div>
                        </div>
                        @if(Auth::user()->roles->count() > 1)
                            <hr class="jp-dropdown-divider">
                            <div style="padding: 6px 16px 2px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--c-text-muted); letter-spacing: 0.5px;">
                                Ganti Peran:
                            </div>
                            @foreach(Auth::user()->roles as $r)
                                <a href="{{ route('switch.role', $r->id) }}" class="jp-dropdown-item {{ role_me() == $r->id ? 'is-active font-bold' : '' }}" style="display:flex; align-items:center; justify-content:space-between;">
                                    <span>{{ $r->name == 'Pembahas' ? 'Tim Verifikator' : ($r->name == 'Pemohon' ? 'Pemohon Inovasi' : $r->name) }}</span>
                                    @if(role_me() == $r->id)
                                        <span class="jp-badge jp-badge--accent" style="font-size: 10px; padding: 1px 6px;">Aktif</span>
                                    @else
                                        <span style="font-size: 11px; color: var(--c-text-muted);">Pilih &rarr;</span>
                                    @endif
                                </a>
                            @endforeach
                        @endif
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
            <a href="{{ url('/home') }}" class="jp-drawer-nav__item">E-Panel Admin &rarr;</a>
        </nav>
    </div>
    <div class="jp-drawer__footer">
        @if(Auth::check())
            <div class="u-flex u-flex-col u-gap-sm">
                <span class="jp-text-sm" style="color:var(--c-text-muted)">Masuk sebagai: <strong>{{ Auth::user()->name }}</strong></span>
                @if(Auth::user()->roles->count() > 1)
                    <div style="font-size: 12px; margin-bottom: 4px;">
                        <span style="color:var(--c-text-muted)">Peran aktif:</span>
                        <strong style="color:var(--c-accent)">{{ role_me() == 3 ? 'Tim Verifikator' : (role_me() == 4 ? 'Pemohon Inovasi' : 'Admin') }}</strong>
                        <div style="display:flex; gap:6px; margin-top:6px; flex-wrap:wrap;">
                            @foreach(Auth::user()->roles as $r)
                                @if($r->id != role_me())
                                    <a href="{{ route('switch.role', $r->id) }}" class="jp-btn jp-btn--ghost" style="padding:4px 8px; font-size:11px;">
                                        Ganti ke {{ $r->name == 'Pembahas' ? 'Tim Verifikator' : ($r->name == 'Pemohon' ? 'Pemohon' : $r->name) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                <a href="{{ route('sso.logout') }}" class="jp-btn jp-btn--ghost u-w-100">Keluar / Logout</a>
            </div>
        @else
            <a href="{{ url('/login') }}" class="jp-btn jp-btn--accent u-w-100">Masuk SSO Pemkot</a>
        @endif
    </div>
</div>
