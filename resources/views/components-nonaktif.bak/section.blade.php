@props([
    'variant' => 'light', // light | soft | strong
    'eyebrow' => null,
    'title' => null,
    'lead' => null,
])

<section {{ $attributes->merge(['class' => 'jp-section jp-section--' . $variant]) }}>
    <div class="l-container">
        @if($eyebrow || $title || $lead)
            <div class="jp-section__header u-text-center u-mb-xl">
                @if($eyebrow)
                    <span class="jp-eyebrow">{!! $eyebrow !!}</span>
                @endif
                @if($title)
                    <h2 class="jp-section__title">{!! $title !!}</h2>
                @endif
                @if($lead)
                    <p class="jp-section__lead">{!! $lead !!}</p>
                @endif
            </div>
        @endif
        {{ $slot }}
    </div>
</section>
