@extends('layouts.affiliate')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Welcome back, {{ $user->name }}</h1>
        <p class="mt-1 text-sm text-switchly-muted">Share your link and track performance in real time.</p>
    </div>

    <div
        class="rounded-[1.25rem] bg-switchly-black p-6 text-white sm:p-7"
        x-data="{ copied: false }"
    >
        <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-switchly-lime">Your referral link</p>
        <p class="mt-2 break-all font-mono text-sm text-white/90">{{ $referralUrl }}</p>
        <div class="mt-4 flex flex-wrap gap-3">
            <button
                type="button"
                class="inline-flex items-center rounded-full bg-switchly-lime px-5 py-2.5 text-sm font-bold text-switchly-ink hover:brightness-95"
                @click="navigator.clipboard.writeText(@js($referralUrl)); copied = true; setTimeout(() => copied = false, 2000)"
            >
                <span x-text="copied ? 'Copied!' : 'Copy link'"></span>
            </button>
            <span class="inline-flex items-center text-sm text-white/55">Code: <strong class="ml-1 text-white">{{ $user->referral_code }}</strong></span>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <p class="text-xs text-switchly-muted">Clicks</p>
            <p class="mt-2 text-2xl font-extrabold">{{ number_format($clicks) }}</p>
        </div>
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <p class="text-xs text-switchly-muted">Referred leads</p>
            <p class="mt-2 text-2xl font-extrabold">{{ number_format($leads) }}</p>
        </div>
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <p class="text-xs text-switchly-muted">Est. earnings (£{{ number_format((float) $user->commission_rate, 0) }}/lead)</p>
            <p class="mt-2 text-2xl font-extrabold">£{{ number_format($estimated, 2) }}</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6">
            <h2 class="text-base font-bold">Recent clicks</h2>
            <ul class="mt-4 divide-y divide-switchly-border">
                @forelse ($recentClicks as $click)
                    <li class="flex items-center justify-between gap-3 py-3 text-sm">
                        <span class="truncate text-switchly-muted">{{ $click->landing_path }}</span>
                        <span class="shrink-0 text-xs text-switchly-muted">{{ $click->created_at?->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="py-6 text-sm text-switchly-muted">No clicks yet. Share your link to get started.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6">
            <h2 class="text-base font-bold">Recent leads</h2>
            <ul class="mt-4 divide-y divide-switchly-border">
                @forelse ($recentLeads as $lead)
                    <li class="flex items-center justify-between gap-3 py-3 text-sm">
                        <span class="truncate font-medium">{{ \Illuminate\Support\Str::mask($lead->email, '*', 2, max(0, strlen($lead->email) - 6)) }}</span>
                        <span class="shrink-0 text-xs text-switchly-muted">{{ $lead->created_at?->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="py-6 text-sm text-switchly-muted">No referred leads yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
