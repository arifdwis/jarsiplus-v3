<header class="jp-header">
    <div class="jp-header__inner">
        <a href="{{ route('welcome') }}" class="jp-brand" aria-label="JARSIPLUS Kota Samarinda">
            <span class="jp-brand__mark" aria-hidden="true">J+</span>
            <span>
                <strong>JARSIPLUS</strong>
                <small>Inovasi Daerah Kota Samarinda</small>
            </span>
        </a>

        <button class="jp-menu-toggle" type="button" aria-expanded="false" aria-controls="jp-primary-navigation">
            <span class="sr-only">Buka navigasi</span>
            <span></span><span></span><span></span>
        </button>

        <nav id="jp-primary-navigation" class="jp-nav" aria-label="Navigasi utama">
            <a href="{{ route('welcome') }}">Beranda</a>
            <a href="{{ route('informasi.index') }}">Informasi</a>
            <a href="{{ route('statistik.index') }}">Statistik</a>
            <a href="{{ route('faq.index') }}">FAQ</a>
        </nav>

        <div class="jp-header__actions">
            @if(Nue::user())
                <a class="jp-link" href="{{ route('settings') }}">Pengaturan</a>
                <a class="jp-button jp-button--primary" href="{{ route('permohonan.index') }}">Permohonan Saya</a>
                <a class="jp-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('header-logout-form').submit();">Keluar</a>
                <form id="header-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            @else
                <a class="jp-link" href="{{ url('/jarsiplus/permohonan') }}">E-Panel Admin</a>
                <a class="jp-button jp-button--primary" href="{{ route('sso.authorize') }}">Masuk Portal</a>
            @endif
        </div>
    </div>
</header>
