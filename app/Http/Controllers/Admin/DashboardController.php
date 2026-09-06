<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateClick;
use App\Models\AffiliatePayout;
use App\Models\Lead;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'leadCount' => Lead::query()->count(),
            'leadWeek' => Lead::query()->where('created_at', '>=', now()->subDays(7))->count(),
            'affiliateCount' => User::query()->where('role', User::ROLE_AFFILIATE)->count(),
            'clickCount' => AffiliateClick::query()->count(),
            'pendingPayouts' => AffiliatePayout::query()->where('status', 'pending')->sum('amount'),
            'recentLeads' => Lead::query()->latest()->limit(5)->get(),
        ]);
    }
}
