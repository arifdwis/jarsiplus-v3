@props([
    'status' => null, // 0 | 1 | 2 | 9
    'variant' => 'neutral',
])

@php
    $labels = [
        0 => 'Dalam Proses',
        1 => 'Disetujui',
        2 => 'Selesai',
        9 => 'Ditolak',
    ];
    $statusClass = $status !== null ? 'jp-badge--' . $status : 'jp-badge--' . $variant;
    $text = $status !== null ? ($labels[$status] ?? 'Status ' . $status) : $slot;
@endphp

<span {{ $attributes->merge(['class' => 'jp-badge ' . $statusClass]) }}>
    <span class="jp-badge__dot"></span>
    <span class="jp-badge__text">{{ $text }}</span>
</span>
