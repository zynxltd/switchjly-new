<?php

namespace App\Http\Controllers;

use App\Services\CrmService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function store(Request $request, CrmService $crm): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $crm->capture([
            'email' => $validated['email'],
            'name' => $validated['name'],
            'source' => 'contact',
            'meta' => [
                'subject' => $validated['subject'],
                'message' => $validated['message'],
            ],
        ], $request);

        return redirect()
            ->route('contact')
            ->with('status', 'Thanks — we’ve received your message and will get back to you soon.');
    }
}
