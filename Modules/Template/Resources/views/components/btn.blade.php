@props(['variant' => 'accent', 'size' => 'md', 'type' => 'button'])

@php
    $class = 'jp-btn jp-btn--' . $variant;
    if ($size === 'xs') $class .= ' jp-btn--xs';
    if ($size === 'sm') $class .= ' jp-btn--sm';
    if ($size === 'lg') $class .= ' jp-btn--lg';
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif