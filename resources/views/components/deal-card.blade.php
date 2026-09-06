@props([
    'logo',
    'logoAlt',
    'plan',
    'badge' => null,
    'features' => [],
    'saveYear',
    'saveMonth',
])

<article class="overflow-hidden rounded-2xl border border-switchly-border bg-white sm:rounded-[1.25rem]">
    <div class="flex flex-col lg:flex-row lg:items-stretch">
        {{-- Logo + plan --}}
        <div class="flex flex-1 flex-col gap-4 p-4 sm:flex-row sm:items-center sm:gap-8 sm:p-7 lg:gap-10 lg:p-8 lg:pr-6">
            <div class="flex w-[6.5rem] shrink-0 items-center sm:w-40">
                <img
                    src="{{ $logo }}"
                    alt="{{ $logoAlt }}"
                    class="h-auto w-full max-w-[9rem] object-contain object-left grayscale transition duration-300 hover:grayscale-0"
                >
            </div>

            <div class="min-w-0 flex-1" x-data="{ open: false }">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-lg font-extrabold tracking-tight text-switchly-ink sm:text-xl">{{ $plan }}</h2>
                    @if ($badge)
                        <span class="inline-flex rounded-full bg-[#eaf8c4] px-2.5 py-0.5 text-xs font-semibold text-switchly-ink">
                            {{ $badge }}
                        </span>
                    @endif
                </div>

                <ul class="mt-3 space-y-2 sm:mt-4 sm:space-y-2.5">
                    @foreach ($features as $feature)
                        <li class="flex items-center gap-2 text-sm text-switchly-ink sm:gap-2.5 sm:text-[0.9375rem]">
                            <span class="inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-switchly-lime sm:h-5 sm:w-5">
                                <svg class="h-2.5 w-2.5 text-white sm:h-3 sm:w-3" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                                    <path d="M2.5 6.2 4.8 8.5 9.5 3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                <button
                    type="button"
                    class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-switchly-ink sm:mt-4"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                >
                    More details
                    <svg class="h-3.5 w-3.5 transition" :class="open && 'rotate-180'" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                        <path d="M2.5 4.5 6 8l3.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

                <div x-show="open" x-cloak class="mt-3 text-sm leading-relaxed text-switchly-muted">
                    Estimated based on your usage. Prices include VAT. Exact rates confirmed before you switch.
                </div>
            </div>
        </div>

        {{-- Savings + CTA --}}
        <div class="flex flex-row items-center justify-between gap-4 border-t border-switchly-border bg-[#fafafa] p-4 sm:flex-col sm:items-stretch sm:justify-center sm:p-7 lg:w-[16.5rem] lg:shrink-0 lg:border-t-0 lg:border-l lg:p-8">
            <div class="min-w-0">
                <span class="inline-flex w-fit rounded-full bg-[#eaf8c4] px-2.5 py-0.5 text-[0.6875rem] font-semibold text-[#3d6b00] sm:px-3 sm:py-1 sm:text-xs">
                    You could save
                </span>

                <p class="mt-2 flex items-baseline gap-1 sm:mt-3.5 sm:gap-1.5">
                    <span class="text-xl font-extrabold tracking-tight text-switchly-ink sm:text-[2.125rem]">£{{ number_format($saveYear) }}</span>
                    <span class="text-xs text-switchly-muted sm:text-sm">/year</span>
                </p>
                <p class="mt-0.5 text-xs text-switchly-muted sm:mt-1 sm:text-sm">£{{ number_format($saveMonth, 2) }} /month</p>
            </div>

            <a
                href="#"
                class="inline-flex shrink-0 items-center justify-between gap-2 rounded-full bg-switchly-black py-2.5 pl-4 pr-1.5 text-sm font-semibold text-white transition hover:bg-neutral-800 sm:mt-6 sm:w-full sm:py-3.5 sm:pl-5 sm:pr-2"
            >
                <span>View Deal</span>
                <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-switchly-lime text-switchly-black sm:h-8 sm:w-8">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
        </div>
    </div>
</article>
