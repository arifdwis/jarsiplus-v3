<div {{ $attributes->merge(['class' => 'jp-carousel']) }}>
    <div class="jp-carousel-viewport">
        <div class="jp-carousel-track">
            {{ $slot }}
        </div>
    </div>
    <div class="jp-carousel-controls">
        <button type="button" class="jp-carousel-prev" aria-label="Slide sebelumnya">
            <x-icon name="chevron-down" size="18" style="transform: rotate(90deg);" />
        </button>
        <button type="button" class="jp-carousel-next" aria-label="Slide berikutnya">
            <x-icon name="chevron-down" size="18" style="transform: rotate(-90deg);" />
        </button>
    </div>
</div>
