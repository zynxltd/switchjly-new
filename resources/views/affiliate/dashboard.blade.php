@extends('layouts.affiliate')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Welcome back, {{ $user->name }}</h1>
            <p class="mt-1 text-sm text-brillia-muted">Track performance, copy your link, and grab marketing creatives.</p>
        </div>
        <a
            href="{{ route('affiliate.creatives') }}"
            class="inline-flex items-center justify-center gap-2 rounded-full bg-brillia-lime px-5 py-2.5 text-sm font-bold text-brillia-ink hover:brightness-95"
        >
            Marketing creatives
            <svg class="h-3.5 w-3.5" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                <path d="M2.5 7h9M7.5 3.5 11 7l-3.5 3.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>

    <div
        class="rounded-[1.25rem] bg-brillia-black p-6 text-white sm:p-7"
        x-data="{ copied: false }"
    >
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="min-w-0 flex-1">
                <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Your referral link</p>
                <p class="mt-2 break-all font-mono text-sm text-white/90">{{ $referralUrl }}</p>
                <p class="mt-3 text-sm text-white/55">
                    Code: <strong class="text-white">{{ $user->referral_code }}</strong>
                    <span class="mx-2 text-white/25">·</span>
                    £{{ number_format((float) $user->commission_rate, 0) }} per referred lead
                </p>
            </div>
            <button
                type="button"
                class="inline-flex shrink-0 items-center rounded-full bg-brillia-lime px-5 py-2.5 text-sm font-bold text-brillia-ink hover:brightness-95"
                @click="navigator.clipboard.writeText(@js($referralUrl)); copied = true; setTimeout(() => copied = false, 2000)"
            >
                <span x-text="copied ? 'Copied!' : 'Copy link'"></span>
            </button>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <p class="text-xs text-brillia-muted">Clicks</p>
            <p class="mt-2 text-2xl font-extrabold">{{ number_format($clicks) }}</p>
            <p class="mt-1 text-xs text-brillia-muted">{{ number_format($clicks7d) }} in last 7 days</p>
        </div>
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <p class="text-xs text-brillia-muted">Referred leads</p>
            <p class="mt-2 text-2xl font-extrabold">{{ number_format($leads) }}</p>
            <p class="mt-1 text-xs text-brillia-muted">{{ number_format($leads7d) }} in last 7 days</p>
        </div>
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <p class="text-xs text-brillia-muted">Conversion rate</p>
            <p class="mt-2 text-2xl font-extrabold">{{ number_format($conversionRate, 1) }}%</p>
            <p class="mt-1 text-xs text-brillia-muted">Leads ÷ clicks</p>
        </div>
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
            <p class="text-xs text-brillia-muted">Est. earnings</p>
            <p class="mt-2 text-2xl font-extrabold">£{{ number_format($estimated, 2) }}</p>
            <p class="mt-1 text-xs text-brillia-muted">£{{ number_format($paidTotal, 2) }} paid to date</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6">
            <h2 class="text-base font-bold">Recent clicks</h2>
            <ul class="mt-4 divide-y divide-brillia-border">
                @forelse ($recentClicks as $click)
                    <li class="flex items-center justify-between gap-3 py-3 text-sm">
                        <span class="truncate text-brillia-muted">{{ $click->landing_path }}</span>
                        <span class="shrink-0 text-xs text-brillia-muted">{{ $click->created_at?->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="py-6 text-sm text-brillia-muted">
                        No clicks yet.
                        <a href="{{ route('affiliate.creatives') }}" class="font-semibold text-brillia-ink underline decoration-brillia-lime underline-offset-2">Grab creatives</a>
                        and share your link.
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6">
            <h2 class="text-base font-bold">Recent leads</h2>
            <ul class="mt-4 divide-y divide-brillia-border">
                @forelse ($recentLeads as $lead)
                    <li class="flex items-center justify-between gap-3 py-3 text-sm">
                        <div class="min-w-0">
                            <p class="truncate font-medium">{{ \Illuminate\Support\Str::mask($lead->email, '*', 2, max(0, strlen($lead->email) - 6)) }}</p>
                            <p class="text-xs text-brillia-muted">{{ $lead->source ?: 'lead' }}</p>
                        </div>
                        <span class="shrink-0 text-xs text-brillia-muted">{{ $lead->created_at?->diffForHumans() }}</span>
                    </li>
                @empty
                    <li class="py-6 text-sm text-brillia-muted">No referred leads yet. Attribution sticks for 30 days via cookie.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="mt-8 rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)] sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-base font-bold">Payouts</h2>
            <p class="text-xs text-brillia-muted">Paid once commission rules are confirmed by Brillia.</p>
        </div>
        <ul class="mt-4 divide-y divide-brillia-border">
            @forelse ($payouts as $payout)
                <li class="flex items-center justify-between gap-3 py-3 text-sm">
                    <div>
                        <p class="font-medium">£{{ number_format((float) $payout->amount, 2) }}</p>
                        <p class="text-xs text-brillia-muted">{{ $payout->notes ?: 'Commission payout' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $payout->status === 'paid' ? 'bg-[#eaf8c4] text-brillia-ink' : 'bg-neutral-100 text-brillia-muted' }}">
                            {{ ucfirst($payout->status) }}
                        </span>
                        <p class="mt-1 text-xs text-brillia-muted">{{ $payout->created_at?->format('j M Y') }}</p>
                    </div>
                </li>
            @empty
                <li class="py-6 text-sm text-brillia-muted">No payouts yet. Earnings appear here once approved.</li>
            @endforelse
        </ul>
    </div>
@endsection
