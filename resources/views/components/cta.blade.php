<section class="bg-white py-12 sm:py-16" aria-labelledby="cta-heading">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="rounded-[1.5rem] bg-switchly-black px-6 py-10 sm:rounded-[1.75rem] sm:px-10 sm:py-12 lg:px-14 lg:py-12 xl:px-16">
            <div class="grid items-center gap-10 lg:grid-cols-[1.15fr_1fr] lg:gap-12 xl:gap-16">
                {{-- Copy --}}
                <div class="min-w-0">
                    <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime sm:text-xs">
                        Ready to save?
                    </p>
                    <h2
                        id="cta-heading"
                        class="mt-3 text-[1.85rem] font-extrabold leading-[1.12] tracking-tight text-white sm:text-4xl lg:text-[2.5rem] xl:text-[2.75rem]"
                    >
                        Lower your energy bills<br class="hidden sm:block">
                        in just <span class="text-switchly-lime">60 seconds.</span>
                    </h2>

                    <ul class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2.5 text-sm font-medium text-white">
                        @foreach (['Free', 'Fast', 'Trusted by 50,000+'] as $point)
                            <li class="inline-flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-switchly-lime text-switchly-black">
                                    <svg class="h-3 w-3" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                                        <path d="M2.5 6.2 4.8 8.5 9.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                {{ $point }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Form --}}
                <div class="relative min-w-0 pt-8 sm:pt-10">
                    {{-- Hand-drawn looping arrow pointing at Compare now --}}
                    <svg
                        class="pointer-events-none absolute right-1 top-0 hidden h-[3.75rem] w-[4.25rem] text-switchly-lime sm:block sm:right-3 lg:right-5"
                        viewBox="0 0 68 60"
                        fill="none"
                        aria-hidden="true"
                    >
                        <path
                            d="M42 4
                               C54 2 64 12 62 24
                               C60 36 48 42 38 38
                               C28 34 26 22 34 16
                               C40 12 50 14 52 24
                               C54 32 48 40 38 46
                               C32 50 26 54 20 58"
                            stroke="currentColor"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M20 58 L9 51 M20 58 L15 67"
                            stroke="currentColor"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    <form action="{{ route('compare.details') }}" method="get" class="flex flex-col gap-3 sm:flex-row sm:items-start">
                        <div class="min-w-0 flex-1">
                            <label class="relative block">
                                <span class="sr-only">Postcode</span>
                                <input
                                    type="text"
                                    name="postcode"
                                    placeholder="Enter your postcode"
                                    autocomplete="postal-code"
                                    class="w-full rounded-xl border-0 bg-white py-3.5 pl-4 pr-11 text-[0.9375rem] text-switchly-ink outline-none ring-0 placeholder:text-neutral-400 focus:ring-2 focus:ring-switchly-lime"
                                >
                                <svg class="pointer-events-none absolute right-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-neutral-400" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path d="M10 10.8a2.2 2.2 0 1 0 0-4.4 2.2 2.2 0 0 0 0 4.4Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M10 17.5s6-5.1 6-9.2A6 6 0 1 0 4 8.3c0 4.1 6 9.2 6 9.2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                </svg>
                            </label>

                            <p class="mt-3 flex items-center gap-1.5 text-sm text-white/55">
                                <svg class="h-3.5 w-3.5 shrink-0 text-white/80" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                    <path d="M3.5 6V4.8a3.5 3.5 0 0 1 7 0V6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                                    <rect x="2.25" y="6" width="9.5" height="6.25" rx="1.6" stroke="currentColor" stroke-width="1.4" />
                                </svg>
                                We don't share your data. Ever.
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="relative inline-flex shrink-0 items-center justify-center self-stretch rounded-xl bg-switchly-lime px-6 py-3.5 text-[0.9375rem] font-bold text-switchly-ink transition hover:brightness-95 sm:self-auto sm:py-[0.95rem]"
                        >
                            Compare now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
