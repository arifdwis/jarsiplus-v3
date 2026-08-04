@props([
    'value' => '0',
    'label' => '',
    'caption' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'jp-stat-tile']) }}>
    <div class="jp-stat-tile__header">
        @if($icon)
            <div class="jp-stat-tile__icon">
                <x-icon :name="$icon" size="24" />
            </div>
        @endif
        <div class="jp-stat-tile__value" data-count="{{ is_numeric($value) ? $value : '' }}">{{ is_numeric($value) ? number_format($value, 0, ',', '.') : $value }}</div>
    </div>
    <div class="jp-stat-tile__label">{{ $label }}</div>
    @if($caption)
        <div class="jp-stat-tile__caption">{{ $caption }}</div>
    @endif
</div>
