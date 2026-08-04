@props([
    'name' => 'info',
    'size' => 20,
])

<svg width="{{ $size }}" height="{{ $size }}" {{ $attributes->merge(['class' => 'jp-icon']) }}>
    <use href="{{ asset('img/icons/sprite.svg#icon-' . $name) }}"></use>
</svg>
