@props([
    'variant' => 'default', // default | featured | media
])

<div {{ $attributes->merge(['class' => 'jp-card jp-card--' . $variant]) }}>
    {{ $slot }}
</div>
