@props([
    'name' => null,
    'size' => null,
    'color' => null,
])

@php
    $attributes = $attributes->class([
        'iconify', 
        'i-' . $size => $size,
        'text-' . $color => $color,
    ])->merge([
        // 
    ]);
@endphp

@if($name)
    <span {{ $attributes }}>
        <span class="iconify" data-icon="{{ $name }}"></span>
    </span>
@endif