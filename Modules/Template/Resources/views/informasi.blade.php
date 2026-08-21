@extends('template::layouts.master')

@section('title', 'Informasi & Pengumuman — JARSIPLUS Kota Samarinda')

@section('content')
@php
    $sliders = $sliders ?? (class_exists('Modules\Core\Entities\Slider') ? Modules\Core\Entities\Slider::latest()->take(5)->get() : collect([]));
    $lamans = $lamans ?? (class_exists('Modules\Core\Entities\Laman') ? Modules\Core\Entities\Laman::latest()->paginate(9) : collect([]));

    $sedangMencari = request()->filled('search');
@endphp

<x-page-header
    badge="INFORMASI RESMI"
    title="Informasi & Pengumuman"
    desc="Informasi terbaru, edaran resmi, dan panduan teknis Kota Samarinda."
>
    <form action="{{ url('/informasi') }}" method="GET" class="jp-searchbar" style="min-width: 280px;">
        <label for="cariInformasi" class="u-sr-only">Cari informasi</label>
        <input type="text" id="cariInformasi" name="search" class="jp-input" placeholder="Cari kata kunci…" value="{{ request('search') }}">
        <button type="submit" class="jp-btn jp-btn--accent">Cari</button>
    </form>
</x-page-header>

@if($sedangMencari)
    <div class="jp-subhead">
        <div class="l-container jp-subhead__inner">
            <span class="jp-subhead__meta">
                Hasil pencarian untuk “<strong>{{ request('search') }}</strong>”
            </span>
            <a href="{{ url('/informasi') }}" class="jp-link-arrow" style="font-size: var(--t-xs);">Hapus pencarian</a>
        </div>
    </div>
@endif

<div class="jp-section jp-section--sm">
    <div class="l-container">
        @if($lamans && $lamans->count() > 0)
            <div class="l-grid l-grid--3">
                {{-- Tabel `laman` hanya punya kolom: label, slug, content, status.
                     Sebelumnya view ini membaca title/deskripsi/body/image yang
                     tidak ada, sehingga judul & ringkasan kartu selalu kosong.

                     Belum ada rute detail informasi (hanya /informasi), jadi isi
                     lengkapnya dibuka lewat modal alih-alih menaut ke URL yang
                     berujung 404. --}}
                @foreach($lamans as $laman)
                    @php
                        $judul   = jp_isi($laman->label) ?? 'Tanpa judul';
                        $isiHtml = trim((string) $laman->content);
                        $isi     = html_entity_decode(trim(strip_tags($isiHtml)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        $ringkas = jp_isi($isi);
                        $idModal = 'modalLaman-' . ($laman->uuid ?? $laman->id);
                    @endphp

                    <button type="button" class="jp-media-card" onclick="document.getElementById('{{ $idModal }}').showModal()">
                        <div class="jp-media-card__media">
                            <span class="jp-media-card__placeholder">
                                <x-icon name="document" size="36" />
                            </span>
                        </div>

                        <div class="jp-media-card__body">
                            <span class="font-mono" style="font-size: var(--t-2xs); color: var(--c-ink-subtle);">
                                {{ $laman->created_at ? $laman->created_at->format('d M Y') : '—' }}
                            </span>

                            <h3 class="jp-record-card__title jp-clamp-2">{{ $judul }}</h3>

                            <p class="jp-card__text jp-clamp-3">
                                {{ $ringkas ? Str::limit($ringkas, 120) : 'Ringkasan belum tersedia.' }}
                            </p>

                            <div class="jp-media-card__foot">
                                <span class="jp-link-arrow" style="font-size: var(--t-xs);">
                                    Baca Selengkapnya <span aria-hidden="true">&rarr;</span>
                                </span>
                            </div>
                        </div>
                    </button>

                    <dialog id="{{ $idModal }}" class="jp-modal jp-modal--lg">
                        <div class="jp-modal__head">
                            <div style="min-width: 0;">
                                <span class="jp-modal__eyebrow font-mono">
                                    {{ $laman->created_at ? $laman->created_at->format('d M Y') : '—' }}
                                </span>
                                <h3 class="jp-modal__title">{{ $judul }}</h3>
                            </div>
                            <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="this.closest('dialog').close()">
                                <x-icon name="close" size="22" />
                            </button>
                        </div>

                        <div class="jp-modal__body">
                            @if($ringkas)
                                <div class="jp-prose">{!! $isiHtml !!}</div>
                            @else
                                <p class="jp-prose jp-prose--empty">Isi informasi belum tersedia.</p>
                            @endif
                        </div>

                        <div class="jp-modal__foot">
                            <button type="button" class="jp-btn jp-btn--ghost" onclick="this.closest('dialog').close()">Tutup</button>
                        </div>
                    </dialog>
                @endforeach
            </div>

            @if(method_exists($lamans, 'hasPages') && $lamans->hasPages())
                <div class="u-flex u-justify-center u-mt-xl">
                    {{ $lamans->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        @elseif($sedangMencari)
            <x-empty
                icon="search"
                title="Informasi tidak ditemukan"
                desc="Tidak ada informasi yang cocok dengan kata kunci Anda. Coba kata kunci lain."
                :action="url('/informasi')"
                actionLabel="Tampilkan Semua Informasi"
            />
        @else
            <x-empty
                icon="info"
                title="Belum ada informasi"
                desc="Saat ini belum ada informasi resmi yang dipublikasikan. Silakan periksa kembali secara berkala."
            />
        @endif
    </div>
</div>
@endsection
