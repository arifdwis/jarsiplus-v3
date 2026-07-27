@props([
    'type' => 'text',
    'icon' => null,
    'prepend' => null,
    'append' => null,
    'size' => null,
    'help' => null,
    'placeholder' => null, 
    'model' => null,
    'debounce' => false,
    'lazy' => false,
])

@php
    if ($type == 'number') $inputmode = 'decimal';
    else if (in_array($type, ['tel', 'search', 'email', 'url'])) $inputmode = $type;
    else $inputmode = 'text';
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
        'type' => $type,
        'inputmode' => $inputmode,
        'id' => $id,
        'wire:model.' . $bind => $model ? $model : null,
        'placeholder' => $placeholder
    ]);
@endphp

<div>
    <div class="input-group mb-0">
        <x-nue::input-addon :icon="$icon" :label="$prepend"/>

        <input {{ $attributes }}>

        <x-nue::input-addon :label="$append" class="rounded-end"/>

        <x-nue::error :key="$key"/>
    </div>
    <x-nue::help :label="$help"/>
</div>