@props([
    'name' => '',
    'label' => null,
    'type' => 'text',
    'value' => '',
    'helper' => null,
    'error' => null,
    'required' => false,
])

<div class="jp-field {{ $error ? 'has-error' : '' }}">
    @if($label)
        <label for="{{ $name }}" class="jp-field__label">
            {{ $label }}
            @if($required) <span class="jp-field__required">*</span> @endif
        </label>
    @endif

    @if($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'jp-input jp-input--textarea']) }} {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'jp-input jp-input--select']) }} {{ $required ? 'required' : '' }}>
            {{ $slot }}
        </select>
    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}" {{ $attributes->merge(['class' => 'jp-input']) }} {{ $required ? 'required' : '' }}>
    @endif

    @if($error)
        <p class="jp-field__error">{{ $error }}</p>
    @elseif($helper)
        <p class="jp-field__helper">{{ $helper }}</p>
    @endif
</div>
