@props([
    'label' => null,
    'icon' => null,
    'prepend' => null,
    'append' => null,
    'rows' => 3,
    'size' => null,
    'help' => null,
    'model' => null,
    'debounce' => false,
    'lazy' => false,
])

@php
    if ($debounce) $bind = 'debounce.' . (ctype_digit($debounce) ? $debounce : 150) . 'ms';
    else if ($lazy) $bind = 'lazy';
    else $bind = 'defer';
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
    $key = $attributes->get('name', $model ?? $wireModel);
    $id = $attributes->get('id', $model ?? $wireModel);
    $attributes = $attributes->class([
        'form-control',
        'form-control-' . $size => $size,
        'rounded-end' => !$append,
        'is-invalid' => $errors->has($key),
    ])->merge([
        'id' => $id,
        'rows' => $rows,
        'wire:model.' . $bind => $model ? $model : null,
    ]);
@endphp

<div>
    <x-nue::label :for="$id" :label="$label"/>

    <div class="input-group">
        <x-nue::input-addon :icon="$icon" :label="$prepend"/>

        <textarea {{ $attributes }}></textarea>

        <x-nue::input-addon :label="$append" class="rounded-end"/>

        <x-nue::error :key="$key"/>
    </div>

    <x-nue::help :label="$help"/>
</div>