@php
    $reviews = [
        [
            'quote' => 'Switched in 5 minutes and saved £276 a year!',
            'name' => 'Sarah T.',
            'place' => 'Manchester',
            'avatar' => 'sarah',
        ],
        [
            'quote' => "Finally, a comparison site that's simple and actually shows the best deals.",
            'name' => 'James L.',
            'place' => 'Bristol',
            'avatar' => 'james',
        ],
        [
            'quote' => 'Great experience from start to finish. Lower bills, happy days!',
            'name' => 'Emily R.',
            'place' => 'Leeds',
            'avatar' => 'emily',
        ],
        [
            'quote' => 'Clear deals, no jargon. I finally understand my tariff.',
            'name' => 'Priya N.',
            'place' => 'London',
            'avatar' => 'sarah',
        ],
        [
            'quote' => 'Saved over £300 and the whole process was painless.',
            'name' => 'Tom H.',
            'place' => 'Birmingham',
            'avatar' => 'james',
        ],
    ];
@endphp

<section
    class="bg-[#f5f5f5] py-16 sm:py-20"
    aria-labelledby="testimonials-heading"
    x-data="{
        scrollBy(dir) {
            const el = this.$refs.track;
            const card = el.querySelector('article');
            const styles = getComputedStyle(el);
            const gap = parseFloat(styles.columnGap || styles.gap) || 20;
            const amount = (card?.getBoundingClientRect().width ?? 320) + gap;
            el.scrollBy({ left: dir * amount, behavior: 'smooth' });
        }
    }"
>
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="text-center">
            <p class="text-[0.6875rem] font-bold uppercase tracking-[0.16em] text-switchly-lime sm:text-xs">
                Loved by thousands
            </p>
            <h2
                id="testimonials-heading"
                class="mt-2.5 text-[1.875rem] font-extrabold tracking-tight text-switchly-ink sm:text-4xl"
            >
                Real people. Real savings.
            </h2>
        </div>

        <div class="relative mt-10 lg:mt-12">
            <button
                type="button"
                class="absolute left-0 top-1/2 z-20 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-switchly-black text-white shadow-md transition hover:bg-neutral-800 sm:h-11 sm:w-11"
                @click="scrollBy(-1)"
                aria-label="Previous reviews"
            >
                <svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M10 3.5 5.5 8 10 12.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <button
                type="button"
                class="absolute right-0 top-1/2 z-20 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-switchly-black text-white shadow-md transition hover:bg-neutral-800 sm:h-11 sm:w-11"
                @click="scrollBy(1)"
                aria-label="Next reviews"
            >
                <svg class="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <path d="M6 3.5 10.5 8 6 12.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <div class="px-12 sm:px-14 lg:px-16">
                <div
                    x-ref="track"
                    class="flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth pb-1 [-ms-overflow-style:none] [scrollbar-width:none] sm:gap-5 [&::-webkit-scrollbar]:hidden"
                >
                    @foreach ($reviews as $review)
                        <article class="flex w-[min(100%,18.5rem)] shrink-0 snap-start flex-col rounded-2xl bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:w-[calc((100%-2.5rem)/3)] sm:min-w-[calc((100%-2.5rem)/3)] sm:p-7">
                            <div class="mb-3.5 flex gap-[3px] text-switchly-lime" aria-label="5 star rating">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="h-[15px] w-[15px]" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                        <path d="M8 1.15 9.85 5.4l4.65.4-3.55 3.05 1.05 4.55L8 11.2l-4 2.2 1.05-4.55L1.5 5.8l4.65-.4L8 1.15Z" />
                                    </svg>
                                @endfor
                            </div>

                            <p class="text-[1.0625rem] font-bold leading-[1.35] tracking-tight text-switchly-ink">
                                "{{ $review['quote'] }}"
                            </p>

                            <div class="mt-auto flex items-center gap-3 pt-8">
                                <img
                                    src="{{ asset('images/reviews/' . $review['avatar'] . '.jpg') }}"
                                    alt=""
                                    width="40"
                                    height="40"
                                    class="h-10 w-10 rounded-full object-cover"
                                >
                                <div class="min-w-0 leading-tight">
                                    <p class="text-sm font-bold text-switchly-ink">{{ $review['name'] }}</p>
                                    <p class="mt-0.5 text-xs text-neutral-500">{{ $review['place'] }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-9 flex justify-center sm:mt-10">
            <a
                href="https://www.trustpilot.com"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-3 rounded-full border border-black/5 bg-white py-3 pl-6 pr-2.5 text-sm font-semibold text-switchly-ink shadow-[0_8px_24px_rgba(0,0,0,0.05)] transition hover:shadow-[0_10px_28px_rgba(0,0,0,0.08)]"
            >
                See all reviews on Trustpilot
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-switchly-lime text-switchly-black">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>
