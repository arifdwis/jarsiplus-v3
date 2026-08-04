@props([
    'type' => 'text', // text | card | avatar
    'height' => '20px',
    'width' => '100%',
])

<div {{ $attributes->merge(['class' => 'jp-skeleton jp-skeleton--' . $type]) }} style="height: {{ $height }}; width: {{ $width }};"></div>
