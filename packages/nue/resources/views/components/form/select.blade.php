@props([
    'label' => null,
    'placeholder' => null,
    'options' => [],
    'icon' => null,
    'prepend' => null,
    'append' => null,
    'size' => null,
    'help' => null,
    'model' => null,
    'lazy' => false,
])

@php
    if ($lazy) $bind = 'lazy';
    else $bind = 'defer';
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
    $key = $attributes->get('name', $model ?? $wireModel);
    $id = $attributes->get('id', $model ?? $wireModel);
    $options = Arr::isAssoc($options) ? $options : array_combine($options, $options);
    $attributes = $attributes->class([
        'form-select',
        'form-select-' . $size => $size,
        'rounded-end' => !$append,
        'is-invalid' => $errors->has($key),
    ])->merge([
        'id' => $id,
        'wire:model.' . $bind => $model ? $model : null,
    ]);
@endphp

<div>
    <x-nue::label :for="$id" :label="$label"/>

    <div class="input-group">
        <x-nue::input-addon :icon="$icon" :label="$prepend"/>

        <select {{ $attributes }}>
            <option value="">{{ $placeholder }}</option>

            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
            @endforeach
        </select>

        <x-nue::input-addon :label="$append" class="rounded-end"/>

        <x-nue::error :key="$key"/>
    </div>

    <x-nue::help :label="$help"/>
</div>