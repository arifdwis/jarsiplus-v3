@props([
    'title' => 'Belum ada data',
    'message' => 'Data untuk kategori ini belum tersedia saat ini.',
    'icon' => 'document',
])

<div {{ $attributes->merge(['class' => 'jp-empty u-text-center u-p-xl']) }}>
    <div class="jp-empty__icon u-mb-md">
        <x-icon :name="$icon" size="48" />
    </div>
    <h3 class="jp-empty__title u-mb-xs">{{ $title }}</h3>
    <p class="jp-empty__message text-muted u-mb-lg">{{ $message }}</p>
    @if($slot->isNotEmpty())
        <div class="jp-empty__action">
            {{ $slot }}
        </div>
    @endif
</div>
