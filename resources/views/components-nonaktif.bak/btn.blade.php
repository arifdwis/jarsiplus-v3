@props([
    'variant' => 'primary', // primary | secondary | quiet | accent
    'size' => 'md', // sm | md | lg
    'type' => 'button',
    'href' => null,
    'icon' => null,
])

@php
    $classes = 'jp-btn jp-btn--' . $variant . ' jp-btn--' . $size;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-icon :name="$icon" size="16" />
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <x-icon :name="$icon" size="16" />
        @endif
        {{ $slot }}
    </button>
@endif
