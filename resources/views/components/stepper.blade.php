@props([
    'step' => 1,
])

@php
    $steps = [
        1 => 'Your details',
        2 => 'Your usage',
        3 => 'See your deals',
    ];
@endphp

<nav aria-label="Progress" class="mx-auto w-full max-w-md px-5 py-8 sm:px-8 sm:py-10">
    <ol class="relative flex items-start justify-between">
        <li
            class="pointer-events-none absolute top-4 right-[16%] left-[16%] h-px bg-brillia-border"
            aria-hidden="true"
        >
            <span
                class="absolute inset-y-0 left-0 bg-brillia-lime transition-all"
                style="width: {{ $step <= 1 ? '0%' : ($step === 2 ? '50%' : '100%') }}"
            ></span>
        </li>

        @foreach ($steps as $number => $label)
            @php
                $active = $number === (int) $step;
                $done = $number < (int) $step;
            @endphp
            <li class="relative z-10 flex w-28 flex-col items-center text-center">
                <span @class([
                    'flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold',
                    'bg-brillia-lime text-white' => $active || $done,
                    'bg-[#e8e8e8] text-neutral-400' => ! $active && ! $done,
                ])>
                    {{ $number }}
                </span>
                <span @class([
                    'mt-2.5 text-xs sm:text-[0.8125rem]',
                    'font-bold text-brillia-ink' => $active,
                    'font-medium text-neutral-400' => ! $active,
                ])>
                    {{ $label }}
                </span>
            </li>
        @endforeach
    </ol>
</nav>
