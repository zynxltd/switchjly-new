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
        <div class="flex flex-1 flex-col gap-6 p-5 sm:flex-row sm:items-center sm:gap-8 sm:p-7 lg:gap-10 lg:p-8 lg:pr-6">
            <div class="flex w-[7.5rem] shrink-0 items-center sm:w-40">
                <img
                    src="{{ $logo }}"
                    alt="{{ $logoAlt }}"
                    class="h-auto w-full max-w-[9rem] object-contain object-left grayscale transition duration-300 hover:grayscale-0"
                >
            </div>

            <div class="min-w-0 flex-1" x-data="{ open: false }">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl font-extrabold tracking-tight text-switchly-ink">{{ $plan }}</h2>
                    @if ($badge)
                        <span class="inline-flex rounded-full bg-[#eaf8c4] px-2.5 py-0.5 text-xs font-semibold text-switchly-ink">
                            {{ $badge }}
                        </span>
                    @endif
                </div>

                <ul class="mt-4 space-y-2.5">
                    @foreach ($features as $feature)
                        <li class="flex items-center gap-2.5 text-sm text-switchly-ink sm:text-[0.9375rem]">
                            <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-switchly-lime">
                                <svg class="h-3 w-3 text-white" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                                    <path d="M2.5 6.2 4.8 8.5 9.5 3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                <button
                    type="button"
                    class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-switchly-ink"
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
        <div class="flex flex-col justify-center border-t border-switchly-border bg-[#fafafa] p-5 sm:p-7 lg:w-[16.5rem] lg:shrink-0 lg:border-t-0 lg:border-l lg:p-8">
            <span class="inline-flex w-fit rounded-full bg-[#eaf8c4] px-3 py-1 text-xs font-semibold text-[#3d6b00]">
                You could save
            </span>

            <p class="mt-3.5 flex items-baseline gap-1.5">
                <span class="text-[2rem] font-extrabold tracking-tight text-switchly-ink sm:text-[2.125rem]">£{{ number_format($saveYear) }}</span>
                <span class="text-sm text-switchly-muted">/year</span>
            </p>
            <p class="mt-1 text-sm text-switchly-muted">£{{ number_format($saveMonth, 2) }} /month</p>

            <a
                href="#"
                class="mt-6 inline-flex w-full items-center justify-between rounded-full bg-switchly-black py-3.5 pl-5 pr-2 text-sm font-semibold text-white transition hover:bg-neutral-800"
            >
                <span>View Deal</span>
                <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-switchly-lime text-switchly-black">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
        </div>
    </div>
</article>
