@extends('layouts.funnel')

@section('title', 'Your details — Brillia')

@section('content')
    <x-stepper :step="$step" />

    <main class="mx-auto max-w-xl px-5 pb-16 sm:px-8">
        <div class="text-center">
            <h1 class="text-2xl font-extrabold tracking-tight text-brillia-ink sm:text-3xl lg:text-[2rem]">
                Let’s find your best energy deals
            </h1>
            <p class="mt-2 text-sm text-brillia-muted sm:text-base">
                Just a few quick details and you’re on your way.
            </p>
        </div>

        <form action="{{ route('compare.details.store') }}" method="POST" class="mt-8 space-y-4">
            @csrf

            {{-- 1. Postcode --}}
            <section class="rounded-2xl border border-brillia-border bg-white p-5 sm:p-6">
                <h2 class="text-base font-bold text-brillia-ink sm:text-[1.05rem]">
                    1. Where do you live?
                </h2>
                <div class="mt-4">
                    <x-form.input
                        name="postcode"
                        label="UK postcode"
                        placeholder="e.g. SW1A 1AA"
                        icon="pin"
                        :value="$postcode"
                        maxlength="8"
                        autocomplete="postal-code"
                        pattern="{{ \App\Rules\UkPostcode::HTML_PATTERN }}"
                        title="Enter a valid UK postcode (e.g. SW1A 1AA)"
                        required
                    />
                </div>
                <a href="#" class="mt-3 inline-block text-sm font-medium text-brillia-lime underline underline-offset-2 hover:brightness-90">
                    Can’t find your address?
                </a>
                @error('postcode')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </section>

            {{-- 2. Supplier --}}
            <section class="rounded-2xl border border-brillia-border bg-white p-5 sm:p-6">
                <h2 class="text-base font-bold text-brillia-ink sm:text-[1.05rem]">
                    2. Who is your current supplier?
                </h2>
                <div class="mt-4">
                    <x-form.select
                        name="supplier"
                        label="Supplier"
                        placeholder="Select your current supplier"
                        :value="$supplier"
                        :options="[
                            'British Gas' => 'British Gas',
                            'Octopus Energy' => 'Octopus Energy',
                            'E.ON Next' => 'E.ON Next',
                            'ScottishPower' => 'ScottishPower',
                            'OVO Energy' => 'OVO Energy',
                            'EDF' => 'EDF',
                            'Utilita' => 'Utilita',
                            'Other' => 'Other / Not listed',
                        ]"
                        required
                    />
                </div>
                @error('supplier')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </section>

            {{-- 3. Tariff --}}
            <section class="rounded-2xl border border-brillia-border bg-white p-5 sm:p-6">
                <h2 class="text-base font-bold text-brillia-ink sm:text-[1.05rem]">
                    3. What tariff are you on?
                </h2>
                <div class="mt-4">
                    <x-form.select
                        name="tariff"
                        label="Tariff type"
                        placeholder="Select your tariff type"
                        :value="$tariff"
                        :options="[
                            'Standard Variable' => 'Standard Variable',
                            'Fixed' => 'Fixed',
                            'Tracker' => 'Tracker',
                            'Prepayment' => 'Prepayment',
                            'Not sure' => 'I\'m not sure',
                        ]"
                        required
                    />
                </div>
                <a href="#" class="mt-3 inline-block text-sm font-medium text-brillia-lime underline underline-offset-2 hover:brightness-90">
                    Not sure what tariff you’re on?
                </a>
                @error('tariff')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </section>

            {{-- Privacy note --}}
            <div class="flex items-start gap-3 rounded-2xl border border-[#d4e8a0] bg-[#f4f9e0] px-4 py-3.5">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-brillia-lime" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                    <path d="M5 8V6a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                    <rect x="3.5" y="8" width="13" height="9" rx="2" stroke="currentColor" stroke-width="1.6" />
                </svg>
                <p class="text-sm leading-relaxed text-brillia-muted">
                    We only use this information to find you the best deals. We never share or sell your data.
                </p>
            </div>

            {{-- Continue --}}
            <button
                type="submit"
                class="inline-flex w-full items-center justify-between rounded-full bg-brillia-black py-3.5 pl-6 pr-2.5 text-base font-semibold text-white transition hover:bg-neutral-800"
            >
                <span class="flex-1 text-center pl-7">Continue</span>
                <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brillia-lime text-brillia-black">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </button>

            <p class="flex items-center justify-center gap-1.5 pt-1 text-sm text-neutral-400">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                    <circle cx="10" cy="11" r="6.5" stroke="currentColor" stroke-width="1.5" />
                    <path d="M10 8v3l2 1.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                Takes less than 60 seconds.
            </p>
        </form>

        {{-- Trust strip --}}
        <div class="mt-8 border-t border-brillia-border pt-6 sm:mt-10 sm:pt-8">
            <div class="grid grid-cols-3 gap-2 sm:gap-4">
                <div class="flex flex-col items-center gap-2 text-center sm:flex-row sm:items-center sm:gap-3 sm:text-left">
                    <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-neutral-300 text-brillia-ink sm:h-10 sm:w-10">
                        <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M5 8V6a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <rect x="3.5" y="8" width="13" height="9" rx="2" stroke="currentColor" stroke-width="1.5" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-[0.6875rem] font-bold text-brillia-ink sm:text-sm">Secure</p>
                        <p class="text-[0.625rem] leading-snug text-brillia-muted sm:text-xs">Bank-level encryption</p>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-2 text-center sm:flex-row sm:items-center sm:gap-3 sm:text-left">
                    <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-neutral-300 text-brillia-ink sm:h-10 sm:w-10">
                        <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M10 17.5c-2.2-1.4-6.5-4.8-6.5-9.2A4.2 4.2 0 0 1 10 4.5a4.2 4.2 0 0 1 6.5 3.8c0 4.4-4.3 7.8-6.5 9.2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            <path d="M10 4.5v13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-[0.6875rem] font-bold text-brillia-ink sm:text-sm">100% free</p>
                        <p class="text-[0.625rem] leading-snug text-brillia-muted sm:text-xs">No hidden costs</p>
                    </div>
                </div>

                <div class="flex flex-col items-center gap-2 text-center sm:flex-row sm:items-center sm:gap-3 sm:text-left">
                    <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-neutral-300 text-brillia-ink sm:h-10 sm:w-10">
                        <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M10 2.5v3.5M10 14v3.5M2.5 10H6M14 10h3.5M4.8 4.8l2.5 2.5M12.7 12.7l2.5 2.5M15.2 4.8l-2.5 2.5M7.3 12.7l-2.5 2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-[0.6875rem] font-bold text-brillia-ink sm:text-sm">Trusted</p>
                        <p class="text-[0.625rem] leading-snug text-brillia-muted sm:text-xs">50,000+ users</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
