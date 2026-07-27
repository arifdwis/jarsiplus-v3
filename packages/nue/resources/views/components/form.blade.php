@props([
    'submit' => null, 
    'files' => null, 
])

@php
    $attributes = $attributes->class([
        //
    ])->merge([
        'wire:submit.prevent' => $submit
    ]);
@endphp

<form {{ $attributes }}>
    @csrf
    {{ $slot }}
</form>