@extends('layouts.app')

@section('title', 'How Switchly works — Compare and switch in 3 steps')
@section('meta_description', 'See how Switchly works: enter a few details, compare live UK energy deals, and switch with confidence — usually in under a minute to find your options.')
@section('canonical', route('how-it-works'))

@section('content')
    <section class="bg-[#f3f3f3] py-14 sm:py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime sm:text-xs">
                    How it works
                </p>
                <h1 class="mt-3 text-[1.875rem] font-extrabold tracking-tight text-switchly-ink sm:text-4xl">
                    Switch in three simple steps
                </h1>
                <p class="mt-3 text-sm text-switchly-muted sm:text-base">
                    Compare live UK energy deals and switch when you’re ready — usually in under a minute to find your options.
                </p>
            </div>

            <ol class="mx-auto mt-12 grid max-w-5xl gap-5 sm:grid-cols-3 sm:gap-6">
                @foreach ([
                    ['n' => '1', 'title' => 'Tell us about your home', 'body' => 'Enter your postcode, current supplier and a rough usage estimate. An estimate is fine.'],
                    ['n' => '2', 'title' => 'Compare live deals', 'body' => 'We show matching tariffs from leading UK suppliers, ranked so you can spot real savings fast.'],
                    ['n' => '3', 'title' => 'Switch with confidence', 'body' => 'Pick a deal you like. Your new supplier handles the rest — supply isn’t interrupted.'],
                ] as $step)
                    <li class="rounded-[1.25rem] bg-white p-7 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-8">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-switchly-lime text-base font-extrabold text-switchly-ink">
                            {{ $step['n'] }}
                        </span>
                        <h2 class="mt-5 text-lg font-bold tracking-tight text-switchly-ink">{{ $step['title'] }}</h2>
                        <p class="mt-2 text-sm leading-relaxed text-switchly-muted">{{ $step['body'] }}</p>
                    </li>
                @endforeach
            </ol>

            <div class="mx-auto mt-12 max-w-5xl overflow-hidden rounded-[1.5rem] bg-switchly-black px-6 py-10 text-center sm:mt-16 sm:px-10 sm:py-12">
                <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">Ready to save?</p>
                <h2 class="mt-3 text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                    Start your free comparison
                </h2>
                <p class="mx-auto mt-2 max-w-md text-sm text-white/65">
                    No sign-up required — see deals matched to your home in under a minute.
                </p>
                <a
                    href="{{ route('compare.details') }}"
                    class="mt-6 inline-flex items-center gap-2.5 rounded-full bg-switchly-lime py-3 pl-6 pr-2.5 text-sm font-bold text-switchly-ink transition hover:brightness-95"
                >
                    Start comparing
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-switchly-black text-white">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>
@endsection
