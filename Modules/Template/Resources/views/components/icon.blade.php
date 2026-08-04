@props([
    'name' => 'info',
    'size' => 20,
])

{{--
    Ikon SVG inline (stroke-based, 24×24).

    Sebelumnya komponen ini memuat ikon dari CDN Iconify per nama; setiap nama
    yang tidak persis cocok dengan katalog Solar akan render kosong — itulah
    sebab beberapa ikon hilang. Set lokal di bawah menjamin semua ikon tampil,
    tetap konsisten, dan tidak bergantung koneksi.
--}}
@php
    $paths = [
        'document'      => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/>',
        'file'          => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/>',
        'folder'        => '<path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
        'clipboard'     => '<path d="M9 4h6v3H9z"/><path d="M15 5h2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2"/><path d="M9 13l2 2 4-4"/>',
        'user'          => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6 8-6s8 2 8 6"/>',
        'building'      => '<path d="M4 21V6a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v15"/><path d="M15 10h3a2 2 0 0 1 2 2v9"/><path d="M8 8h3M8 12h3M8 16h3M3 21h18"/>',
        'info'          => '<circle cx="12" cy="12" r="9"/><path d="M12 11v5"/><circle cx="12" cy="7.8" r=".9" fill="currentColor" stroke="none"/>',
        'info-circle'   => '<circle cx="12" cy="12" r="9"/><path d="M12 11v5"/><circle cx="12" cy="7.8" r=".9" fill="currentColor" stroke="none"/>',
        'check'         => '<path d="M4 12.5 9 17.5 20 6.5"/>',
        'check-circle'  => '<circle cx="12" cy="12" r="9"/><path d="M8 12.2l2.8 2.8L16 9.8"/>',
        'alert-circle'  => '<circle cx="12" cy="12" r="9"/><path d="M12 7.5v5.5"/><circle cx="12" cy="16.3" r=".9" fill="currentColor" stroke="none"/>',
        'alert-triangle'=> '<path d="M10.3 3.9 2.6 17.1A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.9L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><circle cx="12" cy="16.4" r=".9" fill="currentColor" stroke="none"/>',
        'close'         => '<path d="M6 6l12 12M18 6L6 18"/>',
        'menu'          => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'search'        => '<circle cx="11" cy="11" r="6.5"/><path d="M16 16l4.5 4.5"/>',
        'filter'        => '<path d="M4 5h16l-6.2 7.3V19l-3.6-2v-4.7z"/>',
        'lock'          => '<rect x="4.5" y="10" width="15" height="10" rx="2"/><path d="M8.5 10V7.5a3.5 3.5 0 0 1 7 0V10"/>',
        'shield'        => '<path d="M12 3.2 5 6v6c0 4.3 2.9 7.6 7 8.8 4.1-1.2 7-4.5 7-8.8V6z"/><path d="M9.2 12.2l2 2 3.6-3.8"/>',
        'star'          => '<path d="m12 3.6 2.6 5.3 5.9.9-4.3 4.1 1 5.8-5.2-2.7-5.2 2.7 1-5.8L3.5 9.8l5.9-.9z"/>',
        'clock'         => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5.3l3.4 2"/>',
        'calendar'      => '<rect x="3.5" y="5" width="17" height="15.5" rx="2"/><path d="M3.5 9.8h17M8.5 3.2v3.6M15.5 3.2v3.6"/>',
        'chat'          => '<path d="M20.5 12c0 4-3.8 7.2-8.5 7.2-1 0-2-.15-2.9-.42L4 20.5l1.5-3.6C4.2 15.6 3.5 13.9 3.5 12c0-4 3.8-7.2 8.5-7.2s8.5 3.2 8.5 7.2z"/><path d="M9 12h.01M12 12h.01M15 12h.01"/>',
        'eye'           => '<path d="M2.5 12S6 5.8 12 5.8 21.5 12 21.5 12 18 18.2 12 18.2 2.5 12 2.5 12z"/><circle cx="12" cy="12" r="3"/>',
        'upload'        => '<path d="M12 16V4"/><path d="m7.5 8.5 4.5-4.5 4.5 4.5"/><path d="M4 15v3.5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V15"/>',
        'download'      => '<path d="M12 4v12"/><path d="m7.5 11.5 4.5 4.5 4.5-4.5"/><path d="M4 15v3.5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V15"/>',
        'chart'         => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
        'inbox'         => '<path d="M3.5 13.5 6 5.6A2 2 0 0 1 7.9 4.2h8.2A2 2 0 0 1 18 5.6l2.5 7.9"/><path d="M3.5 13.5H8l1.4 2.8h5.2l1.4-2.8h4.5v4.3a2 2 0 0 1-2 2H5.5a2 2 0 0 1-2-2z"/>',
        'link'          => '<path d="M10.5 13.5a4 4 0 0 0 5.7 0l2.6-2.6a4 4 0 1 0-5.7-5.7l-1.4 1.4"/><path d="M13.5 10.5a4 4 0 0 0-5.7 0l-2.6 2.6a4 4 0 1 0 5.7 5.7l1.4-1.4"/>',
        'trash'         => '<path d="M4.5 6.5h15M9.5 6.5V4.8a1.3 1.3 0 0 1 1.3-1.3h2.4a1.3 1.3 0 0 1 1.3 1.3v1.7"/><path d="M6.5 6.5 7.4 19a2 2 0 0 0 2 1.9h5.2a2 2 0 0 0 2-1.9l.9-12.5"/><path d="M10.5 10.5v6M13.5 10.5v6"/>',
        'edit'          => '<path d="M4 20h4L19 9a2.1 2.1 0 0 0-3-3L5 17z"/><path d="M14.5 6.5 17.5 9.5"/>',
        'chevron-down'  => '<path d="m6 9.5 6 6 6-6"/>',
        'chevron-up'    => '<path d="m6 14.5 6-6 6 6"/>',
        'chevron-right' => '<path d="m9.5 6 6 6-6 6"/>',
        'chevron-left'  => '<path d="m14.5 6-6 6 6 6"/>',
        'arrow-right'   => '<path d="M4 12h15"/><path d="m13 6 6 6-6 6"/>',
        'arrow-left'    => '<path d="M20 12H5"/><path d="m11 6-6 6 6 6"/>',
        'trending-up'   => '<path d="m3 16 5.5-5.5 3.5 3.5L21 5"/><path d="M15 5h6v6"/>',
        'trending-down' => '<path d="m3 8 5.5 5.5 3.5-3.5L21 19"/><path d="M15 19h6v-6"/>',
    ];

    $path = $paths[$name] ?? $paths['info'];
@endphp

<svg
    xmlns="http://www.w3.org/2000/svg"
    width="{{ $size }}"
    height="{{ $size }}"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.6"
    stroke-linecap="round"
    stroke-linejoin="round"
    aria-hidden="true"
    focusable="false"
    {{ $attributes->merge(['class' => 'jp-icon']) }}
>{!! $path !!}</svg>
