@extends('layouts.funnel')

@section('title', 'Continuing to '.$deal['logoAlt'].' — Brillia')

@section('body_class', 'bg-[#f3f3f3]')

@push('head')
    <meta http-equiv="refresh" content="{{ (int) $delaySeconds }};url={{ $destination }}">
@endpush

@section('content')
    <main
        class="mx-auto flex min-h-[70vh] max-w-lg flex-col items-center justify-center px-5 py-16 text-center sm:px-8"
        x-data="{
            seconds: {{ (int) $delaySeconds }},
            destination: @js($destination),
            init() {
                const tick = setInterval(() => {
                    this.seconds = Math.max(0, this.seconds - 1);
                    if (this.seconds === 0) {
                        clearInterval(tick);
                        window.location.href = this.destination;
                    }
                }, 1000);
            }
        }"
    >
        <div class="w-full rounded-[1.5rem] bg-white p-8 shadow-[0_16px_50px_rgba(0,0,0,0.08)] sm:p-10">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#eaf8c4]">
                <svg class="h-7 w-7 animate-spin text-brillia-ink" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity="0.2" stroke-width="3" />
                    <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                </svg>
            </div>

            <p class="mt-6 text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">
                Almost there
            </p>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-brillia-ink sm:text-3xl">
                Taking you to complete your {{ $deal['logoAlt'] }} switch
            </h1>
            <p class="mt-3 text-sm leading-relaxed text-brillia-muted">
                You’ve chosen <strong class="text-brillia-ink">{{ $deal['plan'] }}</strong>
                @if (! empty($deal['saveYear']))
                    — you could save about <strong class="text-brillia-ink">£{{ number_format((int) $deal['saveYear']) }}/year</strong>
                @endif
                . We’ll send you through securely in
                <span class="font-semibold text-brillia-ink" x-text="seconds"></span>s.
            </p>

            <div class="mt-6 flex items-center justify-center gap-4 rounded-2xl bg-[#f7f7f4] px-4 py-4">
                <img
                    src="{{ $deal['logo'] }}"
                    alt="{{ $deal['logoAlt'] }}"
                    class="h-10 w-auto max-w-[8rem] object-contain"
                >
                <div class="text-left">
                    <p class="text-sm font-bold text-brillia-ink">{{ $deal['plan'] }}</p>
                    <p class="text-xs text-brillia-muted">{{ $deal['logoAlt'] }}</p>
                </div>
            </div>

            <a
                href="{{ $destination }}"
                class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-full bg-brillia-black py-3.5 text-sm font-bold text-white transition hover:bg-neutral-800"
            >
                Continue now
                <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                    <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>

            <a
                href="{{ route('compare.deals') }}"
                class="mt-4 inline-block text-sm font-medium text-brillia-muted underline underline-offset-2 hover:text-brillia-ink"
            >
                Back to deals
            </a>
        </div>

        <p class="mt-6 max-w-sm text-xs text-brillia-muted">
            Brillia never charges you to switch. Your details are encrypted and only used to complete this application.
        </p>
    </main>
@endsection
