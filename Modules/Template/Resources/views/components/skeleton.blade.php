@props(['count' => 1, 'type' => 'text'])

@for($i = 0; $i < $count; $i++)
    <div class="jp-skeleton @if($type === 'avatar') jp-skeleton--avatar @elseif($type === 'image') jp-skeleton--image @elseif($type === 'button') jp-skeleton--button @endif" {{ $attributes }}></div>
@endfor