@props([
    'steps' => [],
    'current' => 1,
])

<div {{ $attributes->merge(['class' => 'jp-stepper']) }}>
    @foreach($steps as $index => $step)
        @php
            $stepNum = $index + 1;
            $status = $stepNum < $current ? 'done' : ($stepNum == $current ? 'current' : 'todo');
        @endphp
        <div class="jp-stepper__item jp-stepper__item--{{ $status }}">
            <div class="jp-stepper__badge">
                @if($status === 'done')
                    <x-icon name="check" size="14" />
                @else
                    {{ $stepNum }}
                @endif
            </div>
            <span class="jp-stepper__label">{{ $step }}</span>
        </div>
        @if(!$loop->last)
            <div class="jp-stepper__line {{ $stepNum < $current ? 'is-active' : '' }}"></div>
        @endif
    @endforeach
</div>
