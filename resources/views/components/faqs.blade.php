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

<section id="faqs" class="scroll-mt-24 bg-white py-16 sm:py-20" aria-labelledby="faqs-heading">
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
            {{-- Chat illustration --}}
            <div class="relative mx-auto w-full max-w-md lg:mx-0 lg:max-w-none">
                <img
                    src="{{ asset('images/illustrations/faq-chat.png') }}"
                    alt="Chat showing How does Switchly work? We compare. You save."
                    width="926"
                    height="490"
                    class="mx-auto h-auto w-full max-w-lg object-contain lg:max-w-md xl:max-w-lg"
                >
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
