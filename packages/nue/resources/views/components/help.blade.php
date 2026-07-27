@props([
    'label' => null,
])

@php
    $attributes = $attributes->class([
        'form-text mt-1',
    ])->merge([
        //
    ]);
@endphp

@if($label || !$slot->isEmpty())
    <div {{ $attributes }}>
        {{ $label ?? $slot }}
    </div>
@endif