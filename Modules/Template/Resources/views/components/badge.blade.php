@props(['variant' => 'default', 'icon' => null])

@php
    $variantClasses = [
        'default' => 'jp-badge--default',
        'success' => 'jp-badge--success',
        'warning' => 'jp-badge--warning',
        'danger' => 'jp-badge--danger',
        'accent' => 'jp-badge--accent',
    ];
    $class = 'jp-badge ' . ($variantClasses[$variant] ?? '');
@endphp

<span class="{{ $class }}" {{ $attributes }}>
    @if($icon)
        <x-icon :name="$icon" size="12" />
    @endif
    {{ $slot }}
</span>