@extends('layouts.funnel')

@section('title', 'Complete your switch — Brillia')

@section('body_class', 'bg-[#f3f3f3]')

@section('content')
    <main class="mx-auto max-w-xl px-5 pb-16 pt-8 sm:px-8 sm:pt-10">
        @if (session('status') === 'application_submitted')
            <div class="rounded-[1.5rem] bg-white p-8 text-center shadow-[0_16px_50px_rgba(0,0,0,0.08)] sm:p-10">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#eaf8c4]">
                    <svg class="h-7 w-7 text-brillia-ink" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 12.5 9.5 17 19 7.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <p class="mt-5 text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Application received</p>
                <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-brillia-ink sm:text-3xl">
                    You’re all set
                </h1>
                <p class="mt-3 text-sm leading-relaxed text-brillia-muted">
                    We’ve started your switch to <strong class="text-brillia-ink">{{ $deal['plan'] }}</strong>
                    with {{ $deal['logoAlt'] }}. Check your inbox for next steps — supply won’t be interrupted.
                </p>
                <a
                    href="{{ route('home') }}"
                    class="mt-8 inline-flex items-center justify-center rounded-full bg-brillia-lime px-6 py-3 text-sm font-bold text-brillia-ink hover:brightness-95"
                >
                    Back to homepage
                </a>
            </div>
        @else
            <div class="text-center">
                <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Final step</p>
                <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-brillia-ink sm:text-3xl">
                    Complete your {{ $deal['logoAlt'] }} switch
                </h1>
                <p class="mt-2 text-sm text-brillia-muted">
                    Confirm a few details and we’ll send your application through.
                </p>
            </div>

            <div class="mt-6 flex items-center gap-4 rounded-2xl border border-brillia-border bg-white px-4 py-4 sm:px-5">
                <img
                    src="{{ $deal['logo'] }}"
                    alt="{{ $deal['logoAlt'] }}"
                    class="h-10 w-auto max-w-[7.5rem] object-contain"
                >
                <div class="min-w-0 flex-1 text-left">
                    <p class="truncate text-sm font-bold text-brillia-ink">{{ $deal['plan'] }}</p>
                    <p class="text-xs text-brillia-muted">
                        Could save £{{ number_format((int) ($deal['saveYear'] ?? 0)) }}/year
                    </p>
                </div>
            </div>

            <form
                action="{{ route('compare.apply.store', $deal['id']) }}"
                method="POST"
                class="mt-6 space-y-4 rounded-[1.25rem] border border-brillia-border bg-white p-5 sm:p-6"
            >
                @csrf

                <x-form.input
                    name="name"
                    label="Full name"
                    placeholder="Your full name"
                    :value="old('name', $name)"
                    autocomplete="name"
                    required
                />
                @error('name')
                    <p class="-mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <x-form.input
                    name="email"
                    type="email"
                    label="Email"
                    placeholder="you@example.com"
                    :value="old('email', $email)"
                    autocomplete="email"
                    required
                />
                @error('email')
                    <p class="-mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <x-form.input
                    name="phone"
                    type="tel"
                    label="Mobile number"
                    placeholder="07..."
                    :value="old('phone', $phone)"
                    autocomplete="tel"
                    required
                />
                @error('phone')
                    <p class="-mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <x-form.input
                    name="postcode"
                    label="Postcode"
                    placeholder="e.g. SW1A 1AA"
                    :value="old('postcode', $postcode)"
                    maxlength="8"
                    autocomplete="postal-code"
                    pattern="{{ \App\Rules\UkPostcode::HTML_PATTERN }}"
                    title="Enter a valid UK postcode (e.g. SW1A 1AA)"
                    required
                />
                @error('postcode')
                    <p class="-mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <x-form.input
                    name="address_line"
                    label="Address line"
                    placeholder="House number and street"
                    :value="old('address_line', $compare['address_line'] ?? '')"
                    autocomplete="address-line1"
                    required
                />
                @error('address_line')
                    <p class="-mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <label class="flex items-start gap-3 text-sm text-brillia-muted">
                    <input
                        type="checkbox"
                        name="consent"
                        value="1"
                        class="mt-1 h-4 w-4 rounded border-brillia-border text-brillia-ink focus:ring-brillia-lime"
                        @checked(old('consent'))
                        required
                    >
                    <span>
                        I confirm I’m the account holder (or authorised to switch) and agree to Brillia sharing these details with {{ $deal['logoAlt'] }} to complete my switch.
                    </span>
                </label>
                @error('consent')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-between rounded-full bg-brillia-lime py-3.5 pl-6 pr-2 text-sm font-bold text-brillia-ink transition hover:brightness-95"
                >
                    <span class="flex-1 pl-6 text-center">Submit application</span>
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-brillia-black text-white">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
            </form>

            <p class="mt-4 text-center text-xs text-brillia-muted">
                Free to switch · No interruption to your supply · Cancel anytime before the switch completes
            </p>
        @endif
    </main>
@endsection
