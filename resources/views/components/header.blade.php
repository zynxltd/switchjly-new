@props([
    'variant' => 'cta', // 'cta' | 'secure'
])

<header
    x-data="{
        open: false,
        helpOpen: false,
        toggle() {
            this.open = !this.open;
            document.body.classList.toggle('overflow-hidden', this.open);
        },
        close() {
            this.open = false;
            document.body.classList.remove('overflow-hidden');
        },
    }"
    class="sticky top-0 z-50 border-b border-brillia-border bg-white"
>
    <div class="mx-auto grid h-[4.75rem] max-w-7xl grid-cols-[1fr_auto] items-center gap-4 px-5 sm:px-8 lg:grid-cols-[1fr_auto_1fr] lg:gap-6 lg:px-10">
        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex shrink-0 items-center justify-self-start" aria-label="{{ config('company.product_name') }} home">
            <img
                src="{{ asset('images/logo-energy-wordmark-1.svg') }}"
                alt="{{ config('company.product_name') }}"
                class="h-10 w-auto sm:h-11"
                width="367"
                height="80"
            >
        </a>

        {{-- Desktop nav (truly centered) --}}
        <nav class="hidden items-center gap-8 lg:flex xl:gap-10" aria-label="Primary">
            @if ($variant === 'secure')
                <a href="{{ route('how-it-works') }}" class="text-[0.9375rem] font-medium text-brillia-muted transition hover:text-brillia-ink">
                    How it works
                </a>
                <a href="{{ url('/#why-brillia') }}" class="text-[0.9375rem] font-medium text-brillia-muted transition hover:text-brillia-ink">
                    About us
                </a>
            @else
                <a href="{{ route('how-it-works') }}" class="text-[0.9375rem] font-medium text-brillia-muted transition hover:text-brillia-ink">
                    How it works
                </a>
                <a href="{{ url('/#why-brillia') }}" class="text-[0.9375rem] font-medium text-brillia-muted transition hover:text-brillia-ink">
                    Why Brillia
                </a>
                <a href="{{ route('compare.details') }}" class="text-[0.9375rem] font-medium text-brillia-muted transition hover:text-brillia-ink">
                    Compare
                </a>
            @endif

            <div class="relative" @keydown.escape.window="helpOpen = false">
                <button
                    type="button"
                    class="inline-flex items-center gap-1 text-[0.9375rem] font-medium text-brillia-muted transition hover:text-brillia-ink"
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
                    class="absolute left-1/2 top-full mt-3 w-48 -translate-x-1/2 overflow-hidden rounded-xl border border-brillia-border bg-white py-2 shadow-lg"
                >
                    <a href="{{ url('/#faqs') }}" class="block px-4 py-2.5 text-sm font-medium text-brillia-muted hover:bg-gray-50 hover:text-brillia-ink">FAQs</a>
                    <a href="{{ route('contact') }}" class="block px-4 py-2.5 text-sm font-medium text-brillia-muted hover:bg-gray-50 hover:text-brillia-ink">Contact us</a>
                    <a href="{{ route('guides.index') }}" class="block px-4 py-2.5 text-sm font-medium text-brillia-muted hover:bg-gray-50 hover:text-brillia-ink">Guides</a>
                </div>
            </div>
        </nav>

        {{-- Desktop CTA / trust --}}
        <div class="hidden justify-self-end lg:block">
            @if ($variant === 'secure')
                <div class="flex items-center gap-3 rounded-xl border border-brillia-border bg-white px-3.5 py-2 shadow-[0_1px_2px_rgba(0,0,0,0.04)]">
                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#eaf8c4] text-brillia-lime">
                        <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M4 7V5.5a4 4 0 1 1 8 0V7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            <rect x="2.75" y="7" width="10.5" height="7.25" rx="2" stroke="currentColor" stroke-width="1.6" />
                        </svg>
                    </span>
                    <div class="min-w-0 leading-tight">
                        <p class="text-sm font-bold text-brillia-ink">Your data is safe</p>
                        <p class="mt-0.5 text-xs text-brillia-muted">We never share your personal information.</p>
                    </div>
                </div>
            @else
                <a
                    href="{{ route('compare.details') }}"
                    class="inline-flex items-center gap-2.5 rounded-full bg-brillia-black py-2.5 pl-5 pr-2.5 text-[0.9375rem] font-semibold text-white transition hover:bg-neutral-800"
                >
                    Check my rates
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-brillia-lime text-brillia-black">
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
            class="inline-flex h-10 w-10 items-center justify-center justify-self-end rounded-full border border-brillia-border text-brillia-ink lg:hidden"
            @click="toggle()"
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

    {{-- Mobile full-screen menu --}}
    <div
        id="mobile-nav"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[60] flex flex-col bg-white lg:hidden"
        @keydown.escape.window="close()"
    >
        <div class="flex h-[4.75rem] shrink-0 items-center justify-between border-b border-brillia-border px-5 sm:px-8">
            <a href="{{ url('/') }}" class="flex items-center" aria-label="{{ config('company.product_name') }} home" @click="close()">
                <img
                    src="{{ asset('images/logo-energy-wordmark-1.svg') }}"
                    alt="{{ config('company.product_name') }}"
                    class="h-10 w-auto"
                    width="367"
                    height="80"
                >
            </a>
            <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-brillia-border text-brillia-ink"
                @click="close()"
                aria-label="Close menu"
            >
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                    <path d="M5 5l10 10M15 5 5 15" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <nav class="flex flex-1 flex-col overflow-y-auto px-5 py-6 sm:px-8" aria-label="Mobile">
            @if ($variant === 'secure')
                <a href="{{ route('how-it-works') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">How it works</a>
                <a href="{{ url('/#why-brillia') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">About us</a>
                <a href="{{ url('/#faqs') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">Help</a>
                <div class="mt-8 flex items-center gap-3 rounded-xl border border-brillia-border bg-[#f8f8f8] px-4 py-4">
                    <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#eaf8c4] text-brillia-lime">
                        <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M4 7V5.5a4 4 0 1 1 8 0V7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                            <rect x="2.75" y="7" width="10.5" height="7.25" rx="2" stroke="currentColor" stroke-width="1.6" />
                        </svg>
                    </span>
                    <div class="min-w-0 leading-tight">
                        <p class="text-sm font-bold text-brillia-ink">Your data is safe</p>
                        <p class="mt-0.5 text-xs text-brillia-muted">We never share your personal information.</p>
                    </div>
                </div>
            @else
                <a href="{{ route('how-it-works') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">How it works</a>
                <a href="{{ url('/#why-brillia') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">Why Brillia</a>
                <a href="{{ route('compare.details') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">Compare</a>
                <a href="{{ url('/#faqs') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">Help</a>
                <a href="{{ route('contact') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">Contact</a>
                <a href="{{ route('guides.index') }}" class="border-b border-brillia-border py-4 text-lg font-semibold text-brillia-ink" @click="close()">Guides</a>

                <div class="mt-auto pt-8">
                    <a
                        href="{{ route('compare.details') }}"
                        class="inline-flex w-full items-center justify-between gap-2.5 rounded-full bg-brillia-black py-3.5 pl-5 pr-2.5 text-base font-semibold text-white"
                        @click="close()"
                    >
                        Check my rates
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brillia-lime text-brillia-black">
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
