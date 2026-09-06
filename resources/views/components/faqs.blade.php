@php
    $faqs = [
        [
            'q' => 'How does Switchly work?',
            'a' => 'Enter a few details about your home and current tariff. We compare live deals from leading UK suppliers and show what you could save — usually in under a minute.',
        ],
        [
            'q' => 'Is Switchly really free?',
            'a' => 'Yes — 100% free. We never charge you to compare or switch. There are no hidden fees.',
        ],
        [
            'q' => 'Will I have to switch supplier?',
            'a' => 'Only if you choose to. We show your options clearly so you can stick with your current deal or switch when you’re ready — no pressure.',
        ],
        [
            'q' => 'How does Switchly make money?',
            'a' => 'If you switch, we may earn a commission from the supplier. It never affects the price you pay.',
        ],
        [
            'q' => 'Is my data safe with Switchly?',
            'a' => 'Yes. We only use your details to find matching deals and never sell your data. Your information is encrypted and handled securely.',
        ],
    ];
@endphp

<section id="faqs" class="bg-white py-16 sm:py-20" aria-labelledby="faqs-heading">
    <div class="mx-auto max-w-6xl px-5 sm:px-8 lg:px-10">
        <div class="text-center">
            <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime sm:text-xs">
                Faqs
            </p>
            <h2
                id="faqs-heading"
                class="mt-3 text-3xl font-extrabold tracking-tight text-switchly-ink sm:text-4xl"
            >
                Got questions? We’ve got answers.
            </h2>
        </div>

        <div class="mt-12 grid items-center gap-10 lg:grid-cols-2 lg:gap-14">
            {{-- Chat illustration — matched to design reference --}}
            <div class="relative mx-auto w-full max-w-[22rem] sm:max-w-md lg:mx-0 lg:max-w-none" aria-hidden="true">
                {{-- Dot grid (top-left, behind panel) --}}
                <div
                    class="pointer-events-none absolute left-0 top-0 z-0 h-28 w-28 sm:h-32 sm:w-32"
                    style="background-image: radial-gradient(circle, #d0d0d0 2px, transparent 2.2px); background-size: 11px 11px; -webkit-mask-image: radial-gradient(circle at 30% 30%, #000 0%, #000 55%, transparent 75%); mask-image: radial-gradient(circle at 30% 30%, #000 0%, #000 55%, transparent 75%);"
                ></div>

                {{-- Three short accent ticks (design), left of first bubble --}}
                <svg
                    class="pointer-events-none absolute left-1 top-[22%] z-20 h-10 w-8 text-switchly-ink sm:left-0 sm:top-[24%] sm:h-11 sm:w-9"
                    viewBox="0 0 32 44"
                    fill="none"
                    aria-hidden="true"
                >
                    <path d="M22 6 6 14M20 22H2M22 38 6 30" stroke="currentColor" stroke-width="2.75" stroke-linecap="round"/>
                </svg>

                {{-- Soft panel --}}
                <div class="relative z-10 ml-3 mr-2 rounded-[1.75rem] bg-[#f3f3f3] px-4 py-9 sm:ml-4 sm:mr-3 sm:rounded-[2rem] sm:px-6 sm:py-11">
                    <p class="sr-only">Chat showing: How does Switchly work? We compare. You save.</p>

                    {{-- Question — overlaps left edge --}}
                    <div class="relative z-10 -ml-6 w-[calc(100%+0.5rem)] max-w-none sm:-ml-9 sm:w-[min(100%+1.5rem,20.5rem)]">
                        <div class="rounded-[1.35rem] bg-switchly-ink px-4 py-3.5 sm:rounded-[1.5rem] sm:px-5 sm:py-4">
                            <p class="text-[0.9375rem] font-semibold leading-snug tracking-tight text-white sm:text-[1.0625rem]">
                                How does Switchly work?
                            </p>
                        </div>
                        {{-- Tail bottom-left --}}
                        <svg class="absolute -bottom-2 left-8 h-4 w-5 text-switchly-ink sm:left-10" viewBox="0 0 20 16" fill="currentColor" aria-hidden="true">
                            <path d="M2 2c2 8 8 12 16 14L6 2H2Z"/>
                        </svg>
                    </div>

                    {{-- Answer — overlaps right edge --}}
                    <div class="relative z-10 ml-auto mt-5 w-[calc(100%+0.75rem)] max-w-[18.5rem] -translate-x-0 sm:mt-6 sm:-mr-8 sm:w-[min(100%+2rem,19.5rem)]">
                        <div class="rounded-[1.35rem] bg-switchly-lime px-4 py-3.5 sm:rounded-[1.5rem] sm:px-5 sm:py-4">
                            <p class="text-[0.9375rem] font-bold leading-snug tracking-tight text-switchly-ink sm:text-[1.125rem]">
                                We compare. You save.
                            </p>
                        </div>
                        {{-- Tail bottom-right --}}
                        <svg class="absolute -bottom-2 right-8 h-4 w-5 text-switchly-lime sm:right-10" viewBox="0 0 20 16" fill="currentColor" aria-hidden="true">
                            <path d="M18 2c-2 8-8 12-16 14L14 2h4Z"/>
                        </svg>
                    </div>

                    {{-- Typing — compact --}}
                    <div class="relative z-10 mt-5 w-fit sm:mt-6 sm:ml-10">
                        <div class="flex items-center gap-1.5 rounded-full bg-switchly-ink px-3.5 py-2.5 sm:gap-2 sm:px-4 sm:py-3">
                            <span class="h-1.5 w-1.5 rounded-full bg-white sm:h-2 sm:w-2"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-white sm:h-2 sm:w-2"></span>
                            <span class="h-1.5 w-1.5 rounded-full bg-white sm:h-2 sm:w-2"></span>
                        </div>
                        <svg class="absolute -bottom-1.5 right-4 h-3 w-4 text-switchly-ink" viewBox="0 0 16 12" fill="currentColor" aria-hidden="true">
                            <path d="M14 1c-1.5 6-6 9-12 10L11 1h3Z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Accordion --}}
            <div class="space-y-3" x-data="{ open: null }">
                @foreach ($faqs as $index => $faq)
                    <div class="overflow-hidden rounded-2xl border border-switchly-border bg-white">
                        <button
                            type="button"
                            class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left sm:px-6 sm:py-[1.15rem]"
                            @click="open = open === {{ $index }} ? null : {{ $index }}"
                            :aria-expanded="(open === {{ $index }}).toString()"
                        >
                            <span class="text-sm font-semibold text-switchly-ink sm:text-[0.975rem]">
                                {{ $faq['q'] }}
                            </span>
                            <span
                                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#f0f0f0] text-lg leading-none text-neutral-500 transition"
                                :class="open === {{ $index }} ? 'rotate-45 bg-switchly-lime text-switchly-ink' : ''"
                                aria-hidden="true"
                            >+</span>
                        </button>

                        <div
                            x-show="open === {{ $index }}"
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="px-5 pb-4 text-sm leading-relaxed text-switchly-muted sm:px-6"
                        >
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
