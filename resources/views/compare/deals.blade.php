@extends('layouts.funnel')

@section('title', 'Your deals — Brillia')

@section('body_class', 'bg-white')

@php
    $postcode = $compare['postcode'] ?? 'SW1A 1AA';
    $supplier = $compare['supplier'] ?? 'British Gas';
    $tariff = $compare['tariff'] ?? 'Standard Variable';
    $usageRaw = $compare['usage'] ?? '3100';
    $usage = number_format((int) preg_replace('/\D/', '', $usageRaw) ?: 3100);
    $fuelLabels = [
        'dual' => 'Dual fuel',
        'electricity' => 'Electricity only',
        'gas' => 'Gas only',
    ];
    $fuel = $fuelLabels[$compare['fuel'] ?? 'dual'] ?? 'Dual fuel';
    $deals = $deals ?? [];
@endphp

@section('content')
    <x-stepper :step="$step" />

    <main class="mx-auto max-w-6xl px-5 pb-16 sm:px-8 lg:px-10">
        {{-- Hero --}}
        <h1 class="mx-auto max-w-3xl text-center text-[1.75rem] font-extrabold leading-[1.2] tracking-tight text-brillia-ink sm:text-[2.25rem] sm:leading-[1.15] lg:text-[2.5rem]">
            Great news! We found {{ $dealCount }} deals<br class="hidden sm:block">
            that could save you <span class="text-brillia-lime">£{{ number_format($savings) }}/year</span>
        </h1>

        {{-- Summary bar + inline edit --}}
        <div
            class="mt-6 sm:mt-10"
            x-data="{ editing: {{ $errors->any() ? 'true' : 'false' }} }"
        >
            @if (session('status'))
                <div class="mb-3 rounded-xl border border-[#dce9b0] bg-[#f4f9e0] px-4 py-3 text-sm font-medium text-brillia-ink">
                    {{ session('status') }}
                </div>
            @endif

            <div
                x-show="!editing"
                class="rounded-2xl border border-[#dce9b0] bg-[#f4f9e0] px-4 py-3.5 sm:flex sm:items-center sm:gap-0 sm:px-6 sm:py-5 lg:px-7"
            >
                <div class="grid flex-1 grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-0">
                    <div class="sm:pr-5 lg:pr-7">
                        <p class="text-[0.6875rem] text-brillia-muted sm:text-xs">Results for</p>
                        <p class="mt-0.5 text-sm font-bold text-brillia-ink sm:mt-1 sm:text-[0.9375rem]">{{ $postcode }}</p>
                    </div>

                    <div class="sm:border-l sm:border-neutral-300/80 sm:px-5 lg:px-7">
                        <p class="text-[0.6875rem] text-brillia-muted sm:text-xs">Current supplier</p>
                        <p class="mt-0.5 flex items-center gap-1.5 text-sm font-bold text-brillia-ink sm:mt-1 sm:text-[0.9375rem]">
                            <span class="inline-block h-1.5 w-1.5 shrink-0 rounded-full bg-brillia-ink" aria-hidden="true"></span>
                            {{ $supplier }}
                        </p>
                    </div>

                    <div class="sm:border-l sm:border-neutral-300/80 sm:px-5 lg:px-7">
                        <p class="text-[0.6875rem] text-brillia-muted sm:text-xs">Tariff</p>
                        <p class="mt-0.5 text-sm font-bold text-brillia-ink sm:mt-1 sm:text-[0.9375rem]">{{ $tariff }}</p>
                    </div>

                    <div class="sm:border-l sm:border-neutral-300/80 sm:px-5 lg:px-7">
                        <p class="text-[0.6875rem] text-brillia-muted sm:text-xs">Est. annual usage</p>
                        <p class="mt-0.5 text-sm font-bold text-brillia-ink sm:mt-1 sm:text-[0.9375rem]">{{ $usage }} kWh · {{ $fuel }}</p>
                    </div>
                </div>

                <button
                    type="button"
                    @click="editing = true"
                    class="mt-3 inline-block text-sm font-semibold text-brillia-lime underline underline-offset-2 hover:brightness-90 sm:mt-0 sm:shrink-0 sm:pl-5"
                >
                    Edit
                </button>
            </div>

            <form
                x-show="editing"
                x-cloak
                action="{{ route('compare.deals.update') }}"
                method="POST"
                class="rounded-2xl border border-brillia-border bg-white p-4 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6"
            >
                @csrf

                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-base font-bold text-brillia-ink">Update your details</h2>
                        <p class="mt-1 text-sm text-brillia-muted">Change anything below — we’ll refresh deals without starting over.</p>
                    </div>
                    <button
                        type="button"
                        @click="editing = false"
                        class="text-sm font-medium text-brillia-muted underline underline-offset-2 hover:text-brillia-ink"
                    >
                        Cancel
                    </button>
                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <x-form.input
                            name="postcode"
                            label="Postcode"
                            placeholder="e.g. SW1A 1AA"
                            :value="old('postcode', $compare['postcode'] ?? '')"
                            maxlength="8"
                            autocomplete="postal-code"
                            pattern="{{ \App\Rules\UkPostcode::HTML_PATTERN }}"
                            title="Enter a valid UK postcode (e.g. SW1A 1AA)"
                            required
                        />
                        @error('postcode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.select
                            name="supplier"
                            label="Current supplier"
                            :value="old('supplier', $compare['supplier'] ?? '')"
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
                        @error('supplier')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.select
                            name="tariff"
                            label="Tariff type"
                            :value="old('tariff', $compare['tariff'] ?? '')"
                            :options="[
                                'Standard Variable' => 'Standard Variable',
                                'Fixed' => 'Fixed',
                                'Tracker' => 'Tracker',
                                'Prepayment' => 'Prepayment',
                                'Not sure' => 'I\'m not sure',
                            ]"
                            required
                        />
                        @error('tariff')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.input
                            name="usage"
                            label="Est. annual usage (kWh)"
                            placeholder="e.g. 3100"
                            :value="old('usage', $compare['usage'] ?? '3100')"
                            required
                        />
                        @error('usage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.select
                            name="fuel"
                            label="Fuel type"
                            :value="old('fuel', $compare['fuel'] ?? 'dual')"
                            :options="[
                                'dual' => 'Dual fuel',
                                'electricity' => 'Electricity only',
                                'gas' => 'Gas only',
                            ]"
                            required
                        />
                        @error('fuel')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.select
                            name="payment"
                            label="Payment method"
                            :value="old('payment', $compare['payment'] ?? 'direct_debit')"
                            :options="[
                                'direct_debit' => 'Monthly Direct Debit',
                                'prepayment' => 'Prepayment meter',
                                'on_demand' => 'Pay on receipt',
                            ]"
                            required
                        />
                        @error('payment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap items-center gap-3">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-brillia-black px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-neutral-800"
                    >
                        Update results
                    </button>
                    <p class="text-xs text-brillia-muted">Your email and contact details stay as they are.</p>
                </div>
            </form>
        </div>

        {{-- Filters + deal cards --}}
        <div
            class="mt-8 sm:mt-10"
            x-data="dealResults"
        >
            <div class="flex items-center gap-2 sm:justify-between">
                <div class="-mx-5 min-w-0 flex-1 overflow-x-auto px-5 [-ms-overflow-style:none] [scrollbar-width:none] sm:mx-0 sm:overflow-visible sm:px-0 [&::-webkit-scrollbar]:hidden">
                    <div class="flex w-max items-center gap-2 sm:w-auto sm:flex-wrap">
                        @foreach ([
                            'cheapest' => 'Cheapest',
                            'top' => 'Top rated',
                            'green' => 'Green energy',
                            'saving' => 'Biggest saving',
                        ] as $key => $label)
                            <button
                                type="button"
                                @click="sort = '{{ $key }}'"
                                :class="sort === '{{ $key }}'
                                    ? 'bg-brillia-black text-white'
                                    : 'bg-[#f0f0f0] text-brillia-ink hover:bg-neutral-200'"
                                class="shrink-0 rounded-full px-3.5 py-2 text-xs font-medium transition sm:px-4 sm:py-2.5 sm:text-sm"
                            >
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="relative shrink-0" @click.outside="filterOpen = false">
                    <button
                        type="button"
                        @click="filterOpen = ! filterOpen"
                        :aria-expanded="filterOpen.toString()"
                        class="inline-flex items-center justify-center gap-1.5 rounded-full border border-brillia-border bg-white px-3.5 py-2 text-xs font-medium text-brillia-ink transition hover:bg-neutral-50 sm:gap-2 sm:px-4 sm:py-2.5 sm:text-sm"
                        :class="(greenOnly || fixedOnly) && 'border-brillia-ink bg-[#f4f9e0]'"
                    >
                        Filter
                        <svg class="h-3.5 w-3.5 text-brillia-muted sm:h-4 sm:w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M2 4h12M4 8h8M6 12h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </button>

                    <div
                        x-show="filterOpen"
                        x-cloak
                        x-transition
                        class="absolute right-0 z-30 mt-2 w-56 rounded-2xl border border-brillia-border bg-white p-3 shadow-[0_12px_40px_rgba(0,0,0,0.12)]"
                    >
                        <p class="px-1 text-xs font-semibold uppercase tracking-wide text-brillia-muted">Refine results</p>
                        <label class="mt-2 flex cursor-pointer items-center gap-2.5 rounded-xl px-2 py-2 text-sm text-brillia-ink hover:bg-neutral-50">
                            <input type="checkbox" class="rounded border-brillia-border text-brillia-ink focus:ring-brillia-lime" x-model="greenOnly">
                            Green energy only
                        </label>
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-xl px-2 py-2 text-sm text-brillia-ink hover:bg-neutral-50">
                            <input type="checkbox" class="rounded border-brillia-border text-brillia-ink focus:ring-brillia-lime" x-model="fixedOnly">
                            Fixed tariffs only
                        </label>
                        <button
                            type="button"
                            class="mt-1 w-full rounded-xl px-2 py-2 text-left text-sm font-medium text-brillia-muted hover:bg-neutral-50 hover:text-brillia-ink"
                            @click="greenOnly = false; fixedOnly = false; filterOpen = false"
                        >
                            Clear filters
                        </button>
                    </div>
                </div>
            </div>

            <p class="mt-3 text-sm text-brillia-muted" x-show="matchCount > 0 && matchCount < {{ (int) $dealCount }}" x-cloak>
                Showing <span x-text="matchCount"></span> of {{ $dealCount }} deals
            </p>

            <div class="mt-5 flex flex-col gap-4 sm:mt-6" x-ref="list">
                @foreach ($deals as $index => $deal)
                    <div
                        data-deal-card
                        data-cost="{{ (int) ($deal['annualCost'] ?? 0) }}"
                        data-saving="{{ (int) ($deal['saveYear'] ?? 0) }}"
                        data-rating="{{ (float) ($deal['rating'] ?? 0) }}"
                        data-green="{{ ! empty($deal['isGreen']) ? '1' : '0' }}"
                        data-fixed="{{ ! empty($deal['isFixed']) ? '1' : '0' }}"
                        @if ($index >= 3)
                            x-cloak
                        @endif
                    >
                        <x-deal-card
                            :logo="$deal['logo']"
                            :logo-alt="$deal['logoAlt']"
                            :plan="$deal['plan']"
                            :badge="$deal['badge']"
                            :features="$deal['features']"
                            :save-year="$deal['saveYear']"
                            :save-month="$deal['saveMonth']"
                            :annual-cost="$deal['annualCost'] ?? null"
                            :href="route('compare.redirect', $deal['id'])"
                        />
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center" x-show="!showAll && matchCount > 3" x-cloak>
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full border border-brillia-border bg-white px-5 py-2.5 text-sm font-semibold text-brillia-ink transition hover:bg-neutral-50"
                    @click="showAll = true"
                >
                    See all <span x-text="matchCount"></span> deals
                    <svg class="h-3.5 w-3.5" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                        <path d="M2.5 4.5 6 8l3.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <div class="mt-8 flex justify-center" x-cloak x-show="showAll && matchCount > 3">
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full border border-brillia-border bg-white px-5 py-2.5 text-sm font-semibold text-brillia-ink transition hover:bg-neutral-50"
                    @click="showAll = false"
                >
                    Show fewer deals
                    <svg class="h-3.5 w-3.5 rotate-180" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                        <path d="M2.5 4.5 6 8l3.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Help choosing --}}
        <div class="mt-8 flex flex-col items-start gap-4 rounded-2xl bg-[#f4f9e0] px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5">
            <div class="flex items-center gap-3.5 sm:gap-4">
                <img
                    src="{{ asset('images/avatars/1.jpg') }}"
                    alt=""
                    class="h-12 w-12 shrink-0 rounded-full object-cover sm:h-14 sm:w-14"
                >
                <div>
                    <p class="text-base font-extrabold text-brillia-ink sm:text-lg">Need help choosing?</p>
                    <p class="mt-0.5 text-sm text-brillia-muted">Our UK based team is here for you.</p>
                </div>
            </div>

            <button
                type="button"
                class="inline-flex shrink-0 items-center justify-center rounded-full border border-brillia-border bg-white px-5 py-2.5 text-sm font-semibold text-brillia-ink shadow-sm transition hover:bg-neutral-50"
                @click="window.dispatchEvent(new CustomEvent('brillia-chat-open'))"
            >
                Chat with us
            </button>
        </div>

        {{-- Best price guarantee --}}
        <div class="mt-4 flex items-start gap-4 rounded-2xl border border-brillia-border bg-white px-5 py-4 sm:items-center sm:px-6 sm:py-5">
            <span class="mt-0.5 inline-flex h-11 w-11 shrink-0 items-center justify-center text-brillia-lime sm:mt-0" aria-hidden="true">
                <svg class="h-11 w-11" viewBox="0 0 44 44" fill="none">
                    <path
                        d="M22.0 4.05 L22.85 4.7 L23.55 6.28 L24.1 7.87 L24.66 8.61 L25.47 8.15 L26.59 6.88 L27.84 5.69 L28.87 5.42 L29.41 6.34 L29.45 8.07 L29.34 9.75 L29.58 10.65 L30.51 10.53 L32.02 9.79 L33.63 9.17 L34.69 9.31 L34.83 10.37 L34.21 11.98 L33.47 13.49 L33.35 14.42 L34.25 14.66 L35.93 14.55 L37.66 14.59 L38.58 15.13 L38.31 16.16 L37.12 17.41 L35.85 18.53 L35.39 19.34 L36.13 19.9 L37.72 20.45 L39.3 21.15 L39.95 22.0 L39.3 22.85 L37.72 23.55 L36.13 24.1 L35.39 24.66 L35.85 25.47 L37.12 26.59 L38.31 27.84 L38.58 28.87 L37.66 29.41 L35.93 29.45 L34.25 29.34 L33.35 29.58 L33.47 30.51 L34.21 32.02 L34.83 33.63 L34.69 34.69 L33.63 34.83 L32.02 34.21 L30.51 33.47 L29.58 33.35 L29.34 34.25 L29.45 35.93 L29.41 37.66 L28.87 38.58 L27.84 38.31 L26.59 37.12 L25.47 35.85 L24.66 35.39 L24.1 36.13 L23.55 37.72 L22.85 39.3 L22.0 39.95 L21.15 39.3 L20.45 37.72 L19.9 36.13 L19.34 35.39 L18.53 35.85 L17.41 37.12 L16.16 38.31 L15.13 38.58 L14.59 37.66 L14.55 35.93 L14.66 34.25 L14.42 33.35 L13.49 33.47 L11.98 34.21 L10.37 34.83 L9.31 34.69 L9.17 33.63 L9.79 32.02 L10.53 30.51 L10.65 29.58 L9.75 29.34 L8.07 29.45 L6.34 29.41 L5.42 28.87 L5.69 27.84 L6.88 26.59 L8.15 25.47 L8.61 24.66 L7.87 24.1 L6.28 23.55 L4.7 22.85 L4.05 22.0 L4.7 21.15 L6.28 20.45 L7.87 19.9 L8.61 19.34 L8.15 18.53 L6.88 17.41 L5.69 16.16 L5.42 15.13 L6.34 14.59 L8.07 14.55 L9.75 14.66 L10.65 14.42 L10.53 13.49 L9.79 11.98 L9.17 10.37 L9.31 9.31 L10.37 9.17 L11.98 9.79 L13.49 10.53 L14.42 10.65 L14.66 9.75 L14.55 8.07 L14.59 6.34 L15.13 5.42 L16.16 5.69 L17.41 6.88 L18.53 8.15 L19.34 8.61 L19.9 7.87 L20.45 6.28 L21.15 4.7 Z"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M15 22.2 19.3 26.5 29.2 16"
                        stroke="currentColor"
                        stroke-width="2.2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </span>
            <div>
                <p class="text-base font-extrabold text-brillia-ink sm:text-lg">Our Best Price Guarantee</p>
                <p class="mt-0.5 text-sm text-brillia-muted">
                    If you find the same tariff cheaper elsewhere, we’ll help you switch.
                </p>
            </div>
        </div>
    </main>
@endsection
