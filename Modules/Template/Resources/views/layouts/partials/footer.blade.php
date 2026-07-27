<footer class="jp-footer">
    <div class="jp-footer__inner">
        <div>
            <p class="jp-footer__eyebrow">Pemerintah Kota Samarinda</p>
            <h2>Inovasi yang tertata, pelayanan yang terasa.</h2>
            <p>JARSIPLUS membantu perjalanan pengajuan dan penilaian inovasi daerah secara jelas dan akuntabel.</p>
        </div>
        <nav aria-label="Tautan footer">
            <a href="{{ route('informasi.index') }}">Informasi</a>
            <a href="{{ route('statistik.index') }}">Statistik</a>
            <a href="{{ route('faq.index') }}">FAQ</a>
            <a href="{{ url('/jarsiplus/permohonan') }}">E-Panel Admin</a>
        </nav>
    </div>
    <div class="jp-footer__meta">BAPPEDALITBANG Kota Samarinda © {{ Carbon\Carbon::now()->year }} · JARSIPLUS</div>
</footer>
