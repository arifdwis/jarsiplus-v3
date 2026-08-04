@extends('template::layouts.master',['footer'=>false])

@section('content')
<x-page-header
    badge="BERKAS PERMOHONAN"
    title="Data Dukung Permohonan"
    desc="Daftar berkas pendukung yang dilampirkan pada permohonan ini."
/>

<div class="jp-subhead">
    <div class="l-container jp-subhead__inner">
        <span class="jp-badge jp-badge--neutral font-mono">KODE: {{ $parent->kode }}</span>
    </div>
</div>

<div class="jp-section jp-section--sm">
    <div class="l-container">

        @if(role_me() == 4 && $parent->status == 1)
            <div class="jp-notice jp-notice--accent u-mb-lg">
                <span class="jp-notice__icon"><x-icon name="upload" size="20" /></span>
                <div class="jp-notice__body">
                    <strong class="jp-notice__title">Tambahkan berkas dukung</strong>
                    <p class="jp-notice__text">Unggah dokumen pendukung tambahan untuk melengkapi permohonan Anda.</p>
                </div>
                <div class="jp-notice__action">
                    <a href="{{ route('permohonan.berkas.create', $parent->uuid) }}" class="jp-btn jp-btn--accent">
                        <x-icon name="upload" size="16" />
                        Upload Berkas
                    </a>
                </div>
            </div>
        @endif

        @if($parent->permohonan && count($parent->permohonan) > 0)
            <div class="l-grid l-grid--3">
                @foreach($parent->permohonan as $value)
                    <a href="{{ route('permohonan.berkas.pembahasan.index',[$parent->uuid,$value->uuid]) }}" class="jp-record-card jp-record-card--accent" style="text-decoration: none; color: inherit;">
                        <header class="jp-record-card__head">
                            <span class="jp-record-card__code">{{ $parent->kode }}</span>
                            <span class="jp-badge jp-badge--neutral">Berkas</span>
                        </header>

                        <div class="jp-record-card__body">
                            <h3 class="jp-record-card__title jp-clamp-2 text-capitalize">
                                @if(filled($value->label)){{ $value->label }}@else<span class="jp-value-empty"></span>@endif
                            </h3>
                        </div>

                        <footer class="jp-record-card__foot u-justify-end">
                            <span class="jp-link-arrow" style="font-size: var(--t-xs);">
                                Buka Pembahasan <span aria-hidden="true">&rarr;</span>
                            </span>
                        </footer>
                    </a>
                @endforeach
            </div>
        @else
            <x-empty
                icon="folder"
                title="Belum ada berkas dukung"
                desc="Permohonan ini belum memiliki berkas data dukung yang dilampirkan."
            >
                @if(role_me() == 4 && $parent->status == 1)
                    <a href="{{ route('permohonan.berkas.create', $parent->uuid) }}" class="jp-btn jp-btn--accent u-mt-sm">
                        <x-icon name="upload" size="16" />
                        Upload Berkas Pertama
                    </a>
                @endif
            </x-empty>
        @endif

    </div>
</div>
@endsection
