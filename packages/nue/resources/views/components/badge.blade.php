@props([
    'icon' => null,
    'label' => null,
    'color' => 'primary',
])

@php
    $attributes = $attributes->class([
        'badge bg-' . $color,
    ])->merge([
        //
    ]);
@endphp

<span {{ $attributes }}>
    <x-nue::icon :name="$icon"/>

    {{ $label ?? $slot }}
</span>