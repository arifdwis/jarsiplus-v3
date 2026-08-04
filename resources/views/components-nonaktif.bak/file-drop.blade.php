@props([
    'name' => 'file',
    'accept' => '.pdf,.doc,.docx,.png,.jpg',
    'maxSize' => '10MB',
    'label' => 'Pilih atau seret berkas ke sini',
])

<div {{ $attributes->merge(['class' => 'jp-file-drop']) }}>
    <input type="file" id="{{ $name }}" name="{{ $name }}" accept="{{ $accept }}" class="jp-file-drop__input">
    <label for="{{ $name }}" class="jp-file-drop__label">
        <div class="jp-file-drop__icon u-mb-xs">
            <x-icon name="document" size="32" />
        </div>
        <span class="jp-file-drop__title">{{ $label }}</span>
        <span class="jp-file-drop__hint">Format: {{ $accept }} (Maks. {{ $maxSize }})</span>
    </label>
</div>
