@props([
    'title' => '',
    'active' => false,
])

<div {{ $attributes->merge(['class' => 'jp-accordion-item ' . ($active ? 'is-active' : '')]) }}>
    <button type="button" class="jp-accordion-header" aria-expanded="{{ $active ? 'true' : 'false' }}">
        <span class="jp-accordion-title">{{ $title }}</span>
        <x-icon name="chevron-down" size="18" class="jp-accordion-icon" />
    </button>
    <div class="jp-accordion-content">
        <div class="jp-accordion-body">
            {{ $slot }}
        </div>
    </div>
</div>
