@extends('template::layouts.master')

@section('title', 'Beranda — ' . config('app.name', 'JARSIPLUS Kota Samarinda'))

@section('content')
@if(me())
    {{-- Header sesi terautentikasi --}}
    @php
        $roleBadge = role_me() == 3 ? 'TIM VERIFIKATOR'
            : (role_me() == 4 ? 'PORTAL PEMOHON INOVASI' : 'E-PANEL ADMINISTRATOR');
        $unitKerja = optional(me()->pemohon)->unit_kerja;
    @endphp

    <x-page-header
        :badge="$roleBadge"
        eyebrow="Sesi SSO terverifikasi"
        :title="'Selamat datang, ' . me()->name"
    >
        @if(role_me() == 4)
            <a href="{{ route('permohonan.create') }}" class="jp-btn jp-btn--accent jp-btn--lg">
                <x-icon name="document" size="18" />
                Buat Usulan Inovasi Baru
            </a>
        @endif
    </x-page-header>

    <div class="jp-subhead">
        <div class="l-container jp-subhead__inner">
            <span class="jp-subhead__meta">
                <x-icon name="building" size="14" />
                Instansi / Perangkat Daerah:
                <strong>{{ $unitKerja ?? 'Pemerintah Kota Samarinda' }}</strong>
            </span>
            <span class="jp-subhead__meta">
                <x-icon name="user" size="14" />
                {{ me()->email }}
            </span>
        </div>
    </div>

    {{-- Konten sesuai peran --}}
    <div class="jp-section jp-section--sm">
        <div class="l-container">
            @if(role_me() == 4)
                @include("template::roles.pemohon")
            @elseif(role_me() == 3)
                @include("template::roles.tksd")
            @else
                <x-empty
                    icon="shield"
                    title="E-Panel Administrator"
                    desc="Anda terdaftar sebagai Administrator. Gunakan tombol di bawah untuk masuk ke dashboard pengelolaan."
                    :action="url('/jarsiplus')"
                    actionLabel="Masuk ke E-Panel Admin"
                />
            @endif
        </div>
    </div>
