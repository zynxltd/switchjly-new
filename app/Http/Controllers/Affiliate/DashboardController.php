<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateClick;
use App\Models\AffiliatePayout;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $since = Carbon::now()->subDays(7);

        $clicks = AffiliateClick::query()->where('affiliate_id', $user->id)->count();
        $leads = Lead::query()->where('affiliate_id', $user->id)->count();
        $clicks7d = AffiliateClick::query()
            ->where('affiliate_id', $user->id)
            ->where('created_at', '>=', $since)
            ->count();
        $leads7d = Lead::query()
            ->where('affiliate_id', $user->id)
            ->where('created_at', '>=', $since)
            ->count();

        $estimated = round($leads * (float) $user->commission_rate, 2);
        $conversionRate = $clicks > 0 ? round(($leads / $clicks) * 100, 1) : 0.0;

        $recentClicks = AffiliateClick::query()
            ->where('affiliate_id', $user->id)
            ->latest()
            ->limit(8)
            ->get();

        $recentLeads = Lead::query()
            ->where('affiliate_id', $user->id)
            ->latest()
            ->limit(8)
            ->get();

        $payouts = AffiliatePayout::query()
            ->where('affiliate_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $paidTotal = (float) AffiliatePayout::query()
            ->where('affiliate_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount');

        return view('affiliate.dashboard', [
            'user' => $user,
            'clicks' => $clicks,
            'leads' => $leads,
            'clicks7d' => $clicks7d,
            'leads7d' => $leads7d,
            'estimated' => $estimated,
            'conversionRate' => $conversionRate,
            'paidTotal' => $paidTotal,
            'recentClicks' => $recentClicks,
            'recentLeads' => $recentLeads,
            'payouts' => $payouts,
            'referralUrl' => $user->referralUrl(),
        ]);
    }
}
