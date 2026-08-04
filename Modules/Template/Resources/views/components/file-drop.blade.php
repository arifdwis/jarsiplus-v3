@props(['name' => 'file', 'label' => null, 'accept' => '', 'multiple' => false, 'required' => false, 'maxSize' => '5MB'])

<div class="jp-field" {{ $attributes->only(['style']) }}>
    @if($label)
        <label class="jp-label">
            {{ $label }}
            @if($required)<span class="jp-label__required">*</span>@endif
        </label>
    @endif

    <div class="jp-file-drop" id="drop-{{ md5($name) }}">
        <input type="file" name="{{ $name }}" id="input-{{ md5($name) }}" class="jp-file-drop__input" accept="{{ $accept }}" @if($multiple) multiple @endif @if($required) required @endif>
        <label for="input-{{ md5($name) }}" class="jp-file-drop__label">
            <x-icon name="upload" size="32" style="color: var(--c-ink-subtle); margin-bottom: 8px;" />
            <span class="jp-file-drop__text">Seret &amp; lepas berkas di sini, atau <strong style="color: var(--c-accent)">klik untuk memilih</strong></span>
            <span class="jp-file-drop__hint">Maks. {{ $maxSize }}@if($accept) &middot; {{ strtoupper(str_replace(['.', ' '], ['', '/'], $accept)) }}@endif</span>
        </label>
    </div>
</div>
