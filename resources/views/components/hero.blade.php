<section class="overflow-hidden bg-white">
    <div class="mx-auto grid max-w-7xl items-center gap-8 px-5 py-8 sm:gap-10 sm:px-8 sm:py-12 lg:grid-cols-2 lg:gap-8 lg:px-10 lg:py-16 xl:gap-4">
        {{-- Left: copy + form --}}
        <div class="max-w-xl lg:max-w-none">
            {{-- Social proof --}}
            <div class="mb-7 inline-flex items-center gap-3 rounded-full bg-[#eef8d8] py-1.5 pl-1.5 pr-4">
                <div class="flex -space-x-2.5">
                    @foreach (range(1, 4) as $n)
                        <img
                            src="{{ asset("images/avatars/{$n}.jpg") }}"
                            alt=""
                            width="32"
                            height="32"
                            class="h-8 w-8 rounded-full border-2 border-[#eef8d8] object-cover"
                        >
                    @endforeach
                </div>
                <p class="flex items-center gap-1.5 text-sm font-medium text-switchly-ink">
                    <svg class="h-3.5 w-3.5 text-switchly-lime" viewBox="0 0 14 14" fill="currentColor" aria-hidden="true">
                        <path d="M7 1.1 8.6 5h4.2l-3.4 2.5 1.3 4L7 9.2 3.3 11.5l1.3-4L1.2 5h4.2L7 1.1Z" />
                    </svg>
                    Join <span class="font-bold">50,000+</span> happy customers
                </p>
            </div>

            <h1 class="text-[2rem] font-extrabold leading-[1.1] tracking-tight text-switchly-ink sm:text-[3.25rem] sm:leading-[1.08] lg:text-[3.55rem] xl:text-[3.85rem]">
                Energy comparison made simple.<br>
                <span class="text-switchly-lime">Savings</span> made real.
            </h1>

            <p class="mt-4 max-w-md text-[0.9375rem] leading-relaxed text-switchly-muted sm:mt-5 sm:text-lg">
                Switchly compares the best energy deals in seconds so you can save more, stress less.
            </p>

            <ul class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2.5 text-sm font-medium text-switchly-ink sm:mt-6 sm:gap-x-6 sm:text-[0.9375rem]">
                @foreach (['100% Free', 'No sign-up required', 'Takes 60 seconds'] as $item)
                    <li class="inline-flex items-center gap-2">
                        <span class="inline-flex h-[1.125rem] w-[1.125rem] shrink-0 items-center justify-center rounded-full bg-switchly-lime">
                            <svg class="h-2.5 w-2.5 text-white" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                                <path d="M2.4 6.2 4.9 8.7 9.6 3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        {{ $item }}
                    </li>
                @endforeach
            </ul>

            {{-- Postcode form: stacked on mobile, combined pill from sm+ --}}
            <form action="{{ route('compare.details') }}" method="get" class="mt-6 sm:mt-8">
                <div class="flex flex-col gap-2.5 rounded-full border border-switchly-border bg-white p-1.5 shadow-[0_8px_30px_rgba(0,0,0,0.06)] max-sm:rounded-[1.75rem] sm:flex-row sm:items-center sm:gap-0">
                    <label class="relative min-w-0 flex-1">
                        <span class="sr-only">Postcode</span>
                        <input
                            type="text"
                            name="postcode"
                            placeholder="Enter your postcode"
                            autocomplete="postal-code"
                            class="w-full rounded-full bg-transparent py-3 pl-5 pr-11 text-base text-switchly-ink outline-none placeholder:text-neutral-400 sm:py-3.5 sm:text-[0.9375rem]"
                        >
                        <svg class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-neutral-400" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M10 10.8a2.2 2.2 0 1 0 0-4.4 2.2 2.2 0 0 0 0 4.4Z" stroke="currentColor" stroke-width="1.5" />
                            <path d="M10 17.5s6-5.1 6-9.2A6 6 0 1 0 4 8.3c0 4.1 6 9.2 6 9.2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                    </label>

                    <button
                        type="submit"
                        class="inline-flex shrink-0 items-center justify-center gap-2.5 self-stretch rounded-full bg-switchly-black py-3 pl-5 pr-2.5 text-[0.9375rem] font-semibold text-white transition hover:bg-neutral-800 sm:self-auto sm:py-2.5"
                    >
                        Compare now
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-switchly-lime text-switchly-black">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>
                </div>
            </form>

            <p class="mt-3.5 flex items-center gap-1.5 text-sm text-switchly-muted">
                <svg class="h-3.5 w-3.5 text-switchly-ink" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                    <path d="M3.5 6V4.8a3.5 3.5 0 0 1 7 0V6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                    <rect x="2.25" y="6" width="9.5" height="6.25" rx="1.6" stroke="currentColor" stroke-width="1.4" />
                </svg>
                We don't share your data. Ever.
            </p>

            {{-- Trustpilot --}}
            <div class="mt-10 flex flex-wrap items-center gap-x-3.5 gap-y-2 text-switchly-ink sm:mt-12 sm:gap-x-4">
                <span class="text-base font-bold sm:text-lg">Excellent</span>
                <div class="flex items-center gap-1" aria-label="5 star rating">
                    @for ($i = 0; $i < 5; $i++)
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-[3px] bg-[#00b67a] sm:h-7 sm:w-7">
                            <svg class="h-3.5 w-3.5 text-white sm:h-4 sm:w-4" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true">
                                <path d="M6 1.1 7.35 4.3l3.5.3-2.65 2.3.8 3.4L6 8.6 3 10.3l.8-3.4L1.15 4.6l3.5-.3L6 1.1Z" />
                            </svg>
                        </span>
                    @endfor
                </div>
                <span class="text-sm text-switchly-muted sm:text-base">
                    <span class="font-bold text-switchly-ink">4.8</span> out of 5
                </span>
                <span class="inline-flex items-center gap-1.5 text-base font-bold sm:text-lg">
                    <svg class="h-5 w-5 text-[#00b67a] sm:h-6 sm:w-6" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1.2 10.1 5.8l5 .45-3.8 3.3 1.15 4.85L8 11.9l-4.45 2.5 1.15-4.85-3.8-3.3 5-.45L8 1.2Z" />
                    </svg>
                    Trustpilot
                </span>
            </div>
        </div>

        {{-- Right: hero visual --}}
        <div class="relative mx-auto w-full max-w-xl lg:max-w-none lg:justify-self-end">
            <img
                src="{{ asset('images/hero-right.png') }}"
                alt="Lightbulb with a glowing lightning bolt — lower bills, brighter future"
                width="961"
                height="950"
                class="mx-auto h-auto w-full max-w-[36rem] object-contain lg:max-w-none"
            >
        </div>
    </div>
</section>
