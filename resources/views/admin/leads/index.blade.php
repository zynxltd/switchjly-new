@extends('layouts.admin')

@section('title', 'Leads')
@section('heading', 'Leads')

@section('content')
    <div class="overflow-hidden rounded-[1.25rem] bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)]">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#fafafa] text-xs uppercase tracking-wide text-switchly-muted">
                    <tr>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Postcode</th>
                        <th class="px-5 py-3 font-medium">Source</th>
                        <th class="px-5 py-3 font-medium">Affiliate</th>
                        <th class="px-5 py-3 font-medium">ESP</th>
                        <th class="px-5 py-3 font-medium">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leads as $lead)
                        <tr class="border-t border-switchly-border">
                            <td class="px-5 py-3 font-medium">{{ $lead->email }}</td>
                            <td class="px-5 py-3 text-switchly-muted">{{ $lead->name ?: '—' }}</td>
                            <td class="px-5 py-3 text-switchly-muted">{{ $lead->postcode ?: '—' }}</td>
                            <td class="px-5 py-3 text-switchly-muted">{{ $lead->source }}</td>
                            <td class="px-5 py-3 text-switchly-muted">
                                @if ($lead->affiliate)
                                    {{ $lead->affiliate->name }}
                                    <span class="text-xs">({{ $lead->referral_code }})</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-5 py-3 text-switchly-muted">
                                {{ $lead->esp_synced_at ? 'Synced' : ($lead->esp_error ? 'Error' : '—') }}
                            </td>
                            <td class="px-5 py-3 text-switchly-muted">{{ $lead->created_at?->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-switchly-muted">No leads yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($leads->hasPages())
            <div class="border-t border-switchly-border px-5 py-4">{{ $leads->links() }}</div>
        @endif
    </div>
@endsection
