<?php

namespace App\Http\Controllers;

use App\Rules\UkPostcode;
use App\Services\CrmService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request, CrmService $crm): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => [
                $request->input('source') === 'chat' ? 'required' : 'nullable',
                'string',
                'max:120',
            ],
            'postcode' => ['nullable', 'string', 'max:8', new UkPostcode],
            'source' => ['nullable', 'string', 'max:40'],
        ]);

        $result = $crm->capture([
            'email' => $validated['email'],
            'name' => $validated['name'] ?? null,
            'postcode' => $validated['postcode'] ?? null,
            'source' => $validated['source'] ?? 'popup',
        ], $request);

        return response()->json([
            'ok' => true,
            'synced' => $result['synced'],
            'crm' => true,
            'message' => $result['synced']
                ? 'Thanks — you’re on our list.'
                : 'Thanks — we’ve saved your details.',
        ]);
    }
}
