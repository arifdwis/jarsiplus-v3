@props(['items' => [], 'alternate' => false])

<div class="jp-timeline @if($alternate) jp-timeline--alternate @endif" {{ $attributes }}>
    @foreach($items as $index => $item)
        <div class="jp-timeline__item">
            <div class="jp-timeline__marker">
                @if($item['icon'] ?? null)
                    <x-icon :name="$item['icon']" size="16" />
                @else
                    <span></span>
                @endif
            </div>
            <div class="jp-timeline__content">
                @if($item['time'] ?? null)
                    <time class="jp-timeline__time">{{ $item['time'] }}</time>
                @endif
                @if($item['title'] ?? null)
                    <h4 class="jp-timeline__title">{{ $item['title'] }}</h4>
                @endif
                @if($item['desc'] ?? null)
                    <p class="jp-timeline__desc">{{ $item['desc'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>