@props(['label' => '', 'value' => '', 'trend' => null, 'trendLabel' => '', 'accent' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'jp-stat-tile']) }} @if($accent) style="border-left: 3px solid {{ $accent }};" @endif>
    <div class="u-flex u-justify-between u-align-center u-gap-sm">
        <p class="jp-stat-tile__label">{{ $label }}</p>
        @if($icon)
            <x-icon :name="$icon" size="20" style="color: var(--c-ink-subtle);" />
        @endif
    </div>
    <h2 class="jp-stat-tile__value">{{ $value }}</h2>
    @if($trend !== null)
        <div class="jp-stat-tile__trend @if($trend > 0) positive @elseif($trend < 0) negative @endif">
            <x-icon :name="$trend > 0 ? 'trending-up' : 'trending-down'" size="14" />
            <span>{{ abs($trend) }}% {{ $trendLabel }}</span>
        </div>
    @endif
</div>
