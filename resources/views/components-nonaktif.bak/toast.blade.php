@props([
    'type' => 'info', // success | error | info
    'title' => null,
    'message' => '',
])

<div {{ $attributes->merge(['class' => 'jp-toast jp-toast--' . $type]) }} role="status" aria-live="polite">
    <div class="jp-toast-icon">
        <x-icon :name="$type === 'success' ? 'check' : ($type === 'error' ? 'close' : 'info')" size="20" />
    </div>
    <div class="jp-toast-body">
        @if($title)
            <strong class="jp-toast-title">{{ $title }}</strong>
        @endif
        <p class="jp-toast-message">{!! $message ?: $slot !!}</p>
    </div>
    <button type="button" class="jp-toast-dismiss" aria-label="Tutup notifikasi">
        <x-icon name="close" size="16" />
    </button>
</div>
