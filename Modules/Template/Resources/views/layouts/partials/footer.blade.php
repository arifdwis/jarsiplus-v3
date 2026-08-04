<footer class="jp-footer">
    <div class="l-container">
        <div class="jp-footer__inner">
            <div class="jp-footer__col">
                <a href="{{ url('/') }}" class="jp-brand u-mb-md">
                    @if(file_exists(public_path('img/brand/logo-jarsiplus.svg')) || file_exists(public_path('images/logo-jarsiplus.svg')))
                        <img src="{{ asset(file_exists(public_path('img/brand/logo-jarsiplus.svg')) ? 'img/brand/logo-jarsiplus.svg' : 'images/logo-jarsiplus.svg') }}" alt="Logo JARSIPLUS" style="height: 38px; width: auto;" />
                    @else
                        <span class="jp-brand__icon">J</span>
                        <span class="jp-brand__title">JARSIPLUS</span>
                    @endif
                </a>
                <p class="jp-footer__desc">
                    Jaringan Inovasi Plus Daerah Kota Samarinda. Platform resmi pengajuan, penilaian, dan publikasi inovasi tata kelola pemerintahan &amp; pelayanan publik.
                </p>
            </div>

            <div class="jp-footer__col">
                <h4 class="jp-footer__heading">Navigasi Utama</h4>
                <ul class="jp-footer__list">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ url('/informasi') }}">Informasi &amp; Pengumuman</a></li>
                    <li><a href="{{ url('/statistik') }}">Dashboard Statistik</a></li>
                    <li><a href="{{ url('/faq') }}">Pertanyaan Umum (FAQ)</a></li>
                </ul>
            </div>

            <div class="jp-footer__col">
                <h4 class="jp-footer__heading">Layanan &amp; Portal</h4>
                <ul class="jp-footer__list">
                    <li><a href="{{ url('/permohonan/create') }}">Pengajuan Inovasi Baru</a></li>
                    <li><a href="{{ url('/login') }}">Masuk Portal SSO</a></li>
                    <li><a href="{{ url('/jarsiplus') }}" class="text-teal font-mono">E-Panel Admin &rarr;</a></li>
                </ul>
            </div>
        </div>

        <div class="jp-footer__bottom">
            <div class="jp-footer__bottom-inner">
                <span>&copy; {{ date('Y') }} Pemerintah Kota Samarinda. All rights reserved.</span>
                <span class="font-mono">Cobalt-01 System v3.1</span>
            </div>
        </div>
    </div>
</footer>
