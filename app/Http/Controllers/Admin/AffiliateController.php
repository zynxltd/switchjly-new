<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliatePayout;
use App\Models\User;
use Illuminate\View\View;

class AffiliateController extends Controller
{
    public function index(): View
    {
        $affiliates = User::query()
            ->where('role', User::ROLE_AFFILIATE)
            ->withCount(['affiliateClicks', 'referredLeads'])
            ->orderBy('name')
            ->paginate(25);

        return view('admin.affiliates.index', compact('affiliates'));
    }

    public function payouts(): View
    {
        $payouts = AffiliatePayout::query()
            ->with('affiliate:id,name,email')
            ->latest()
            ->paginate(25);

        return view('admin.payouts.index', compact('payouts'));
    }
}
