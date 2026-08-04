@props(['type' => 'info', 'title' => '', 'message' => '', 'duration' => 5000])

@php
    $typeClasses = [
        'success' => 'jp-toast--success',
        'error' => 'jp-toast--error',
        'warning' => 'jp-toast--warning',
        'info' => 'jp-toast--info',
    ];
    $icons = [
        'success' => 'check-circle',
        'error' => 'alert-circle',
        'warning' => 'alert-triangle',
        'info' => 'info-circle',
    ];
    $typeClass = $typeClasses[$type] ?? '';
    $icon = $icons[$type] ?? 'info-circle';
@endphp

<dialog id="toast-{{ md5($title . $message . now()) }}" class="jp-toast {{ $typeClass }}" {{ $attributes }}>
    <div class="jp-toast__icon">
        <x-icon :name="$icon" size="20" />
    </div>
    <div class="jp-toast__content">
        @if($title)
            <strong class="jp-toast__title">{{ $title }}</strong>
        @endif
        @if($message)
            <p class="jp-toast__message">{{ $message }}</p>
        @endif
    </div>
    <button type="button" class="jp-toast__close" aria-label="Tutup">
        <x-icon name="close" size="16" />
    </button>
</dialog>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.querySelector('[id^="toast-"]');
    if (toast) {
        toast.showModal();
        setTimeout(() => toast.close(), {{ $duration }});
        toast.querySelector('.jp-toast__close')?.addEventListener('click', () => toast.close());
    }
});
</script>
@endpush