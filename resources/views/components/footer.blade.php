<footer class="border-t border-switchly-border bg-white">
    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-5 py-7 sm:px-8 lg:flex-row lg:items-center lg:justify-between lg:gap-8 lg:px-10">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-5">
            <a href="{{ url('/') }}" class="flex shrink-0 items-center" aria-label="Switchly home">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Switchly"
                    class="h-7 w-auto"
                    width="285"
                    height="80"
                >
            </a>
            <p class="text-sm text-switchly-muted">
                © {{ date('Y') }} Switchly. All rights reserved.
            </p>
        </div>

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:gap-8 lg:gap-10">
            <nav class="flex flex-wrap gap-x-5 gap-y-2 text-sm text-switchly-muted" aria-label="Footer">
                <a href="{{ url('/#why-switchly') }}" class="transition hover:text-switchly-ink">About us</a>
                <a href="{{ route('contact') }}" class="transition hover:text-switchly-ink">Contact</a>
                <a href="{{ route('affiliates') }}" class="transition hover:text-switchly-ink">Affiliates</a>
                <a href="{{ route('guides.index') }}" class="transition hover:text-switchly-ink">Guides</a>
                <a href="{{ url('/#faqs') }}" class="transition hover:text-switchly-ink">FAQs</a>
            </nav>

            <div class="flex items-center gap-2.5">
                <a
                    href="#"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-switchly-black text-white transition hover:bg-neutral-800"
                    aria-label="Facebook"
                >
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H8v3h3v7h3v-7h3l1-3h-4V9c0-.6.4-1 1-1Z" />
                    </svg>
                </a>
                <a
                    href="#"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-switchly-black text-white transition hover:bg-neutral-800"
                    aria-label="X"
                >
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.727-8.835L1.254 2.25H8.08l4.258 5.686L18.244 2.25Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z" />
                    </svg>
                </a>
                <a
                    href="#"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-switchly-black text-white transition hover:bg-neutral-800"
                    aria-label="Instagram"
                >
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 7.2A4.8 4.8 0 1 0 12 16.8 4.8 4.8 0 0 0 12 7.2Zm0 7.9a3.1 3.1 0 1 1 0-6.2 3.1 3.1 0 0 1 0 6.2ZM17.4 6.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2ZM21 9.4v5.2A4.4 4.4 0 0 1 16.6 19H7.4A4.4 4.4 0 0 1 3 14.6V9.4A4.4 4.4 0 0 1 7.4 5h9.2A4.4 4.4 0 0 1 21 9.4Zm-1.7 0A2.7 2.7 0 0 0 16.6 6.7H7.4A2.7 2.7 0 0 0 4.7 9.4v5.2A2.7 2.7 0 0 0 7.4 17.3h9.2a2.7 2.7 0 0 0 2.7-2.7V9.4Z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
