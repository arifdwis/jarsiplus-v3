@props([
    'title' => 'Belum ada data',
    'desc' => '',
    'icon' => 'inbox',
    'action' => null,
    'actionLabel' => null,
])

<div {{ $attributes->merge(['class' => 'jp-empty']) }}>
    <div class="jp-empty__icon">
        <x-icon :name="$icon" size="44" />
    </div>
    <h3 class="jp-empty__title">{{ $title }}</h3>
    @if($desc)
        <p class="jp-empty__desc">{{ $desc }}</p>
    @endif

    @if($action && $actionLabel)
        <a href="{{ $action }}" class="jp-btn jp-btn--accent u-mt-sm">{{ $actionLabel }}</a>
    @endif

    {{ $slot }}
</div>
