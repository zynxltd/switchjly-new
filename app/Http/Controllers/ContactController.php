<?php

namespace App\Http\Controllers;

use App\Support\AffiliateAttribution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $attribution = AffiliateAttribution::fromRequest($request);

        \App\Models\Lead::query()->create([
            'email' => $request->string('email')->toString(),
            'name' => $request->string('name')->toString(),
            'source' => 'contact',
            'affiliate_id' => $attribution['affiliate_id'],
            'referral_code' => $attribution['referral_code'],
            'meta' => [
                'subject' => $request->string('subject')->toString(),
                'message' => $request->string('message')->toString(),
            ],
        ]);

        return redirect()
            ->route('contact')
            ->with('status', 'Thanks — we’ve received your message and will get back to you soon.');
    }
}
