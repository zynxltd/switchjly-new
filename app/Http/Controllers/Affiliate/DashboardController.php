<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateClick;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $clicks = AffiliateClick::query()->where('affiliate_id', $user->id)->count();
        $leads = Lead::query()->where('affiliate_id', $user->id)->count();
        $estimated = round($leads * (float) $user->commission_rate, 2);

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

        return view('affiliate.dashboard', [
            'user' => $user,
            'clicks' => $clicks,
            'leads' => $leads,
            'estimated' => $estimated,
            'recentClicks' => $recentClicks,
            'recentLeads' => $recentLeads,
            'referralUrl' => $user->referralUrl(),
        ]);
    }
}
