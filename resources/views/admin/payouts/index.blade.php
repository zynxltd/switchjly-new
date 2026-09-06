@extends('layouts.admin')

@section('title', 'Payouts')
@section('heading', 'Payouts')

@section('content')
    <p class="mb-4 text-sm text-brillia-muted">Placeholder list for affiliate payout approvals. Wire approvals once commission rules are final.</p>

    <div class="overflow-hidden rounded-[1.25rem] bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#fafafa] text-xs uppercase tracking-wide text-brillia-muted">
                    <tr>
                        <th class="px-5 py-3 font-medium">Affiliate</th>
                        <th class="px-5 py-3 font-medium">Amount</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Notes</th>
                        <th class="px-5 py-3 font-medium">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payouts as $payout)
                        <tr class="border-t border-brillia-border">
                            <td class="px-5 py-3 font-medium">{{ $payout->affiliate?->name ?? '—' }}</td>
                            <td class="px-5 py-3">£{{ number_format((float) $payout->amount, 2) }}</td>
                            <td class="px-5 py-3 capitalize text-brillia-muted">{{ $payout->status }}</td>
                            <td class="px-5 py-3 text-brillia-muted">{{ $payout->notes ?: '—' }}</td>
                            <td class="px-5 py-3 text-brillia-muted">{{ $payout->created_at?->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-brillia-muted">No payout records yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($payouts->hasPages())
            <div class="border-t border-brillia-border px-5 py-4">{{ $payouts->links() }}</div>
        @endif
    </div>
@endsection
