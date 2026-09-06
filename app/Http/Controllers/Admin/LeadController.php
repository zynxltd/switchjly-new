<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(): View
    {
        $leads = Lead::query()
            ->with('affiliate:id,name,email,referral_code')
            ->latest()
            ->paginate(25);

        return view('admin.leads.index', compact('leads'));
    }
}
