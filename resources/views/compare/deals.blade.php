@extends('layouts.funnel')

@section('title', 'Your deals — Switchly')

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

    $features = [
        '12 month fixed',
        '100% renewable electricity',
        '£0 exit fees',
    ];

    $deals = [
        [
            'logo' => asset('images/suppliers/octopus-color.png'),
            'logoAlt' => 'Octopus Energy',
            'plan' => 'Octopus Go',
            'badge' => 'Cheapest',
            'features' => $features,
            'saveYear' => 312,
            'saveMonth' => 26.00,
        ],
        [
            'logo' => asset('images/suppliers/scottishpower-color.png'),
            'logoAlt' => 'ScottishPower',
            'plan' => 'Secure Fixed 12',
            'badge' => null,
            'features' => $features,
            'saveYear' => 265,
            'saveMonth' => 22.08,
        ],
        [
            'logo' => asset('images/suppliers/eon-color.png'),
            'logoAlt' => 'E.ON',
            'plan' => 'Next Flex',
            'badge' => null,
            'features' => [
                'No fixed term',
                '100% renewable electricity',
                '£0 exit fees',
            ],
            'saveYear' => 198,
            'saveMonth' => 16.50,
        ],
    ];
@endphp

@section('content')
    <x-stepper :step="$step" />

    <main class="mx-auto max-w-6xl px-5 pb-16 sm:px-8 lg:px-10">
        {{-- Hero --}}
        <h1 class="mx-auto max-w-3xl text-center text-[1.75rem] font-extrabold leading-[1.2] tracking-tight text-switchly-ink sm:text-[2.25rem] sm:leading-[1.15] lg:text-[2.5rem]">
            Great news! We found {{ $dealCount }} deals<br class="hidden sm:block">
            that could save you <span class="text-switchly-lime">£{{ number_format($savings) }}/year</span>
        </h1>

        {{-- Summary bar --}}
        <div class="mt-8 flex flex-col gap-4 rounded-2xl border border-[#dce9b0] bg-[#f4f9e0] px-5 py-4 sm:mt-10 sm:flex-row sm:items-center sm:gap-0 sm:px-6 sm:py-5 lg:px-7">
            <div class="grid flex-1 grid-cols-2 gap-4 sm:grid-cols-4 sm:gap-0">
                <div class="sm:pr-5 lg:pr-7">
                    <p class="text-xs text-switchly-muted">Results for</p>
                    <p class="mt-1 text-sm font-bold text-switchly-ink sm:text-[0.9375rem]">{{ $postcode }}</p>
                </div>

                <div class="sm:border-l sm:border-neutral-300/80 sm:px-5 lg:px-7">
                    <p class="text-xs text-switchly-muted">Current supplier</p>
                    <p class="mt-1 flex items-center gap-1.5 text-sm font-bold text-switchly-ink sm:text-[0.9375rem]">
                        <span class="inline-block h-1.5 w-1.5 shrink-0 rounded-full bg-switchly-ink" aria-hidden="true"></span>
                        {{ $supplier }}
                    </p>
                </div>

                <div class="sm:border-l sm:border-neutral-300/80 sm:px-5 lg:px-7">
                    <p class="text-xs text-switchly-muted">Tariff</p>
                    <p class="mt-1 text-sm font-bold text-switchly-ink sm:text-[0.9375rem]">{{ $tariff }}</p>
                </div>

                <div class="sm:border-l sm:border-neutral-300/80 sm:px-5 lg:px-7">
                    <p class="text-xs text-switchly-muted">Estimated annual usage</p>
                    <p class="mt-1 text-sm font-bold text-switchly-ink sm:text-[0.9375rem]">{{ $usage }} kWh · {{ $fuel }}</p>
                </div>
            </div>

            <a
                href="{{ route('compare.usage') }}"
                class="shrink-0 text-sm font-semibold text-switchly-lime underline underline-offset-2 hover:brightness-90 sm:pl-5"
            >
                Edit
            </a>
        </div>

        {{-- Filters + deal cards --}}
        <div class="mt-8 sm:mt-10" x-data="{ sort: 'cheapest' }">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap gap-2">
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
                                ? 'bg-switchly-black text-white'
                                : 'bg-[#f0f0f0] text-switchly-ink hover:bg-neutral-200'"
                            class="rounded-full px-4 py-2.5 text-sm font-medium transition"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 self-start rounded-full border border-switchly-border bg-white px-4 py-2.5 text-sm font-medium text-switchly-ink transition hover:bg-neutral-50 sm:self-auto"
                >
                    Filter
                    <svg class="h-4 w-4 text-switchly-muted" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M2 4h12M4 8h8M6 12h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            <div class="mt-5 space-y-4 sm:mt-6">
                @foreach ($deals as $deal)
                    <x-deal-card
                        :logo="$deal['logo']"
                        :logo-alt="$deal['logoAlt']"
                        :plan="$deal['plan']"
                        :badge="$deal['badge']"
                        :features="$deal['features']"
                        :save-year="$deal['saveYear']"
                        :save-month="$deal['saveMonth']"
                    />
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full border border-switchly-border bg-white px-5 py-2.5 text-sm font-semibold text-switchly-ink transition hover:bg-neutral-50"
                >
                    See all {{ $dealCount }} deals
                    <svg class="h-3.5 w-3.5" viewBox="0 0 12 12" fill="none" aria-hidden="true">
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
                    <p class="text-base font-extrabold text-switchly-ink sm:text-lg">Need help choosing?</p>
                    <p class="mt-0.5 text-sm text-switchly-muted">Our UK based team is here for you.</p>
                </div>
            </div>

            <button
                type="button"
                class="inline-flex shrink-0 items-center justify-center rounded-full border border-switchly-border bg-white px-5 py-2.5 text-sm font-semibold text-switchly-ink shadow-sm transition hover:bg-neutral-50"
                @click="window.dispatchEvent(new CustomEvent('switchly-chat-open'))"
            >
                Chat with us
            </button>
        </div>

        {{-- Best price guarantee --}}
        <div class="mt-4 flex items-start gap-4 rounded-2xl border border-switchly-border bg-white px-5 py-4 sm:items-center sm:px-6 sm:py-5">
            <span class="mt-0.5 inline-flex h-11 w-11 shrink-0 items-center justify-center text-switchly-lime sm:mt-0" aria-hidden="true">
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
                <p class="text-base font-extrabold text-switchly-ink sm:text-lg">Our Best Price Guarantee</p>
                <p class="mt-0.5 text-sm text-switchly-muted">
                    If you find the same tariff cheaper elsewhere, we’ll help you switch.
                </p>
            </div>
        </div>
    </main>
@endsection
