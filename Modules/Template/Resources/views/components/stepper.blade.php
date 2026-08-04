@props(['steps' => [], 'current' => 0])

<div class="jp-stepper" {{ $attributes }}>
    <div class="jp-stepper__line"></div>
    <ol class="jp-stepper__steps">
        @foreach($steps as $index => $step)
            <li class="jp-stepper__item {{ $index < $current ? 'is-complete' : ($index === $current ? 'is-active' : '') }}" style="--step-index:{{ $index }}">
                <button type="button" class="jp-stepper__button" aria-current="{{ $index === $current ? 'step' : 'false' }}">
                    <span class="jp-stepper__icon">
                        @if($index < $current)
                            <x-icon name="check" size="16" />
                        @else
                            {{ $index + 1 }}
                        @endif
                    </span>
                    <span class="jp-stepper__label">{{ $step['label'] ?? '' }}</span>
                </button>
            </li>
        @endforeach
    </ol>
</div>