@props([
    'label' => null,
    'checkLabel' => null,
    'help' => null,
    'switch' => false,
    'model' => null,
    'lazy' => false,
])

@php
    if ($lazy) $bind = 'lazy';
    else $bind = 'defer';
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
    $key = $attributes->get('name', $model ?? $wireModel);
    $id = $attributes->get('id', $model ?? $wireModel);
    $attributes = $attributes->class([
        'form-check-input',
        'is-invalid' => $errors->has($key),
    ])->merge([
        'type' => 'checkbox',
        'id' => $id,
        'wire:model.' . $bind => $model ? $model : null,
    ]);
@endphp

<div>
    <x-nue::label :label="$label"/>

    <div class="form-check {{ $switch ? 'form-switch' : '' }}">
        <input {{ $attributes }}>

        <x-nue::check-label :for="$id" :label="$checkLabel"/>

        <x-nue::error :key="$key"/>

        <x-nue::help :label="$help"/>
    </div>
</div>