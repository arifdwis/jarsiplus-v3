@props([
    'title' => '',
    'desc' => null,
    'badge' => null,
    'eyebrow' => null,
    'back' => null,
    'backLabel' => 'Kembali',
])

{{-- Header halaman yang seragam untuk seluruh portal (publik, pemohon, verifikator). --}}
<div {{ $attributes->merge(['class' => 'jp-page-head']) }}>
    <div class="l-container jp-page-head__inner">
        <div class="jp-page-head__main">
            @if($back)
                <a href="{{ $back }}" class="jp-page-head__back">
                    <x-icon name="arrow-left" size="14" />
                    {{ $backLabel }}
                </a>
            @endif

            @if($badge || $eyebrow)
                <div class="u-flex u-align-center u-gap-sm u-flex-wrap u-mb-xs">
                    @if($badge)
                        <span class="jp-badge jp-badge--accent">{{ $badge }}</span>
                    @endif
                    @if($eyebrow)
                        <span class="font-mono jp-page-head__eyebrow">{{ $eyebrow }}</span>
                    @endif
                </div>
            @endif

            <h1 class="jp-page-head__title">{{ $title }}</h1>

            @if($desc)
                <p class="jp-page-head__desc">{{ $desc }}</p>
            @endif
        </div>

        @if(trim($slot) !== '')
            <div class="jp-page-head__actions">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
