@props(['items' => [], 'id' => 'carousel'])

<div class="jp-carousel" id="{{ $id }}" {{ $attributes }}>
    <div class="jp-carousel__track">
        @foreach($items as $index => $item)
            <div class="jp-carousel__slide @if($index === 0) is-active @endif">
                @if($item['image'] ?? null)
                    <img src="{{ $item['image'] }}" alt="{{ $item['alt'] ?? ($item['title'] ?? '') }}" class="jp-carousel__img" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" onerror="this.onerror=null; this.src='{{ asset('img/default-slider.png') }}';">
                @endif
                @if($item['title'] ?? null)
                    <div class="jp-carousel__overlay">
                        @if($item['badge'] ?? null)
                            <span class="jp-badge jp-badge--dark u-mb-xs">{{ $item['badge'] }}</span>
                        @endif
                        <h3>{{ $item['title'] }}</h3>
                        @if($item['desc'] ?? null)
                            <p>{{ $item['desc'] }}</p>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    @if(count($items) > 1)
        <button type="button" class="jp-carousel__prev" aria-label="Slide sebelumnya">
            <x-icon name="chevron-left" size="20" />
        </button>
        <button type="button" class="jp-carousel__next" aria-label="Slide selanjutnya">
            <x-icon name="chevron-right" size="20" />
        </button>
        <div class="jp-carousel__dots">
            @foreach($items as $index => $item)
                <button type="button" class="jp-carousel__dot @if($index === 0) is-active @endif" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
    @endif
</div>
