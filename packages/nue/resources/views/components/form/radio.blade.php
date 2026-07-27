@props([
    'label' => null,
    'options' => [],
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
    $options = Arr::isAssoc($options) ? $options : array_combine($options, $options);
    $attributes = $attributes->class([
        'form-check-input',
        'is-invalid' => $errors->has($key),
    ])->merge([
        'type' => 'radio',
        'name' => $key,
        'wire:model.' . $bind => $model ? $model : null,
    ]);
@endphp

<div>
    <x-nue::label :label="$label"/>

    @foreach($options as $optionValue => $optionLabel)
        <div class="form-check {{ $switch ? 'form-switch' : '' }}">
            @php($optionId = $id . '_' . $loop->index)

            <input {{ $attributes->merge(['id' => $optionId, 'value' => $optionValue]) }}>

            <x-nue::check-label :for="$optionId" :label="$optionLabel"/>

            @if($loop->last)
                <x-nue::error :key="$key"/>

                <x-nue::help :label="$help"/>
            @endif
        </div>
    @endforeach
</div>