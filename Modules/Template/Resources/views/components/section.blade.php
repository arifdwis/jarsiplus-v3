@props(['eyebrow' => null, 'title' => null, 'desc' => null, 'align' => 'left', 'size' => 'md'])

@php
    $class = 'jp-section';
    if ($size === 'compact') $class .= ' jp-section--compact';
    if ($size === 'wide') $class .= ' jp-section--wide';
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="l-container">
        @if($eyebrow || $title || $desc)
            <div class="jp-section__head @if($align === 'center') u-text-center @endif @if($align === 'right') u-text-right @endif">
                @if($eyebrow)
                    <p class="jp-section__eyebrow">
                        <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                        {{ $eyebrow }}
                    </p>
                @endif
                @if($title)
                    <h2 class="jp-section__title">{{ $title }}</h2>
                @endif
                @if($desc)
                    <p class="jp-section__desc">{{ $desc }}</p>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</div>