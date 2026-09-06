@php
    $features = [
        [
            'title' => 'Find the best deal',
            'body' => 'We compare 1000s of tariffs to find you the lowest prices.',
            'icon' => 'tag',
        ],
        [
            'title' => "It's quick & easy",
            'body' => 'Takes just 60 seconds. No hassle, no hidden steps.',
            'icon' => 'clock',
        ],
        [
            'title' => '100% free',
            'body' => 'Our service is free forever. We get paid by suppliers, not you.',
            'icon' => 'shield',
        ],
        [
            'title' => "We're here to help",
            'body' => 'Our UK support team is here if you need us.',
            'icon' => 'user',
        ],
    ];
@endphp

<section id="why-brillia" class="scroll-mt-24 bg-[#f3f3f3] py-20 sm:py-24" aria-labelledby="why-heading">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="text-center">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-brillia-lime sm:text-[0.8125rem]">
                Why Brillia?
            </p>
            <h2
                id="why-heading"
                class="mt-3 text-[2rem] font-extrabold tracking-tight text-brillia-ink sm:text-4xl lg:text-[2.75rem]"
            >
                More than just a comparison
            </h2>
        </div>

        <div class="mt-12 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4 lg:gap-6 xl:gap-7">
            @foreach ($features as $feature)
                <article class="rounded-[1.25rem] bg-white p-4 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-9 lg:min-h-[17.5rem]">
                    <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#e8f6b8] text-brillia-ink sm:mb-6 sm:h-14 sm:w-14">
                        @if ($feature['icon'] === 'tag')
                            <svg class="h-5 w-5 sm:h-7 sm:w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M20.4 12.3 12.5 20.2a2.1 2.1 0 0 1-3 0L3.2 13.9V4.8h9.1l8.1 7.5a2.1 2.1 0 0 1 0 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                                <circle cx="8" cy="8.6" r="1.35" fill="currentColor" />
                            </svg>
                        @elseif ($feature['icon'] === 'clock')
                            <svg class="h-5 w-5 sm:h-7 sm:w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="13.2" r="7.1" stroke="currentColor" stroke-width="1.6" />
                                <path d="M12 9.8v3.5l2.3 1.35" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9.2 4.2h5.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                                <path d="M12 4.2V2.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                        @elseif ($feature['icon'] === 'shield')
                            <svg class="h-5 w-5 sm:h-7 sm:w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3.2 4.5 6.2v5.4c0 4.7 3.2 7.9 7.5 9 4.3-1.1 7.5-4.3 7.5-9V6.2L12 3.2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                            </svg>
                        @else
                            <svg class="h-5 w-5 sm:h-7 sm:w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="8" r="3.3" stroke="currentColor" stroke-width="1.6" />
                                <path d="M5.2 19.4c.9-3.4 3.4-5.2 6.8-5.2s5.9 1.8 6.8 5.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                        @endif
                    </div>

                    <h3 class="text-sm font-bold tracking-tight text-brillia-ink sm:text-xl">
                        {{ $feature['title'] }}
                    </h3>
                    <p class="mt-1.5 text-xs leading-relaxed text-brillia-muted sm:mt-3 sm:text-[0.9375rem]">
                        {{ $feature['body'] }}
                    </p>
                </article>
            @endforeach
        </div>
    </div>
</section>
