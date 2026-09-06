@extends('layouts.admin')

@section('title', 'Affiliates')
@section('heading', 'Affiliates')

@section('content')
    <div class="overflow-hidden rounded-[1.25rem] bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#fafafa] text-xs uppercase tracking-wide text-switchly-muted">
                    <tr>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Referral code</th>
                        <th class="px-5 py-3 font-medium">Rate</th>
                        <th class="px-5 py-3 font-medium">Clicks</th>
                        <th class="px-5 py-3 font-medium">Leads</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($affiliates as $affiliate)
                        <tr class="border-t border-switchly-border">
                            <td class="px-5 py-3 font-medium">{{ $affiliate->name }}</td>
                            <td class="px-5 py-3 text-switchly-muted">{{ $affiliate->email }}</td>
                            <td class="px-5 py-3 font-mono text-xs">{{ $affiliate->referral_code }}</td>
                            <td class="px-5 py-3 text-switchly-muted">£{{ number_format((float) $affiliate->commission_rate, 2) }}</td>
                            <td class="px-5 py-3">{{ number_format($affiliate->affiliate_clicks_count) }}</td>
                            <td class="px-5 py-3">{{ number_format($affiliate->referred_leads_count) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-switchly-muted">No affiliates yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($affiliates->hasPages())
            <div class="border-t border-switchly-border px-5 py-4">{{ $affiliates->links() }}</div>
        @endif
    </div>
@endsection
