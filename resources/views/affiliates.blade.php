@extends('layouts.app')

@section('title', 'Affiliate programme — Partner with Switchly')
@section('meta_description', 'Earn commission promoting free UK energy comparisons with Switchly. Get a unique referral link, real-time tracking, and transparent payouts.')
@section('canonical', route('affiliates'))

@section('content')
    <section class="bg-[#f3f3f3] py-14 sm:py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime sm:text-xs">
                    Affiliates
                </p>
                <h1 class="mt-3 text-[1.875rem] font-extrabold tracking-tight text-switchly-ink sm:text-4xl">
                    Partner with Switchly
                </h1>
                <p class="mt-3 text-sm text-switchly-muted sm:text-base">
                    Share free UK energy comparisons with your audience and earn when they switch — with a unique link and a live partner portal.
                </p>
            </div>

            <div class="mx-auto mt-12 grid max-w-5xl gap-4 sm:grid-cols-3 sm:gap-5">
                @foreach ([
                    ['title' => 'Unique referral link', 'body' => 'Share your ?ref= code across your site, email, or socials. We track clicks automatically.'],
                    ['title' => 'Transparent earnings', 'body' => 'See referred leads and estimated commission in your affiliate dashboard in real time.'],
                    ['title' => 'Simple payouts', 'body' => 'Approved conversions are paid out on a clear schedule — no guesswork.'],
                ] as $card)
                    <article class="rounded-[1.25rem] bg-white p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-7">
                        <h2 class="text-base font-bold tracking-tight text-switchly-ink sm:text-lg">{{ $card['title'] }}</h2>
                        <p class="mt-2 text-sm leading-relaxed text-switchly-muted">{{ $card['body'] }}</p>
                    </article>
                @endforeach
            </div>

            <ol class="mx-auto mt-12 grid max-w-5xl gap-5 sm:grid-cols-3 sm:gap-6">
                @foreach ([
                    ['n' => '1', 'title' => 'Apply to join', 'body' => 'Tell us about your audience via our contact form. We’ll set up your affiliate account.'],
                    ['n' => '2', 'title' => 'Share your link', 'body' => 'Copy your referral URL from the portal and promote Switchly wherever your audience is.'],
                    ['n' => '3', 'title' => 'Track & earn', 'body' => 'Watch clicks and leads come in. Commission is based on successful referred conversions.'],
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

            <div class="mx-auto mt-12 grid max-w-5xl gap-4 sm:mt-16 sm:grid-cols-2 sm:gap-5">
                <div class="rounded-[1.5rem] bg-switchly-black px-6 py-9 text-center sm:px-8 sm:py-10 sm:text-left">
                    <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">New partners</p>
                    <h2 class="mt-3 text-xl font-extrabold tracking-tight text-white sm:text-2xl">
                        Want to join the programme?
                    </h2>
                    <p class="mt-2 text-sm text-white/65">
                        Get in touch and we’ll create your affiliate login and referral code.
                    </p>
                    <a
                        href="{{ route('contact') }}"
                        class="mt-6 inline-flex items-center gap-2.5 rounded-full bg-switchly-lime py-3 pl-6 pr-2.5 text-sm font-bold text-switchly-ink transition hover:brightness-95"
                    >
                        Apply via contact
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-switchly-black text-white">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>

                <div class="rounded-[1.5rem] bg-white px-6 py-9 text-center shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:px-8 sm:py-10 sm:text-left">
                    <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">Existing partners</p>
                    <h2 class="mt-3 text-xl font-extrabold tracking-tight text-switchly-ink sm:text-2xl">
                        Already have an account?
                    </h2>
                    <p class="mt-2 text-sm text-switchly-muted">
                        Sign in to copy your link, check clicks, and review referred leads.
                    </p>
                    <a
                        href="{{ route('affiliate.login') }}"
                        class="mt-6 inline-flex items-center gap-2.5 rounded-full bg-switchly-black py-3 pl-6 pr-2.5 text-sm font-semibold text-white transition hover:bg-neutral-800"
                    >
                        Partner login
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-switchly-lime text-switchly-black">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                                <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
