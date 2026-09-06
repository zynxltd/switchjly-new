@props([
    'variant' => 'cta', // 'cta' | 'secure'
])

<header
    x-data="{ open: false, helpOpen: false }"
    class="sticky top-0 z-50 border-b border-switchly-border bg-white"
>
    <div class="mx-auto grid h-[4.75rem] max-w-7xl grid-cols-[1fr_auto] items-center gap-4 px-5 sm:px-8 lg:grid-cols-[1fr_auto_1fr] lg:gap-6 lg:px-10">
        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex shrink-0 items-center justify-self-start" aria-label="Switchly home">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="Switchly"
                class="h-8 w-auto sm:h-9"
                width="285"
                height="80"
            >
        </a>

        {{-- Desktop nav (truly centered) --}}
        <nav class="hidden items-center gap-8 lg:flex xl:gap-10" aria-label="Primary">
            @if ($variant === 'secure')
                <a href="{{ url('/#how-it-works') }}" class="text-[0.9375rem] font-medium text-switchly-muted transition hover:text-switchly-ink">
                    How it works
                </a>
                <a href="{{ url('/#why-switchly') }}" class="text-[0.9375rem] font-medium text-switchly-muted transition hover:text-switchly-ink">
                    About us
                </a>
            @else
                <a href="#how-it-works" class="text-[0.9375rem] font-medium text-switchly-muted transition hover:text-switchly-ink">
                    How it works
                </a>
                <a href="#why-switchly" class="text-[0.9375rem] font-medium text-switchly-muted transition hover:text-switchly-ink">
                    Why Switchly
                </a>
                <a href="{{ route('compare.details') }}" class="text-[0.9375rem] font-medium text-switchly-muted transition hover:text-switchly-ink">
                    Compare
                </a>
            @endif

            <div class="relative" @keydown.escape.window="helpOpen = false">
                <button
                    type="button"
                    class="inline-flex items-center gap-1 text-[0.9375rem] font-medium text-switchly-muted transition hover:text-switchly-ink"
                    @click="helpOpen = !helpOpen"
                    :aria-expanded="helpOpen.toString()"
                    aria-haspopup="true"
                >
                    Help
                    <svg class="h-3.5 w-3.5" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                        <path d="M3 4.5 6 7.5 9 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

                <div
                    x-show="helpOpen"
                    x-cloak
                    x-transition.opacity.duration.150ms
                    @click.outside="helpOpen = false"
                    class="absolute left-1/2 top-full mt-3 w-48 -translate-x-1/2 overflow-hidden rounded-xl border border-switchly-border bg-white py-2 shadow-lg"
                >
                    <a href="{{ url('/#faqs') }}" class="block px-4 py-2.5 text-sm font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink">FAQs</a>
                    <a href="{{ url('/#contact') }}" class="block px-4 py-2.5 text-sm font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink">Contact us</a>
                    <a href="{{ url('/#guides') }}" class="block px-4 py-2.5 text-sm font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink">Guides</a>
                </div>
            </div>
        </nav>

        {{-- Desktop CTA / trust --}}
        <div class="hidden justify-self-end lg:block">
            @if ($variant === 'secure')
                <div class="flex items-center gap-2 text-sm font-medium text-switchly-lime">
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M4 7V5.5a4 4 0 1 1 8 0V7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <rect x="2.75" y="7" width="10.5" height="7.25" rx="2" stroke="currentColor" stroke-width="1.5" />
                    </svg>
                    Your data is safe
                </div>
            @else
                <a
                    href="{{ route('compare.details') }}"
                    class="inline-flex items-center gap-2.5 rounded-full bg-switchly-black py-2.5 pl-5 pr-2.5 text-[0.9375rem] font-semibold text-white transition hover:bg-neutral-800"
                >
                    Check my rates
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-switchly-lime text-switchly-black">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
            @endif
        </div>

        {{-- Mobile toggle --}}
        <button
            type="button"
            class="inline-flex h-10 w-10 items-center justify-center justify-self-end rounded-full border border-switchly-border text-switchly-ink lg:hidden"
            @click="open = !open"
            :aria-expanded="open.toString()"
            aria-controls="mobile-nav"
            aria-label="Toggle menu"
        >
            <svg x-show="!open" class="h-5 w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M3 6h14M3 10h14M3 14h14" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
            </svg>
            <svg x-show="open" x-cloak class="h-5 w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M5 5l10 10M15 5 5 15" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    {{-- Mobile panel --}}
    <div
        id="mobile-nav"
        x-show="open"
        x-cloak
        x-transition
        class="border-t border-switchly-border bg-white lg:hidden"
    >
        <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-5 py-4 sm:px-8" aria-label="Mobile">
            @if ($variant === 'secure')
                <a href="{{ url('/#how-it-works') }}" class="rounded-lg px-3 py-3 text-base font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink" @click="open = false">How it works</a>
                <a href="{{ url('/#why-switchly') }}" class="rounded-lg px-3 py-3 text-base font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink" @click="open = false">About us</a>
                <a href="{{ url('/#faqs') }}" class="rounded-lg px-3 py-3 text-base font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink" @click="open = false">Help</a>
                <div class="mt-3 flex items-center gap-2 border-t border-switchly-border px-3 py-4 text-sm font-medium text-switchly-lime">
                    <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M4 7V5.5a4 4 0 1 1 8 0V7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <rect x="2.75" y="7" width="10.5" height="7.25" rx="2" stroke="currentColor" stroke-width="1.5" />
                    </svg>
                    Your data is safe
                </div>
            @else
                <a href="#how-it-works" class="rounded-lg px-3 py-3 text-base font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink" @click="open = false">How it works</a>
                <a href="#why-switchly" class="rounded-lg px-3 py-3 text-base font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink" @click="open = false">Why Switchly</a>
                <a href="{{ route('compare.details') }}" class="rounded-lg px-3 py-3 text-base font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink" @click="open = false">Compare</a>
                <a href="#faqs" class="rounded-lg px-3 py-3 text-base font-medium text-switchly-muted hover:bg-gray-50 hover:text-switchly-ink" @click="open = false">Help</a>

                <div class="mt-3 border-t border-switchly-border pt-4">
                    <a
                        href="{{ route('compare.details') }}"
                        class="inline-flex w-full items-center justify-between gap-2.5 rounded-full bg-switchly-black py-3 pl-5 pr-2.5 text-[0.9375rem] font-semibold text-white"
                        @click="open = false"
                    >
                        Check my rates
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-switchly-lime text-switchly-black">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
            @endif
        </nav>
    </div>
</header>
