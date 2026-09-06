@extends('layouts.app')

@section('title', 'Contact Brillia — UK energy comparison support')
@section('meta_description', 'Get in touch with the Brillia UK team about energy comparisons, switching help, or partnerships. We usually respond within one working day.')
@section('canonical', route('contact'))

@section('content')
    <section class="bg-[#f3f3f3] py-14 sm:py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime sm:text-xs">
                    Contact
                </p>
                <h1 class="mt-3 text-[1.875rem] font-extrabold tracking-tight text-brillia-ink sm:text-4xl">
                    We’re here to help
                </h1>
                <p class="mt-3 text-sm text-brillia-muted sm:text-base">
                    Questions about comparing deals, switching, or working with Brillia? Send a message — our UK team will get back to you.
                </p>
            </div>

            <div class="mx-auto mt-10 grid max-w-5xl gap-4 sm:grid-cols-3 sm:gap-5">
                @foreach ([
                    [
                        'href' => url('/#faqs'),
                        'label' => 'Browse FAQs',
                        'body' => 'Switching, fees, and data safety — answered fast.',
                        'icon' => 'faq',
                    ],
                    [
                        'href' => route('guides.index'),
                        'label' => 'Read our guides',
                        'body' => 'Plain-English advice on tariffs and saving.',
                        'icon' => 'guide',
                    ],
                    [
                        'href' => route('compare.details'),
                        'label' => 'Compare deals',
                        'body' => 'Free comparison — usually under a minute.',
                        'icon' => 'bolt',
                    ],
                ] as $card)
                    <a
                        href="{{ $card['href'] }}"
                        class="rounded-[1.25rem] bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] transition hover:ring-1 hover:ring-brillia-lime/50 sm:p-7"
                    >
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#e8f6b8] text-brillia-ink">
                            @if ($card['icon'] === 'faq')
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <circle cx="10" cy="10" r="7.25" stroke="currentColor" stroke-width="1.6" />
                                    <path d="M7.6 7.6a2.4 2.4 0 1 1 3.5 2.1c-.7.4-1.1.9-1.1 1.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                                    <circle cx="10" cy="14.2" r="0.9" fill="currentColor" />
                                </svg>
                            @elseif ($card['icon'] === 'guide')
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path d="M4.5 4.5h8.5a2 2 0 0 1 2 2v9H6.5a2 2 0 0 0-2 2V4.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
                                    <path d="M7.5 8h5M7.5 11h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                                </svg>
                            @else
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M11 1.5 3.5 11h5.2L7.8 18.5 16.5 8.2h-5.3L11 1.5Z" />
                                </svg>
                            @endif
                        </span>
                        <p class="mt-4 text-base font-bold tracking-tight text-brillia-ink">{{ $card['label'] }}</p>
                        <p class="mt-1.5 text-sm leading-relaxed text-brillia-muted">{{ $card['body'] }}</p>
                    </a>
                @endforeach
            </div>

            <div class="mx-auto mt-10 grid max-w-5xl gap-6 lg:grid-cols-[0.9fr_1.2fr] lg:gap-8">
                <aside class="rounded-[1.25rem] bg-white p-7 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-8">
                    <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Reach us</p>
                    <h2 class="mt-3 text-xl font-extrabold tracking-tight text-brillia-ink">UK support team</h2>
                    <p class="mt-2 text-sm leading-relaxed text-brillia-muted">
                        We usually reply within one working day. For switching help, include your postcode if you can.
                    </p>

                    <div class="mt-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#e8f6b8] text-brillia-ink">
                                <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <rect x="2" y="3.5" width="12" height="9" rx="2" stroke="currentColor" stroke-width="1.5" />
                                    <path d="m2.8 4.5 5.2 4 5.2-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-brillia-muted">Email</p>
                                <a href="mailto:{{ config('company.support_email') }}" class="mt-0.5 text-sm font-bold text-brillia-ink hover:underline">
                                    {{ config('company.support_email') }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#e8f6b8] text-brillia-ink">
                                <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <path d="M4 7V5.5a4 4 0 1 1 8 0V7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <rect x="2.75" y="7" width="10.5" height="7.25" rx="2" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-brillia-muted">Privacy</p>
                                <p class="mt-0.5 text-sm font-medium text-brillia-ink">We never sell your personal data.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#e8f6b8] text-brillia-ink">
                                <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <path d="M3.5 4.5h9v8.5H3.5V4.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                    <path d="M6 4.5V3.5a2 2 0 0 1 4 0v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-brillia-muted">Company</p>
                                <p class="mt-0.5 text-sm font-medium text-brillia-ink">
                                    {{ config('company.trading_name') }} is a trading name of {{ config('company.legal_name') }}
                                    ({{ config('company.number') }}).
                                </p>
                                <p class="mt-1 text-sm leading-relaxed text-brillia-muted">
                                    {{ config('company.registered_office') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="rounded-[1.25rem] bg-white p-7 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-8">
                    <h2 class="text-xl font-extrabold tracking-tight text-brillia-ink">Send a message</h2>
                    <p class="mt-1.5 text-sm text-brillia-muted">Tell us how we can help — we’ll take it from there.</p>

                    @if (session('status'))
                        <p class="mt-5 rounded-xl bg-[#f4f9e0] px-4 py-3 text-sm font-medium text-brillia-ink" role="status">
                            {{ session('status') }}
                        </p>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-semibold text-brillia-ink">Name</label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                    class="w-full rounded-xl border border-brillia-border bg-white px-4 py-3.5 text-sm text-brillia-ink outline-none placeholder:text-neutral-400 focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/30"
                                >
                                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-semibold text-brillia-ink">Email</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    class="w-full rounded-xl border border-brillia-border bg-white px-4 py-3.5 text-sm text-brillia-ink outline-none placeholder:text-neutral-400 focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/30"
                                >
                                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="mb-1.5 block text-sm font-semibold text-brillia-ink">Subject</label>
                            <input
                                id="subject"
                                name="subject"
                                type="text"
                                value="{{ old('subject') }}"
                                required
                                class="w-full rounded-xl border border-brillia-border bg-white px-4 py-3.5 text-sm text-brillia-ink outline-none placeholder:text-neutral-400 focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/30"
                            >
                            @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="message" class="mb-1.5 block text-sm font-semibold text-brillia-ink">Message</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="5"
                                required
                                class="w-full rounded-xl border border-brillia-border bg-white px-4 py-3.5 text-sm text-brillia-ink outline-none placeholder:text-neutral-400 focus:border-brillia-ink focus:ring-2 focus:ring-brillia-lime/30"
                            >{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-between rounded-full bg-brillia-black py-3.5 pl-6 pr-2.5 text-sm font-semibold text-white transition hover:bg-neutral-800"
                        >
                            <span class="flex-1 pl-7 text-center">Send message</span>
                            <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brillia-lime text-brillia-black">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                    <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
