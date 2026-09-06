<?php

namespace App\Services;

use App\Models\Lead;
use App\Rules\UkPostcode;
use App\Support\AffiliateAttribution;
use Illuminate\Http\Request;

class CrmService
{
    public function __construct(
        protected BrevoService $brevo,
    ) {}

    /**
     * Store (or update) a marketing contact in the CRM and sync to Brevo.
     *
     * @param  array{
     *     email: string,
     *     name?: string|null,
     *     postcode?: string|null,
     *     source?: string|null,
     *     affiliate_id?: int|null,
     *     referral_code?: string|null,
     *     meta?: array<string, mixed>|null
     * }  $data
     * @return array{lead: Lead, synced: bool}
     */
    public function capture(array $data, ?Request $request = null): array
    {
        $email = strtolower(trim($data['email']));
        $attribution = $request
            ? AffiliateAttribution::fromRequest($request)
            : ['affiliate_id' => null, 'referral_code' => null];

        $postcode = $data['postcode'] ?? null;
        if (filled($postcode)) {
            $postcode = UkPostcode::normalize((string) $postcode);
        } else {
            $postcode = null;
        }

        $meta = array_filter([
            ...($data['meta'] ?? []),
            'ip' => $request?->ip(),
            'user_agent' => $request ? substr((string) $request->userAgent(), 0, 500) : null,
            'referer' => $request?->headers->get('referer'),
        ], fn ($value) => $value !== null && $value !== '');

        $existing = Lead::query()->where('email', $email)->first();
        $mergedMeta = array_merge($existing?->meta ?? [], $meta);

        $lead = Lead::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => filled($data['name'] ?? null) ? trim((string) $data['name']) : ($existing?->name),
                'postcode' => $postcode ?? $existing?->postcode,
                'source' => $data['source'] ?? $existing?->source ?? 'crm',
                'affiliate_id' => $data['affiliate_id'] ?? $attribution['affiliate_id'] ?? $existing?->affiliate_id,
                'referral_code' => $data['referral_code'] ?? $attribution['referral_code'] ?? $existing?->referral_code,
                'meta' => $mergedMeta !== [] ? $mergedMeta : null,
            ],
        );

        $synced = $this->brevo->sync($lead);

        return [
            'lead' => $lead->fresh(),
            'synced' => $synced,
        ];
    }
}
