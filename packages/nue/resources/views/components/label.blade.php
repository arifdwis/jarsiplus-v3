@props([
    'label' => null,
    'for' => null
])

@php
    $attributes = $attributes->class([
        'form-label',
    ])->merge([
        //
    ]);
@endphp

@if($label || !$slot->isEmpty())
    <label {{ $attributes }} for="{{ $for }}">
        {{ $label ?? $slot }}
    </label>
@endif