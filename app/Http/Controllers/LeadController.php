<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\MailerLiteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request, MailerLiteService $mailerLite): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:120'],
            'postcode' => ['nullable', 'string', 'max:16'],
            'source' => ['nullable', 'string', 'max:40'],
        ]);

        $lead = Lead::query()->updateOrCreate(
            ['email' => strtolower($validated['email'])],
            [
                'name' => $validated['name'] ?? null,
                'postcode' => isset($validated['postcode'])
                    ? strtoupper(preg_replace('/\s+/', ' ', trim($validated['postcode'])))
                    : null,
                'source' => $validated['source'] ?? 'popup',
                'meta' => [
                    'ip' => $request->ip(),
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                    'referer' => $request->headers->get('referer'),
                ],
            ],
        );

        $synced = $mailerLite->sync($lead);

        return response()->json([
            'ok' => true,
            'synced' => $synced,
            'message' => $synced
                ? 'Thanks — check your inbox for deals.'
                : 'Thanks — you’re on the list.',
        ]);
    }
}