@else
    {{-- ================= TAMPILAN TAMU (PUBLIK) ================= --}}

    {{-- Hero --}}
    <section class="jp-hero">
        <div class="l-container">
            <div class="jp-hero__grid">
                <div class="jp-hero__copy">
                    <p class="jp-hero__eyebrow">
                        <span class="jp-hero__eyebrow-dot" aria-hidden="true"></span>
                        Pemerintah Kota Samarinda
                    </p>
                    <h1 class="jp-hero__title">Jaringan Inovasi <br class="u-hide-mobile">Plus Daerah</h1>
                    <p class="jp-hero__lede">
                        Platform resmi untuk mengajukan, mengevaluasi, dan memantau inovasi
                        pelayanan publik &amp; tata kelola pemerintahan di Kota Samarinda.
                    </p>
                    <div class="jp-hero__cta">
                        <a href="{{ url('/permohonan/create') }}" class="jp-btn jp-btn--accent jp-btn--lg">
                            <x-icon name="document" size="18" />
                            Ajukan Inovasi Baru
                        </a>
                        <a href="{{ url('/informasi') }}" class="jp-link-arrow">
                            Informasi Terbaru <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                    <p class="jp-hero__meta">Permohonan diproses secara transparan &amp; akuntabel</p>
                </div>

                <div class="jp-hero__demo">
                    <div class="jp-data-card">
                        <div class="jp-data-card__bar">
                            <span class="jp-data-card__dots" aria-hidden="true"><i></i><i></i><i></i></span>
                            <span class="jp-data-card__file">jarsiplus.samarindakota.go.id</span>
                            <span class="jp-data-card__status">
                                <span class="jp-data-card__status-dot" aria-hidden="true"></span>
                                online
                            </span>
                        </div>
                        <div class="jp-data-card__body">
                            <span class="jp-badge jp-badge--accent u-mb-xs">BAPPERIDA SAMARINDA</span>
                            <h3 class="u-mt-xs u-mb-xs">Indeks Inovasi Daerah (IGA) Kemendagri</h3>
                            <p class="jp-card__text u-mb-md">
                                Pemantauan, pengukuran kematangan indikator, dan verifikasi berkas
                                permohonan inovasi yang terintegrasi.
                            </p>
                            <div class="u-flex u-justify-between u-align-center u-gap-sm pt-3" style="border-top: 1px solid var(--c-border);">
                                <span class="font-mono" style="font-size: var(--t-2xs); color: var(--c-ink-subtle);">Status sistem: operasional</span>
                                <a href="{{ url('/informasi') }}" class="jp-link-arrow" style="font-size: var(--t-xs);">
                                    Selengkapnya <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Ringkasan angka --}}
    <div class="jp-strip">
        <div class="l-container jp-strip__inner">
            <div class="jp-strip__item">
                <span class="jp-strip__stat-value" data-count="{{ (int) $stats['total'] }}">0</span>
                <span class="jp-strip__stat-label">Total Permohonan</span>
            </div>
            <div class="jp-strip__item">
                <span class="jp-strip__stat-value" data-count="{{ (int) $stats['approved'] }}">0</span>
                <span class="jp-strip__stat-label">Inovasi Disetujui</span>
            </div>
            <div class="jp-strip__item">
                <span class="jp-strip__stat-value" data-count="{{ (int) $stats['process'] }}">0</span>
                <span class="jp-strip__stat-label">Dalam Proses</span>
            </div>
            <div class="jp-strip__item">
                <span class="jp-strip__stat-value" data-count="{{ (int) $stats['innovators'] }}">0</span>
                <span class="jp-strip__stat-label">Pemohon Terdaftar</span>
            </div>
        </div>
    </div>

    {{-- Seksi Komitmen Pimpinan & Perkembangan Inovasi Kota Samarinda --}}
    <section class="jp-section jp-section--leaders-banner">
        <div class="l-container">
            <div class="jp-leaders-banner">
                {{-- Kiri: 1 Frame Tunggal Berisi Foto Walikota & Wawali --}}
                <div class="jp-leader-group-card">
                    <div class="jp-leader-group-card__grid">
                        <div class="jp-leader-item">
                            <div class="jp-leader-item__img-wrap">
                                <img src="https://satudata.samarindakota.go.id/img/new-walikota.png" alt="Walikota Samarinda" class="jp-leader-item__img jp-leader-item__img--walikota" loading="lazy">
                            </div>
                            <div class="jp-leader-item__meta">
                                <span class="jp-leader-item__role">Walikota Samarinda</span>
                                <strong class="jp-leader-item__name">Dr. H. Andi Harun, S.T., S.H., M.Si.</strong>
                            </div>
                        </div>

                        <div class="jp-leader-item">
                            <div class="jp-leader-item__img-wrap">
                                <img src="https://satudata.samarindakota.go.id/img/new-wawali.png" alt="Wakil Walikota Samarinda" class="jp-leader-item__img jp-leader-item__img--wawali" loading="lazy">
                            </div>
                            <div class="jp-leader-item__meta">
                                <span class="jp-leader-item__role">Wakil Walikota Samarinda</span>
                                <strong class="jp-leader-item__name">Dr. H. Rusmadi, M.S.</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Kata-kata Perkembangan Inovasi --}}
                <div class="jp-leaders-banner__right">
                    <p class="jp-section__eyebrow">
                        <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                        Pemerintah Kota Samarinda
                    </p>
                    <h2 class="jp-leaders-banner__title">Akselerasi Inovasi untuk Samarinda Kota Pusat Peradaban</h2>
                    <blockquote class="jp-leaders-banner__quote">
                        &ldquo;Inovasi adalah kunci utama mempercepat transformasi pelayanan publik dan tata kelola pemerintahan yang unggul. Pemerintah Kota Samarinda terus berkomitmen menggerakkan budaya inovasi daerah yang terintegrasi demi kemajuan Kota Samarinda.&rdquo;
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    {{-- Sorotan / slider --}}
    @php
        $slideItems = [];
        if (isset($sliders) && $sliders->count() > 0) {
            $slideItems = $sliders->map(function ($s) {
                return [
                    'image' => $s->file ? asset($s->file) : null,
                    'title' => $s->judul ?? $s->label ?? null,
                    'desc'  => $s->label ?? null,
                ];
            })->filter(fn ($s) => !empty($s['image']))->values()->all();
        }

        // Slider Default jika data slider di database kosong / dihapus seluruhnya
        if (empty($slideItems)) {
            $slideItems = [
                [
                    'image' => asset('img/default-slider.png'),
                    'alt'   => 'Selamat Datang pada Jaringan Aplikasi Inovasi Plus Kota Samarinda',
                ]
            ];
        }
    @endphp

    <section class="jp-section jp-section--sm jp-section--sunken">
        <div class="l-container">
            <x-carousel id="sliderBeranda" :items="$slideItems" data-interval="6000" />
        </div>
    </section>

    {{-- Agenda & poster --}}
    @if(isset($events) && $events->count() > 0)
        <section class="jp-section jp-section--surface jp-section--divided">
            <div class="l-container">
                <div class="jp-section__head">
                    <p class="jp-section__eyebrow">
                        <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                        Agenda Inovasi
                    </p>
                    <h2 class="jp-section__title">Poster &amp; Event Lomba Terkini</h2>
                    <p class="jp-section__desc">Edaran, poster, dan agenda kegiatan inovasi daerah Kota Samarinda.</p>
                </div>

                {{-- Kartu membuka modal rincian, bukan menaut ke berkas gambar.
                     Sebelumnya href menunjuk langsung ke asset($ev->banner)
                     sehingga lightbox (lity) hanya menampilkan posternya saja,
                     padahal ada subtitle, deskripsi, edaran, panduan, dan
                     tautan pendaftaran yang tidak pernah terlihat. --}}
                <div class="u-scroll-x">
                    @foreach($events as $ev)
                        @php
                            $evBanner = $ev->banner ? asset($ev->banner) : asset('baimbai/Banner Lomba Baimbai 2026.jpeg');
                            $evRingkas = jp_isi($ev->subtitle) ?? jp_isi(strip_tags((string) $ev->description));
                        @endphp

                        <button type="button" class="jp-media-card" style="width: 300px;"
                                onclick="document.getElementById('modalEvent-{{ $ev->uuid ?? $ev->id }}').showModal()">
                            <div class="jp-media-card__media">
                                <img src="{{ $evBanner }}" alt="{{ $ev->title }}" loading="lazy"
                                     onerror="this.onerror=null; this.src='{{ asset('baimbai/Banner Lomba Baimbai 2026.jpeg') }}';">
                            </div>
                            <div class="jp-media-card__body">
                                <h3 class="jp-record-card__title jp-clamp-2">{{ $ev->title }}</h3>
                                <p class="jp-card__text jp-clamp-2">
                                    {{ $evRingkas ?? 'Klik untuk melihat rincian agenda, edaran, dan panduan.' }}
                                </p>
                                <div class="jp-media-card__foot">
                                    <span class="jp-link-arrow" style="font-size: var(--t-xs);">
                                        Lihat Detail <span aria-hidden="true">&rarr;</span>
                                    </span>
                                </div>
                            </div>
                        </button>

                        <dialog id="modalEvent-{{ $ev->uuid ?? $ev->id }}" class="jp-modal jp-modal--lg">
                            <div class="jp-modal__head">
                                <div style="min-width: 0;">
                                    <span class="jp-modal__eyebrow">AGENDA INOVASI</span>
                                    <h3 class="jp-modal__title">{{ $ev->title }}</h3>
                                </div>
                                <button type="button" class="jp-modal__close" aria-label="Tutup"
                                        onclick="this.closest('dialog').close()">
                                    <x-icon name="close" size="22" />
                                </button>
                            </div>

                            <div class="jp-modal__body">
                                <a href="{{ $evBanner }}" data-lity class="jp-event-poster">
                                    <img src="{{ $evBanner }}" alt="Poster {{ $ev->title }}" loading="lazy"
                                         onerror="this.onerror=null; this.src='{{ asset('baimbai/Banner Lomba Baimbai 2026.jpeg') }}';">
                                    <span class="jp-event-poster__hint">
                                        <x-icon name="search" size="14" /> Klik untuk perbesar poster
                                    </span>
                                </a>

                                @if(jp_isi($ev->subtitle))
                                    <p class="jp-section__desc u-mt-md">{{ $ev->subtitle }}</p>
                                @endif

                                @if(jp_isi(strip_tags((string) $ev->description)))
                                    <div class="jp-prose u-mt-md" style="white-space: pre-line;">
                                        {{ strip_tags((string) $ev->description) }}
                                    </div>
                                @else
                                    <p class="jp-prose jp-prose--empty u-mt-md">Belum ada uraian untuk agenda ini.</p>
                                @endif

                                @php
                                    $lampiran = array_filter([
                                        'Unduh Edaran' => jp_isi($ev->file_edaran),
                                        'Unduh Panduan' => jp_isi($ev->file_panduan),
                                    ]);
                                @endphp

                                @if(count($lampiran) > 0)
                                    <div class="u-mt-lg">
                                        <span class="jp-deflist__label u-block u-mb-xs">Dokumen</span>
                                        <div class="u-flex u-gap-xs u-flex-wrap">
                                            @foreach($lampiran as $labelDok => $berkas)
                                                <a href="{{ asset($berkas) }}" target="_blank" rel="noopener" class="jp-btn jp-btn--ghost jp-btn--sm">
                                                    <x-icon name="download" size="15" />
                                                    {{ $labelDok }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="jp-modal__foot">
                                <button type="button" class="jp-btn jp-btn--ghost" onclick="this.closest('dialog').close()">Tutup</button>
                                @if(jp_isi($ev->url_daftar))
                                    <a href="{{ $ev->url_daftar }}" target="_blank" rel="noopener" class="jp-btn jp-btn--accent">
                                        Daftar Sekarang <span aria-hidden="true">&rarr;</span>
                                    </a>
                                @else
                                    <a href="{{ url('/permohonan/create') }}" class="jp-btn jp-btn--accent">
                                        Ajukan Inovasi <span aria-hidden="true">&rarr;</span>
                                    </a>
                                @endif
                            </div>
                        </dialog>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Layanan utama --}}
    <section class="jp-section jp-section--surface">
        <div class="l-container">
            <div class="jp-section__head">
                <h2 class="jp-section__title">Layanan &amp; Portal Utama</h2>
                <p class="jp-section__desc">Akses cepat ke seluruh fitur pengajuan, informasi, dan transparansi data inovasi.</p>
            </div>

            <div class="l-grid l-grid--4 u-mb-xl">
                <a href="{{ url('/permohonan/create') }}" class="jp-action-card jp-action-card--accent">
                    <div>
                        <span class="jp-action-card__icon-box"><x-icon name="document" size="22" /></span>
                        <h3 class="jp-action-card__title">Pengajuan Inovasi</h3>
                        <p class="jp-action-card__desc">Ajukan usulan inovasi daerah baru melalui formulir terintegrasi Segment 1–3.</p>
                    </div>
                    <span class="jp-action-card__link">Mulai Pengajuan <span aria-hidden="true">&rarr;</span></span>
                </a>

                <a href="{{ url('/informasi') }}" class="jp-action-card jp-action-card--teal">
                    <div>
                        <span class="jp-action-card__icon-box jp-action-card__icon-box--teal"><x-icon name="info" size="22" /></span>
                        <h3 class="jp-action-card__title">Informasi Resmi</h3>
                        <p class="jp-action-card__desc">Pengumuman resmi, jadwal pelaksanaan lomba, dan berita inovasi Samarinda.</p>
                    </div>
                    <span class="jp-action-card__link">Lihat Informasi <span aria-hidden="true">&rarr;</span></span>
                </a>

                <a href="{{ url('/statistik') }}" class="jp-action-card jp-action-card--success">
                    <div>
                        <span class="jp-action-card__icon-box jp-action-card__icon-box--success"><x-icon name="chart" size="22" /></span>
                        <h3 class="jp-action-card__title">Statistik &amp; Data</h3>
                        <p class="jp-action-card__desc">Dashboard visualisasi grafik dan data transparansi permohonan.</p>
                    </div>
                    <span class="jp-action-card__link">Buka Statistik <span aria-hidden="true">&rarr;</span></span>
                </a>

                <a href="{{ url('/faq') }}" class="jp-action-card jp-action-card--amber">
                    <div>
                        <span class="jp-action-card__icon-box jp-action-card__icon-box--amber"><x-icon name="info" size="22" /></span>
                        <h3 class="jp-action-card__title">FAQ &amp; Bantuan</h3>
                        <p class="jp-action-card__desc">Pertanyaan umum, petunjuk teknis, dan alur verifikasi berkas permohonan.</p>
                    </div>
                    <span class="jp-action-card__link">Buka FAQ <span aria-hidden="true">&rarr;</span></span>
                </a>
            </div>

            {{-- Lacak usulan --}}
            <form action="{{ url('/permohonan') }}" method="GET" class="jp-inline-panel">
                <div class="jp-inline-panel__label">
                    <x-icon name="search" size="18" style="color: var(--c-accent);" />
                    <div>
                        <label for="lacakKodePublik" class="jp-label">Lacak status permohonan inovasi</label>
                        <p class="jp-field__hint">Masukkan kode pengajuan untuk melihat progres verifikasi oleh Tim Verifikator (TKSD).</p>
                    </div>
                </div>

                <div class="jp-searchbar jp-inline-panel__control">
                    <input type="text" id="lacakKodePublik" name="kode" class="jp-input" placeholder="Contoh: 4769fe91">
                    <button type="submit" class="jp-btn jp-btn--accent">Cari Kode</button>
                </div>
            </form>
        </div>
    </section>

    {{-- Tentang JARSIPLUS --}}
    <section class="jp-section jp-section--sunken jp-section--divided">
        <div class="l-container">
            <div class="jp-section__head">
                <h2 class="jp-section__title">Apa itu JARSIPLUS Kota Samarinda?</h2>
                <p class="jp-section__desc">
                    <strong>JARSIPLUS (Jaringan Inovasi Plus Daerah)</strong> adalah sistem informasi terpadu yang
                    dikembangkan Bapperida Pemerintah Kota Samarinda untuk menghimpun, mengelola, mengevaluasi,
                    serta mempublikasikan inovasi daerah di bidang pelayanan publik dan tata kelola pemerintahan.
                </p>
            </div>

            <div class="l-grid l-grid--3">
                <div class="jp-card">
                    <span class="font-mono text-accent" style="font-size: var(--t-2xs); font-weight: 700;">TERTATA &amp; TERSTRUKTUR</span>
                    <h4 class="u-mt-xs u-mb-xs">Pengajuan Standar IGA</h4>
                    <p class="jp-card__text">Pengisian parameter &amp; indikator inovasi sesuai standar Indeks Inovasi Daerah (IGA) Kementerian Dalam Negeri.</p>
                </div>

                <div class="jp-card">
                    <span class="font-mono text-accent" style="font-size: var(--t-2xs); font-weight: 700;">TRANSPARAN</span>
                    <h4 class="u-mt-xs u-mb-xs">Pelacakan Berkas</h4>
                    <p class="jp-card__text">Setiap permohonan memiliki kode unik pelacakan sehingga pemohon dapat memantau posisi berkas kapan saja.</p>
                </div>

                <div class="jp-card">
                    <span class="font-mono text-accent" style="font-size: var(--t-2xs); font-weight: 700;">INTEGRASI TERPUSAT</span>
                    <h4 class="u-mt-xs u-mb-xs">SSO Pemkot Samarinda</h4>
                    <p class="jp-card__text">Terhubung dengan Single Sign-On Samarinda untuk menjamin keamanan identitas pemohon dan kemudahan akses.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Alur pengajuan --}}
    <section class="jp-section jp-section--surface jp-section--divided">
        <div class="l-container">
            <div class="jp-section__head">
                <h2 class="jp-section__title">Alur Pengajuan &amp; Verifikasi</h2>
                <p class="jp-section__desc">Empat tahapan pengusulan inovasi hingga penetapan dan publikasi.</p>
            </div>

            <div class="l-grid l-grid--4 u-mb-2xl">
                @php
                    $alur = [
                        ['01', 'Login SSO Samarinda', 'Masuk menggunakan akun Single Sign-On resmi Pemerintah Kota Samarinda.'],
                        ['02', 'Isi Profil & Inovasi', 'Lengkapi biodata diri, data umum usulan, dan deskripsi inovasi (Segment 1–3).'],
                        ['03', 'Upload Bukti Dukung', 'Unggah berkas indikator pendukung sesuai petunjuk teknis pengajuan.'],
                        ['04', 'Pembahasan TKSD', 'Tim Verifikator meninjau berkas hingga dinyatakan tervalidasi atau selesai.'],
                    ];
                @endphp

                @foreach($alur as [$no, $judul, $desc])
                    <div class="jp-card">
                        <span class="font-mono text-accent" style="font-size: 1.5rem; font-weight: 800; line-height: 1;">{{ $no }}</span>
                        <h4 class="u-mt-xs u-mb-xs">{{ $judul }}</h4>
                        <p class="jp-card__text">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>

            <div class="jp-section__head">
                <h2 class="jp-section__title">Kategori Inovasi Daerah</h2>
                <p class="jp-section__desc">Tiga kategori utama sesuai standar Indeks Inovasi Daerah (IGA) Kemendagri.</p>
            </div>

            <div class="l-grid l-grid--3">
                @php
                    $kategoriList = [
                        ['KATEGORI 01', 'Tata Kelola Pemerintahan', 'Inovasi manajemen internal Perangkat Daerah, efisiensi birokrasi, tata kelola keuangan, serta digitalisasi sistem kerja.'],
                        ['KATEGORI 02', 'Pelayanan Publik', 'Inovasi layanan langsung kepada masyarakat di bidang kesehatan, pendidikan, perizinan, kependudukan, dan sosial.'],
                        ['KATEGORI 03', 'Inovasi Daerah Lainnya', 'Inovasi di bidang urusan pemerintahan lain yang menjadi kewenangan daerah sesuai peraturan perundang-undangan.'],
                    ];
                @endphp

                @foreach($kategoriList as [$badge, $judul, $desc])
                    <div class="jp-card u-flex u-flex-col">
                        <span class="jp-badge jp-badge--accent u-self-start">{{ $badge }}</span>
                        <h3 class="u-mt-xs u-mb-xs">{{ $judul }}</h3>
                        <p class="jp-card__text u-mb-md">{{ $desc }}</p>
                        <div class="u-mt-auto pt-3" style="border-top: 1px solid var(--c-border);">
                            <a href="{{ url('/permohonan/create') }}" class="jp-btn jp-btn--ghost jp-btn--sm u-w-100">
                                Ajukan Kategori Ini <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Katalog inovasi --}}
    <section class="jp-section jp-section--sunken jp-section--divided">
        <div class="l-container">
            <div class="u-flex u-justify-between u-align-end u-flex-wrap u-gap-sm u-mb-lg">
                <div class="jp-section__head u-mb-0">
                    <p class="jp-section__eyebrow">
                        <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                        Katalog Inovasi Daerah
                    </p>
                    <h2 class="jp-section__title">Inovasi Terdaftar &amp; Tervalidasi</h2>
                    <p class="jp-section__desc">Hasil inovasi Perangkat Daerah, UPTD, dan masyarakat Kota Samarinda.</p>
                </div>
                <a href="{{ route('inovasi.index') }}" class="jp-btn jp-btn--ghost jp-btn--sm">Lihat Semua Inovasi</a>
            </div>

            @php
                // Katalog publik hanya menampilkan usulan yang sudah lolos validasi.
                // Status 0 (menunggu validasi) dan 9 (ditolak) dikecualikan agar
                // usulan yang belum diverifikasi tidak ikut terpublikasi.
                $katalog = collect($inovasis ?? [])->whereIn('status', [1, 2, 4])->take(6);
            @endphp

            @if($katalog->count() > 0)
                <div class="l-grid l-grid--3">
                    @foreach($katalog as $inovasi)
                        @php
                            $kategoriNama = optional($inovasi->kategori)->label ?? $inovasi->urusan_utama ?? null;
                            $opdNama = jp_isi(optional($inovasi->pemohon1)->unit_kerja);
                            $deskripsi = trim(strip_tags((string) ($inovasi->rancang_bangun ?? $inovasi->tujuan_inovasi ?? '')));

                            // Rute publik: tidak butuh login dan tidak memuat data pribadi inovator.
                            $tautan = route('inovasi.show', $inovasi->uuid);

                            if ($inovasi->status == 4) {
                                $statusLabel = 'Tervalidasi';
                                $statusClass = 'jp-badge--success';
                                $tone = 'jp-record-card--success';
                            } else {
                                $statusLabel = 'Pembahasan';
                                $statusClass = 'jp-badge--accent';
                                $tone = 'jp-record-card--accent';
                            }
                        @endphp

                        <article class="jp-record-card {{ $tone }}">
                            <header class="jp-record-card__head">
                                <span class="jp-badge jp-badge--neutral u-truncate" style="max-width: 62%;">
                                    {{ $kategoriNama ?? 'Inovasi Daerah' }}
                                </span>
                                <span class="jp-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                            </header>

                            <div class="jp-record-card__body">
                                <h3 class="jp-record-card__title jp-clamp-2">
                                    <a href="{{ $tautan }}">{{ $inovasi->label ?? 'Usulan Inovasi Samarinda' }}</a>
                                </h3>

                                <div class="jp-record-card__meta">
                                    <x-icon name="building" size="14" style="color: var(--c-ink-subtle);" />
                                    <span class="u-truncate">{{ $opdNama ?? 'Instansi belum dicantumkan' }}</span>
                                </div>

                                <p class="jp-card__text jp-clamp-3">
                                    {{ $deskripsi !== '' ? Str::limit($deskripsi, 120) : 'Deskripsi inovasi belum tersedia.' }}
                                </p>
                            </div>

                            <footer class="jp-record-card__foot u-justify-between">
                                <span class="font-mono" style="font-size: var(--t-2xs); color: var(--c-ink-subtle);">
                                    Tahun {{ $inovasi->tahun ?? ($inovasi->created_at ? $inovasi->created_at->format('Y') : '—') }}
                                </span>
                                <a href="{{ $tautan }}" class="jp-link-arrow" style="font-size: var(--t-xs);">
                                    Detail <span aria-hidden="true">&rarr;</span>
                                </a>
                            </footer>
                        </article>
                    @endforeach
                </div>
            @else
                <x-empty
                    icon="folder"
                    title="Belum ada inovasi terdaftar"
                    desc="Saat ini belum ada inovasi daerah yang terdaftar dan tervalidasi pada katalog."
                />
            @endif
        </div>
    </section>

    {{-- Informasi & pengumuman --}}
    <section class="jp-section jp-section--surface jp-section--divided">
        <div class="l-container">
            <div class="u-flex u-justify-between u-align-end u-flex-wrap u-gap-sm u-mb-lg">
                <div class="jp-section__head u-mb-0">
                    <p class="jp-section__eyebrow">
                        <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                        Informasi Resmi
                    </p>
                    <h2 class="jp-section__title">Informasi &amp; Pengumuman</h2>
                    <p class="jp-section__desc">Publikasi edaran resmi, petunjuk teknis, dan pengumuman terbaru.</p>
                </div>
                <a href="{{ url('/informasi') }}" class="jp-btn jp-btn--ghost jp-btn--sm">Lihat Semua Informasi</a>
            </div>

            @if(isset($lamans) && count($lamans) > 0)
                <div class="l-grid l-grid--3">
                    @foreach($lamans as $laman)
                        @php
                            $ringkas = trim(strip_tags((string) $laman->content));
                        @endphp
                        <a href="{{ url('/informasi/' . ($laman->slug ?? $laman->id)) }}" class="jp-card jp-card--interactive u-flex u-flex-col">
                            <span class="font-mono" style="font-size: var(--t-2xs); color: var(--c-ink-subtle);">
                                {{ $laman->created_at ? $laman->created_at->format('d M Y') : '—' }}
                            </span>
                            <h3 class="u-mt-xs u-mb-xs jp-clamp-2">{{ jp_isi($laman->label) ?? 'Pengumuman Resmi' }}</h3>
                            <p class="jp-card__text jp-clamp-3 u-mb-md">
                                {{ $ringkas !== '' ? Str::limit($ringkas, 120) : 'Ringkasan belum tersedia.' }}
                            </p>
                            <div class="u-mt-auto pt-3" style="border-top: 1px solid var(--c-border);">
                                <span class="jp-link-arrow" style="font-size: var(--t-xs);">
                                    Baca Selengkapnya <span aria-hidden="true">&rarr;</span>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <x-empty
                    icon="info"
                    title="Belum ada informasi"
                    desc="Saat ini belum ada informasi resmi yang dipublikasikan."
                />
            @endif
        </div>
    </section>

    {{-- Ajakan --}}
    <section class="jp-section--graphite">
        <div class="l-container">
            <div class="l-grid l-grid--2 u-align-center">
                <div>
                    <h2 style="font-size: var(--t-3xl); margin-bottom: 10px;">Mulai dari satu ide.<br>Jadikan inovasi daerah.</h2>
                    <p class="u-mb-lg">
                        Ajukan usulan inovasi Anda melalui portal JARSIPLUS Kota Samarinda —
                        prosesnya mudah, transparan, dan terukur.
                    </p>
                    <div class="u-flex u-gap-sm u-flex-wrap u-align-center">
                        <a href="{{ url('/permohonan/create') }}" class="jp-btn jp-btn--accent jp-btn--lg">
                            <x-icon name="document" size="18" />
                            Ajukan Inovasi Baru
                        </a>
                        <a href="{{ url('/faq') }}" class="jp-btn jp-btn--ghost jp-btn--lg">
                            Pertanyaan Umum (FAQ)
                        </a>
                    </div>
                </div>

                <div>
                    <div class="jp-panel-dark">
                        <span class="font-mono" style="color: var(--c-sky); font-size: var(--t-2xs); font-weight: 700;">INTEGRASI TERPUSAT</span>
                        <h3 class="u-mt-xs u-mb-xs">Single Sign-On Pemkot Samarinda</h3>
                        <p class="u-mb-md">Satu akun SSO untuk seluruh layanan publik dan tata kelola pemerintah Kota Samarinda.</p>
                        <a href="{{ url('/login') }}" style="color: var(--c-sky); font-weight: 700; font-size: var(--t-sm);">
                            Masuk SSO Samarinda <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection
