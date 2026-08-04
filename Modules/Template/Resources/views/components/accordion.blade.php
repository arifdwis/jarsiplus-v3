@props(['items' => []])

<div class="jp-accordion" {{ $attributes }}>
    @foreach($items as $index => $item)
        <div class="jp-accordion__item" @if($index === 0) data-open @endif>
            <button type="button" class="jp-accordion__trigger" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                <span>{{ $item['title'] ?? '' }}</span>
                <x-icon name="chevron-down" size="16" class="jp-accordion__icon" />
            </button>
            <div class="jp-accordion__content" role="region">
                <div class="jp-accordion__body">
                    {!! $item['content'] ?? '' !!}
                </div>
            </div>
        </div>
    @endforeach
</div>