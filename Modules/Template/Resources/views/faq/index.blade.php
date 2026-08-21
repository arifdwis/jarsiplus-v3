@extends('template::layouts.master')

@section('title', 'Pertanyaan Umum (FAQ) — ' . config('app.name', 'JARSIPLUS Samarinda'))

@section('content')
@php
    $faqs = $faqs ?? (class_exists('Modules\Faq\Entities\Faq') ? Modules\Faq\Entities\Faq::get() : collect([]));

    $defaultFaqs = [
        [
            'question' => 'Bagaimana cara mengakses dan menggunakan sistem JARSIPLUS?',
            'answer' => 'Pengguna dapat mengakses portal JARSIPLUS secara langsung melalui peramban web menggunakan URL resmi <a href="https://jarsiplus.samarindakota.go.id" target="_blank" rel="noopener">jarsiplus.samarindakota.go.id</a>. Seluruh pengajuan, pelacakan, dan evaluasi dapat dilakukan secara online melalui peramban web modern.'
        ],
        [
            'question' => 'Bagaimana alur pengajuan permohonan inovasi baru?',
            'answer' => '1. Masuk/Login menggunakan akun Single Sign-On (SSO) Samarinda.<br>2. Pilih menu <strong>Pengajuan Inovasi Baru</strong>.<br>3. Isi formulir Segment 1 (Data Umum), Segment 2 (Data Petugas), dan Segment 3 (Deskripsi Inovasi).<br>4. Unggah berkas indikator bukti dukung yang dipersyaratkan.<br>5. Kirim permohonan untuk dilakukan pembahasan oleh Tim Verifikator.'
        ],
        [
            'question' => 'Siapa saja yang dapat mengajukan permohonan inovasi?',
            'answer' => 'Pengajuan terbuka bagi ASN Pemkot Samarinda, Perangkat Daerah, UPTD/Puskesmas/RSUD, BUMD, serta Kategori Umum (Dosen/Mahasiswa/Masyarakat Umum Kota Samarinda) sesuai dengan ketentuan Lomba Inovasi Baimbai 2026.'
        ],
        [
            'question' => 'Bagaimana cara melacak status permohonan yang telah dikirim?',
            'answer' => 'Anda dapat memasukkan <strong>Kode Permohonan</strong> (contoh: PERM-2026-0001) pada kolom pencarian di halaman Beranda atau melihat langsung melalui <strong>Portal Pemohon &rarr; Daftar Permohonan</strong>.'
        ]
    ];

    $hasDbFaqs = $faqs && $faqs->count() > 0;

    $items = $hasDbFaqs
        ? $faqs->map(function ($faq) {
            $q = $faq->pertanyaan ?? $faq->question ?? $faq->judul ?? 'Pertanyaan';
            $a = $faq->jawaban ?? $faq->answer ?? $faq->deskripsi ?? '';
            $a = str_replace(['Progressive Web Application (PWA)', 'Progressive Web Application', 'PWA'], 'Web Browser', $a);
            $a = str_replace('diinstal pada perangkat sebagai Progressive Web Application', 'diakses langsung melalui peramban web (browser)', $a);
            return ['question' => $q, 'answer' => $a];
        })->values()->all()
        : $defaultFaqs;
@endphp

<x-page-header
    badge="PUSAT BANTUAN"
    title="Pertanyaan Umum (FAQ)"
    desc="Jawaban seputar pengajuan inovasi, alur verifikasi, dan ketentuan teknis."
>
    <div class="jp-searchbar" style="min-width: 280px;">
        <label for="faqSearchInput" class="u-sr-only">Cari pertanyaan</label>
        <input type="search" id="faqSearchInput" class="jp-input" placeholder="Cari pertanyaan…" autocomplete="off">
    </div>
</x-page-header>

<div class="jp-section jp-section--sm">
    <div class="l-container">
        <div class="l-split-detail">

            {{-- Daftar pertanyaan --}}
            <div>
                @if(count($items) > 0)
                    <div class="jp-accordion" id="faq-list">
                        @foreach($items as $index => $faq)
                            <div class="jp-faq-item" data-search="{{ strtolower($faq['question'] . ' ' . strip_tags($faq['answer'])) }}">
                                <button type="button" class="jp-faq-trigger" aria-expanded="false">
                                    <span class="u-flex u-align-center u-gap-sm" style="min-width: 0;">
                                        <span class="jp-faq-num font-mono">{{ $index + 1 }}</span>
                                        <span>{{ $faq['question'] }}</span>
                                    </span>
                                    <x-icon name="chevron-down" size="18" class="jp-faq-icon" />
                                </button>
                                <div class="jp-faq-body">
                                    <div class="jp-accordion-body">
                                        {!! $faq['answer'] !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty
                        icon="info"
                        title="Belum ada pertanyaan"
                        desc="Daftar pertanyaan umum belum tersedia. Silakan hubungi Helpdesk untuk bantuan langsung."
                    />
                @endif

                <div id="faqSearchEmpty" style="display: none;" class="u-mt-md">
                    <x-empty
                        icon="search"
                        title="Pencarian tidak ditemukan"
                        desc="Tidak ada pertanyaan yang cocok dengan kata kunci Anda. Coba kata kunci lain atau hubungi Helpdesk."
                    />
                </div>
            </div>

            {{-- Sisi bantuan --}}
            <aside>
                <div class="jp-card jp-sticky">
                    <span class="jp-action-card__icon-box"><x-icon name="chat" size="22" /></span>
                    <h3 class="u-mb-xs">Butuh Bantuan Lain?</h3>
                    <p class="jp-card__text u-mb-md">
                        Jika Anda tidak menemukan jawaban yang dicari, silakan hubungi tim dukungan teknis
                        Bapperida Kota Samarinda.
                    </p>
                    <a href="https://wa.me/6281122334455" target="_blank" rel="noopener" class="jp-btn jp-btn--accent u-w-100">
                        Hubungi Helpdesk
                    </a>

                    <div class="jp-divider"></div>

                    <h4 class="jp-deflist__label u-block u-mb-xs">Tautan Cepat</h4>
                    <div class="u-flex u-flex-col u-gap-xs">
                        <a href="{{ url('/permohonan/create') }}" class="jp-btn jp-btn--ghost jp-btn--sm" style="justify-content: flex-start;">
                            <x-icon name="document" size="15" /> Ajukan Inovasi Baru
                        </a>
                        <a href="{{ url('/informasi') }}" class="jp-btn jp-btn--ghost jp-btn--sm" style="justify-content: flex-start;">
                            <x-icon name="info" size="15" /> Informasi &amp; Pengumuman
                        </a>
                        <a href="{{ url('/statistik') }}" class="jp-btn jp-btn--ghost jp-btn--sm" style="justify-content: flex-start;">
                            <x-icon name="chart" size="15" /> Statistik &amp; Data
                        </a>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>
@endsection

{{--
    Buka/tutup jawaban dan pencarian ditangani oleh jarsiplus.js
    (selector .jp-faq-trigger, #faqSearchInput, #faqSearchEmpty).
    Tidak ada skrip khusus halaman agar tidak ada dua listener yang saling
    menimpa properti display seperti sebelumnya.
--}}
