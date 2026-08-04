@props(['variant' => 'default'])

@php
    $class = 'jp-card';
    if ($variant === 'compact') $class .= ' jp-card--compact';
    if ($variant === 'highlight') $class .= ' jp-card--highlight';
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</div>