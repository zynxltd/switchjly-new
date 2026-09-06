@extends('layouts.funnel')

@section('title', 'Your usage — Brillia')

@section('content')
    <x-stepper :step="$step" />

    <main class="mx-auto max-w-xl px-5 pb-16 sm:px-8">
        <div class="text-center">
            <h1 class="text-2xl font-extrabold tracking-tight text-brillia-ink sm:text-3xl lg:text-[2rem]">
                Tell us about your usage
            </h1>
            <p class="mt-2 text-sm text-brillia-muted sm:text-base">
                An estimate is fine — we’ll refine deals from this.
            </p>
        </div>

        <form action="{{ route('compare.usage.store') }}" method="POST" class="mt-8 space-y-4">
            @csrf

            <section class="rounded-2xl border border-brillia-border bg-white p-5 sm:p-6">
                <h2 class="text-base font-bold text-brillia-ink sm:text-[1.05rem]">
                    1. What fuel do you need?
                </h2>
                <div class="mt-4">
                    <x-form.select
                        name="fuel"
                        label="Fuel type"
                        placeholder="Select fuel type"
                        :value="$fuel"
                        :options="[
                            'dual' => 'Dual fuel (gas & electricity)',
                            'electricity' => 'Electricity only',
                            'gas' => 'Gas only',
                        ]"
                        required
                    />
                </div>
                @error('fuel')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </section>

            <section class="rounded-2xl border border-brillia-border bg-white p-5 sm:p-6">
                <h2 class="text-base font-bold text-brillia-ink sm:text-[1.05rem]">
                    2. What’s your annual usage?
                </h2>
                <div class="mt-4">
                    <x-form.input
                        name="usage"
                        label="Estimated annual usage (kWh)"
                        placeholder="e.g. 3100"
                        :value="$usage"
                        required
                    />
                </div>
                <p class="mt-3 text-sm text-brillia-muted">
                    Not sure? Typical UK dual-fuel homes use around 2,700–3,100 kWh electricity and 11,500 kWh gas a year.
                </p>
                @error('usage')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </section>

            <section class="rounded-2xl border border-brillia-border bg-white p-5 sm:p-6">
                <h2 class="text-base font-bold text-brillia-ink sm:text-[1.05rem]">
                    3. How do you pay?
                </h2>
                <div class="mt-4">
                    <x-form.select
                        name="payment"
                        label="Payment method"
                        placeholder="Select payment method"
                        :value="$payment"
                        :options="[
                            'direct_debit' => 'Monthly Direct Debit',
                            'prepayment' => 'Prepayment meter',
                            'on_demand' => 'Pay on receipt',
                        ]"
                        required
                    />
                </div>
                @error('payment')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </section>

            <section class="rounded-2xl border border-brillia-border bg-white p-5 sm:p-6">
                <h2 class="text-base font-bold text-brillia-ink sm:text-[1.05rem]">
                    4. Where should we send your deals?
                </h2>
                <p class="mt-1.5 text-sm text-brillia-muted">
                    We’ll email your results and occasional switching tips — unsubscribe anytime.
                </p>
                <div class="mt-4 space-y-3">
                    <x-form.input
                        name="name"
                        label="Full name"
                        placeholder="Your name"
                        :value="$name"
                        autocomplete="name"
                    />
                    @error('name')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <x-form.input
                        name="email"
                        type="email"
                        label="Email"
                        placeholder="you@example.com"
                        :value="$email"
                        autocomplete="email"
                        required
                    />
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <button
                type="submit"
                class="inline-flex w-full items-center justify-between rounded-full bg-brillia-black py-3.5 pl-6 pr-2.5 text-base font-semibold text-white transition hover:bg-neutral-800"
            >
                <span class="flex-1 pl-7 text-center">See your deals</span>
                <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brillia-lime text-brillia-black">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </button>

            <p class="pt-1 text-center">
                <a href="{{ route('compare.details') }}" class="text-sm font-semibold text-brillia-muted underline underline-offset-2 hover:text-brillia-ink">
                    Back to details
                </a>
            </p>
        </form>
    </main>
@endsection
