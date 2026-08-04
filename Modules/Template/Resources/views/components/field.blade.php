@props(['id' => null, 'name' => null, 'label' => null, 'type' => 'text', 'value' => null, 'placeholder' => '', 'required' => false, 'readonly' => false, 'options' => [], 'hint' => null, 'error' => null])

@php
    $fieldId = $id ?? $name;
@endphp

<div class="jp-field @if($error) has-error @endif" {{ $attributes->only(['style']) }}>
    @if($label)
        <label class="jp-label" for="{{ $fieldId }}">
            {{ $label }}
            @if($required)<span class="jp-label__required">*</span>@endif
        </label>
    @endif

    @if($type === 'select')
        <select name="{{ $name }}" id="{{ $fieldId }}" class="jp-select" @if($required) required @endif @if($readonly) readonly @endif>
            <option value="">Pilih {{ $label }}</option>
            @foreach($options as $key => $option)
                <option value="{{ $key }}" @if($value == $key) selected @endif>{{ $option }}</option>
            @endforeach
        </select>
    @elseif($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $fieldId }}" class="jp-textarea" rows="4" placeholder="{{ $placeholder }}" @if($required) required @endif @if($readonly) readonly @endif>{{ $value }}</textarea>
    @elseif($type === 'date')
        <input type="date" name="{{ $name }}" id="{{ $fieldId }}" class="jp-input" value="{{ $value }}" @if($required) required @endif @if($readonly) readonly @endif>
    @elseif($type === 'number')
        <input type="number" name="{{ $name }}" id="{{ $fieldId }}" class="jp-input" value="{{ $value }}" placeholder="{{ $placeholder }}" @if($required) required @endif @if($readonly) readonly @endif>
    @elseif($type === 'email')
        <input type="email" name="{{ $name }}" id="{{ $fieldId }}" class="jp-input" value="{{ $value }}" placeholder="{{ $placeholder }}" @if($required) required @endif @if($readonly) readonly @endif>
    @elseif($type === 'password')
        <input type="password" name="{{ $name }}" id="{{ $fieldId }}" class="jp-input" value="{{ $value }}" placeholder="{{ $placeholder }}" @if($required) required @endif @if($readonly) readonly @endif>
    @else
        <input type="text" name="{{ $name }}" id="{{ $fieldId }}" class="jp-input" value="{{ $value }}" placeholder="{{ $placeholder }}" @if($required) required @endif @if($readonly) readonly @endif>
    @endif

    @if($hint)
        <p class="jp-field__hint">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="jp-field__error">{{ $error }}</p>
    @endif
</div>