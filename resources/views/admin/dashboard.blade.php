@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Total leads', 'value' => number_format($leadCount)],
            ['label' => 'Leads (7 days)', 'value' => number_format($leadWeek)],
            ['label' => 'Affiliates', 'value' => number_format($affiliateCount)],
            ['label' => 'Referral clicks', 'value' => number_format($clickCount)],
        ] as $stat)
            <div class="rounded-[1.25rem] bg-white p-5 shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
                <p class="text-xs font-medium text-brillia-muted">{{ $stat['label'] }}</p>
                <p class="mt-2 text-2xl font-extrabold tracking-tight">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-4 rounded-[1.25rem] bg-brillia-black p-5 text-white sm:p-6">
        <p class="text-[0.6875rem] font-bold uppercase tracking-[0.14em] text-brillia-lime">Payouts</p>
        <p class="mt-2 text-sm text-white/65">Pending payout total</p>
        <p class="mt-1 text-3xl font-extrabold">£{{ number_format((float) $pendingPayouts, 2) }}</p>
    </div>

    <div class="mt-8 overflow-hidden rounded-[1.25rem] bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
        <div class="flex items-center justify-between border-b border-brillia-border px-5 py-4">
            <h2 class="text-base font-bold">Recent leads</h2>
            <a href="{{ route('admin.leads') }}" class="text-sm font-semibold text-brillia-ink hover:text-brillia-lime">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#fafafa] text-xs uppercase tracking-wide text-brillia-muted">
                    <tr>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Source</th>
                        <th class="px-5 py-3 font-medium">Postcode</th>
                        <th class="px-5 py-3 font-medium">When</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentLeads as $lead)
                        <tr class="border-t border-brillia-border">
                            <td class="px-5 py-3 font-medium">{{ $lead->email }}</td>
                            <td class="px-5 py-3 text-brillia-muted">{{ $lead->source }}</td>
                            <td class="px-5 py-3 text-brillia-muted">{{ $lead->postcode ?: '—' }}</td>
                            <td class="px-5 py-3 text-brillia-muted">{{ $lead->created_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-brillia-muted">No leads yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
