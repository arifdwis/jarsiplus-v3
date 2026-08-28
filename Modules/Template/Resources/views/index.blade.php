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
                    :action="url('/home')"
                    actionLabel="Masuk ke E-Panel Admin"
                />
            @endif
        </div>
    </div>
@else
    {{-- ================= TAMPILAN TAMU (PUBLIK) ================= --}}

    {{-- 1. Hero --}}
    <section class="jp-hero">
        <div class="l-container">
            <div class="jp-hero__grid">
                <div class="jp-hero__copy">
                    <p class="jp-hero__eyebrow">
                        <span class="jp-hero__eyebrow-dot" aria-hidden="true"></span>
                        Pemerintah Kota Samarinda
                    </p>
                    <h1 class="jp-hero__title">Jaringan Aplikasi <br class="u-hide-mobile">Inovasi Plus</h1>
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

    {{-- 2. Ringkasan angka --}}
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

    {{-- 3. Layanan & Portal Utama (asimetris: kartu primer + 3 titik layanan) --}}
    <section class="jp-section jp-section--surface">
        <div class="l-container">
            <div class="jp-section__head">
                <h2 class="jp-section__title">Layanan &amp; Portal Utama</h2>
                <p class="jp-section__desc">Akses cepat ke seluruh fitur pengajuan, informasi, dan transparansi data inovasi.</p>
            </div>

            <div class="jp-service-grid">
                {{-- Kartu primer: aksi utama --}}
                <a href="{{ url('/permohonan/create') }}" class="jp-service-feature">
                    <span class="jp-service-feature__icon"><x-icon name="document" size="24" /></span>
                    <div class="jp-service-feature__main">
                        <h3 class="jp-service-feature__title">Pengajuan Inovasi</h3>
                        <p class="jp-service-feature__desc">Ajukan usulan inovasi daerah baru melalui formulir terintegrasi Segment 1–3, lengkap dengan unggah bukti dukung.</p>
                    </div>
                    <span class="jp-service-feature__cta">Mulai Pengajuan <span aria-hidden="true">&rarr;</span></span>
                </a>

                {{-- Kolom kanan: 3 titik layanan --}}
                <div class="jp-service-points">
                    <a href="{{ url('/informasi') }}" class="jp-service-point">
                        <span class="jp-service-point__icon"><x-icon name="info" size="18" /></span>
                        <span class="jp-service-point__body">
                            <strong>Informasi Resmi</strong>
                            <small>Pengumuman resmi, jadwal lomba, dan berita inovasi Samarinda.</small>
                        </span>
                        <span class="jp-service-point__arrow" aria-hidden="true">&rarr;</span>
                    </a>
                    <a href="{{ url('/statistik') }}" class="jp-service-point">
                        <span class="jp-service-point__icon"><x-icon name="chart" size="18" /></span>
                        <span class="jp-service-point__body">
                            <strong>Statistik &amp; Data</strong>
                            <small>Dashboard visualisasi dan transparansi data permohonan.</small>
                        </span>
                        <span class="jp-service-point__arrow" aria-hidden="true">&rarr;</span>
                    </a>
                    <button type="button" class="jp-service-point" onclick="document.getElementById('modalPengaduan').showModal()"><span class="jp-service-point__icon"><x-icon name="chat" size="18" /></span><span class="jp-service-point__body"><strong>Layanan Pengaduan</strong><small>Sampaikan kendala dan masukan terkait JARSIPLUS.</small></span><span class="jp-service-point__arrow" aria-hidden="true">&rarr;</span></button>
                    <a href="{{ url('/faq') }}" class="jp-service-point">
                        <span class="jp-service-point__icon"><x-icon name="chat" size="18" /></span>
                        <span class="jp-service-point__body">
                            <strong>FAQ &amp; Bantuan</strong>
                            <small>Petunjuk teknis dan alur verifikasi berkas permohonan.</small>
                        </span>
                        <span class="jp-service-point__arrow" aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            {{-- Lacak usulan --}}
            <form action="{{ url('/permohonan') }}" method="GET" class="jp-inline-panel">
                <div class="jp-inline-panel__label">
                    <x-icon name="search" size="18" class="jp-icon-accent" />
                    <div>
                        <label for="lacakKodePublik" class="jp-label">Lacak status permohonan inovasi</label>
                        <p class="jp-field__hint">Masukkan kode pengajuan untuk melihat progres verifikasi oleh Tim Verifikator.</p>
                    </div>
                </div>

                <div class="jp-searchbar jp-inline-panel__control">
                    <input type="text" id="lacakKodePublik" name="kode" class="jp-input" placeholder="Contoh: 4769fe91">
                    <button type="submit" class="jp-btn jp-btn--accent">Cari Kode</button>
                </div>
            </form>
        </div>
    </section>

    {{-- 4. Agenda & poster --}}
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
                            $evBanner = $ev->banner ? file_url($ev->banner) : asset('baimbai/Banner Lomba Baimbai 2026.jpeg');
                            $evRingkas = jp_isi($ev->subtitle) ?? jp_isi(strip_tags((string) $ev->description));
                        @endphp

                        <button type="button" class="jp-media-card"
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
                                    <span class="jp-link-arrow">
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
                                    <div class="jp-prose jp-prose--pre u-mt-md">
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
                                                <a href="{{ file_url($berkas) }}" target="_blank" rel="noopener" class="jp-btn jp-btn--ghost jp-btn--sm">
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

    {{-- 5. Sorotan / slider --}}
    @php
        $slideItems = [];
        if (isset($sliders) && $sliders->count() > 0) {
            $slideItems = $sliders->map(function ($s) {
                return [
                    'image' => $s->file ? file_url($s->file) : null,
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
                    'alt'   => 'Selamat Datang pada Aplikasi Penjaringan Inovasi Kota Samarinda',
                ]
            ];
        }
    @endphp

    <section class="jp-section jp-section--sm jp-section--sunken">
        <div class="l-container">
            <x-carousel id="sliderBeranda" :items="$slideItems" data-interval="6000" />
        </div>
    </section>

    {{-- 6. Katalog inovasi (asimetris: unggulan + daftar ringkas) --}}
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
                $katalog = collect($inovasis ?? [])->whereIn('status', [1, 2, 4])->take(7);
                $featured = $katalog->shift();
            @endphp

            @if($katalog->count() > 0 || $featured)
                <div class="jp-catalog">
                    @if($featured)
                        @php
                            $kategoriNama = optional($featured->kategori)->label ?? $featured->urusan_utama ?? null;
                            $opdNama = jp_isi(optional($featured->pemohon1)->unit_kerja);
                            $deskripsi = trim(strip_tags((string) ($featured->rancang_bangun ?? $featured->tujuan_inovasi ?? '')));
                            $tautan = route('inovasi.show', $featured->uuid);
                            $statusLabelF = $featured->status == 4 ? 'Tervalidasi' : 'Pembahasan';
                            $statusClassF = $featured->status == 4 ? 'jp-badge--success' : 'jp-badge--accent';
                            $tahunF = $featured->tahun ?? ($featured->created_at ? $featured->created_at->format('Y') : '—');
                        @endphp

                        <article class="jp-catalog-feature">
                            <header class="jp-catalog-feature__head">
                                <span class="jp-badge jp-badge--neutral u-truncate">{{ $kategoriNama ?? 'Inovasi Daerah' }}</span>
                                <span class="jp-badge {{ $statusClassF }}">{{ $statusLabelF }}</span>
                            </header>
                            <h3 class="jp-catalog-feature__title">
                                <a href="{{ $tautan }}">{{ $featured->label ?? 'Usulan Inovasi Samarinda' }}</a>
                            </h3>
                            <p class="jp-catalog-feature__desc jp-clamp-3">
                                {{ $deskripsi !== '' ? Str::limit($deskripsi, 220) : 'Deskripsi inovasi belum tersedia.' }}
                            </p>
                            <footer class="jp-catalog-feature__meta">
                                <span class="u-truncate">
                                    <x-icon name="building" size="14" class="jp-icon-accent" />
                                    {{ $opdNama ?? 'Instansi belum dicantumkan' }}
                                </span>
                                <span class="font-mono">Tahun {{ $tahunF }}</span>
                                <a href="{{ $tautan }}" class="jp-link-arrow">Detail <span aria-hidden="true">&rarr;</span></a>
                            </footer>
                        </article>
                    @endif

                    @if($katalog->count() > 0)
                        <div class="jp-catalog-list">
                            @foreach($katalog as $inovasi)
                                @php
                                    $invKategori = optional($inovasi->kategori)->label ?? $inovasi->urusan_utama ?? null;
                                    $invOpd = jp_isi(optional($inovasi->pemohon1)->unit_kerja);
                                    $invTautan = route('inovasi.show', $inovasi->uuid);
                                    $invStatus = $inovasi->status == 4 ? 'Tervalidasi' : 'Pembahasan';
                                    $invClass = $inovasi->status == 4 ? 'jp-badge--success' : 'jp-badge--accent';
                                @endphp
                                <a href="{{ $invTautan }}" class="jp-catalog-item">
                                    <span class="jp-catalog-item__body">
                                        <strong class="jp-clamp-1">{{ $inovasi->label ?? 'Usulan Inovasi Samarinda' }}</strong>
                                        <small class="u-truncate">{{ $invOpd ?? 'Instansi belum dicantumkan' }}</small>
                                    </span>
                                    <span class="jp-badge {{ $invClass }}">{{ $invStatus }}</span>
                                    <span class="jp-catalog-item__arrow" aria-hidden="true">&rarr;</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
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

    {{-- 7. Alur pengajuan & kategori (satu section, dua kolom) --}}
    <section class="jp-section jp-section--surface jp-section--divided">
        <div class="l-container">
            @php
                $alur = [
                    ['01', 'Login SSO Samarinda', 'Masuk menggunakan akun Single Sign-On resmi Pemerintah Kota Samarinda.'],
                    ['02', 'Isi Profil & Inovasi', 'Lengkapi biodata diri, data umum usulan, dan deskripsi inovasi (Segment 1–3).'],
                    ['03', 'Upload Bukti Dukung', 'Unggah berkas indikator pendukung sesuai petunjuk teknis pengajuan.'],
                    ['04', 'Pembahasan Tim Verifikator', 'Tim Verifikator meninjau berkas hingga dinyatakan tervalidasi atau selesai.'],
                ];

                $kategoriList = [
                    ['KATEGORI 01', 'Tata Kelola Pemerintahan', 'Inovasi manajemen internal Perangkat Daerah, efisiensi birokrasi, tata kelola keuangan, serta digitalisasi sistem kerja.'],
                    ['KATEGORI 02', 'Pelayanan Publik', 'Inovasi layanan langsung kepada masyarakat di bidang kesehatan, pendidikan, perizinan, kependudukan, dan sosial.'],
                    ['KATEGORI 03', 'Inovasi Daerah Lainnya', 'Inovasi di bidang urusan pemerintahan lain yang menjadi kewenangan daerah sesuai peraturan perundang-undangan.'],
                ];
            @endphp

            <div class="jp-section__head">
                <p class="jp-section__eyebrow">
                    <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                    Alur &amp; Kategori
                </p>
                <h2 class="jp-section__title">Alur Pengajuan &amp; Kategori Inovasi</h2>
                <p class="jp-section__desc">Empat tahapan pengusulan inovasi hingga penetapan dan publikasi, dengan tiga kategori binaan sesuai standar IGA Kemendagri.</p>
            </div>

            <div class="jp-flow">
                <div class="jp-flow-list">
                    @foreach($alur as [$no, $judul, $desc])
                        <div class="jp-flow-item">
                            <span class="jp-flow-num">{{ $no }}</span>
                            <div class="jp-flow-body">
                                <h3 class="jp-flow-title">{{ $judul }}</h3>
                                <p class="jp-flow-desc">{{ $desc }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="jp-cats">
                    @foreach($kategoriList as [$badge, $judul, $desc])
                        <div class="jp-cat">
                            <span class="jp-flow-num">0{{ $loop->iteration }}</span>
                            <div class="jp-cat__body">
                                <h3 class="jp-cat__title">{{ $judul }}</h3>
                                <p class="jp-cat__desc">{{ $desc }}</p>
                                <a href="{{ url('/permohonan/create') }}" class="jp-btn jp-btn--ghost jp-btn--sm">
                                    Ajukan Kategori Ini <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- 8. Tentang JARSIPLUS --}}
    <section class="jp-section jp-section--sunken jp-section--divided">
        <div class="l-container">
            <div class="jp-section__head">
                <h2 class="jp-section__title">Apa itu JARSIPLUS Kota Samarinda?</h2>
                <p class="jp-section__desc">
                    <strong>JARSIPLUS (Jaringan Aplikasi Inovasi Plus Kota Samarinda)</strong> adalah sistem informasi terpadu yang
                    dikembangkan Bapperida Pemerintah Kota Samarinda untuk menghimpun, mengelola, mengevaluasi,
                    serta mempublikasikan inovasi daerah di bidang pelayanan publik dan tata kelola pemerintahan.
                </p>
            </div>

            <div class="l-grid l-grid--3">
                <div class="jp-card">
                    <span class="jp-badge jp-badge--accent u-self-start">TERTATA &amp; TERSTRUKTUR</span>
                    <h4 class="u-mt-xs u-mb-xs">Pengajuan Standar IGA</h4>
                    <p class="jp-card__text">Pengisian parameter &amp; indikator inovasi sesuai standar Indeks Inovasi Daerah (IGA) Kementerian Dalam Negeri.</p>
                </div>

                <div class="jp-card">
                    <span class="jp-badge jp-badge--accent u-self-start">TRANSPARAN</span>
                    <h4 class="u-mt-xs u-mb-xs">Pelacakan Berkas</h4>
                    <p class="jp-card__text">Setiap permohonan memiliki kode unik pelacakan sehingga pemohon dapat memantau posisi berkas kapan saja.</p>
                </div>

                <div class="jp-card">
                    <span class="jp-badge jp-badge--accent u-self-start">INTEGRASI TERPUSAT</span>
                    <h4 class="u-mt-xs u-mb-xs">SSO Pemkot Samarinda</h4>
                    <p class="jp-card__text">Terhubung dengan Single Sign-On Samarinda untuk menjamin keamanan identitas pemohon dan kemudahan akses.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 9. Informasi & pengumuman (daftar garis halus) --}}
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
                <div class="jp-info-list">
                    @foreach($lamans as $laman)
                        @php
                            $ringkas = trim(strip_tags((string) $laman->content));
                        @endphp
                        <a href="{{ url('/informasi/' . ($laman->slug ?? $laman->id)) }}" class="jp-info-row">
                            <span class="jp-info-row__date">{{ $laman->created_at ? $laman->created_at->format('d M Y') : '—' }}</span>
                            <span class="jp-info-row__title jp-clamp-1">{{ jp_isi($laman->label) ?? 'Pengumuman Resmi' }}</span>
                            <span class="jp-info-row__arrow" aria-hidden="true">&rarr;</span>
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

    {{-- 10. Komitmen Pimpinan & Perkembangan Inovasi --}}
    <section class="jp-section jp-section--leaders-banner">
        <div class="l-container">
            <div class="jp-section__head">
                <p class="jp-section__eyebrow">
                    <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                    Komitmen Pimpinan
                </p>
                <h2 class="jp-section__title">Akselerasi Inovasi untuk Samarinda Kota Pusat Peradaban</h2>
            </div>

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

                {{-- Kanan: Kata-kata Komitmen --}}
                <div class="jp-leaders-banner__right">
                    <blockquote class="jp-leaders-banner__quote">
                        &ldquo;Inovasi adalah kunci utama mempercepat transformasi pelayanan publik dan tata kelola pemerintahan yang unggul. Pemerintah Kota Samarinda terus berkomitmen menggerakkan budaya inovasi daerah yang terintegrasi demi kemajuan Kota Samarinda.&rdquo;
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    {{-- 11. Ajakan --}}
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
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<dialog id="modalPengaduan" class="jp-modal jp-modal--lg"><div class="jp-modal__head"><h3 class="jp-modal__title">Layanan Pengaduan JARSIPLUS</h3><button type="button" class="jp-modal__close" onclick="this.closest('dialog').close()"><x-icon name="close" size="22" /></button></div><div class="jp-modal__body"><p>Sampaikan kendala, masukan, atau laporan terkait layanan JARSIPLUS.</p><form method="POST" action="{{ route('pengaduan.store') }}">@csrf<input class="jp-input u-mb-sm" name="nama" required placeholder="Nama lengkap"><input class="jp-input u-mb-sm" name="email" type="email" placeholder="Email"><input class="jp-input u-mb-sm" name="telepon" placeholder="Nomor WhatsApp"><select class="jp-input u-mb-sm" name="kategori" required><option value="">Pilih kategori</option><option>Gangguan Sistem</option><option>Pengajuan Inovasi</option><option>Verifikasi</option><option>Lainnya</option></select><input class="jp-input u-mb-sm" name="judul" required placeholder="Judul pengaduan"><textarea class="jp-input u-mb-md" name="isi" rows="5" required placeholder="Isi pengaduan"></textarea><div class="cf-turnstile u-mb-md" data-sitekey="{{ config('services.cloudflare.turnstile.site_key') }}"></div><button class="jp-btn jp-btn--accent">Kirim Pengaduan</button></form></div></dialog>
@endif
@endsection