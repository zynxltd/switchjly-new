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
                <div class="relative min-w-0">
                    <form action="{{ route('compare.details') }}" method="get" class="flex flex-col gap-3 sm:flex-row sm:items-start">
                        <div class="min-w-0 flex-1">
                            <label class="relative block">
                                <span class="sr-only">Postcode</span>
                                <input
                                    type="text"
                                    name="postcode"
                                    placeholder="Enter your postcode"
                                    autocomplete="postal-code"
                                    class="w-full rounded-xl border-0 bg-white py-2.5 pl-3.5 pr-10 text-sm text-switchly-ink outline-none ring-0 placeholder:text-neutral-400 focus:ring-2 focus:ring-switchly-lime sm:py-3.5 sm:pl-4 sm:pr-11 sm:text-[0.9375rem]"
                                >
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400 sm:right-3.5 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path d="M10 10.8a2.2 2.2 0 1 0 0-4.4 2.2 2.2 0 0 0 0 4.4Z" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M10 17.5s6-5.1 6-9.2A6 6 0 1 0 4 8.3c0 4.1 6 9.2 6 9.2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                </svg>
                            </label>

                            <p class="mt-2.5 flex items-center gap-1.5 text-xs text-white/55 sm:mt-3 sm:text-sm">
                                <svg class="h-3.5 w-3.5 shrink-0 text-white/80" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                    <path d="M3.5 6V4.8a3.5 3.5 0 0 1 7 0V6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" />
                                    <rect x="2.25" y="6" width="9.5" height="6.25" rx="1.6" stroke="currentColor" stroke-width="1.4" />
                                </svg>
                                We don't share your data. Ever.
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="relative inline-flex shrink-0 items-center justify-center self-stretch rounded-xl bg-switchly-lime px-5 py-2.5 text-sm font-bold text-switchly-ink transition hover:brightness-95 sm:self-auto sm:px-6 sm:py-[0.95rem] sm:text-[0.9375rem]"
                        >
                            Compare now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
