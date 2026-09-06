<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class BrevoService
{
    /**
     * Create or update a Brevo contact for the lead.
     *
     * @see https://developers.brevo.com/docs/synchronise-contact-lists
     */
    public function sync(Lead $lead): bool
    {
        $apiKey = config('services.brevo.key');
        $listId = config('services.brevo.list_id');

        if (blank($apiKey)) {
            $lead->forceFill([
                'esp_error' => 'Brevo API key not configured.',
            ])->save();

            return false;
        }

        try {
            $attributes = array_filter(
                $this->nameAttributes($lead->name),
                fn ($value) => filled($value),
            );

            $payload = [
                'email' => $lead->email,
                'updateEnabled' => true,
                'emailBlacklisted' => false,
            ];

            if ($attributes !== []) {
                $payload['attributes'] = $attributes;
            }

            if (filled($listId)) {
                $payload['listIds'] = [(int) $listId];
            }

            $response = Http::withHeaders([
                'api-key' => $apiKey,
                'accept' => 'application/json',
            ])
                ->acceptJson()
                ->asJson()
                ->connectTimeout(5)
                ->timeout(15)
                ->post('https://api.brevo.com/v3/contacts', $payload);

            if ($response->successful()) {
                $lead->forceFill([
                    'esp_synced_at' => now(),
                    'esp_error' => null,
                ])->save();

                return true;
            }

            $lead->forceFill([
                'esp_error' => $response->body(),
            ])->save();

            Log::warning('Brevo sync failed', [
                'lead_id' => $lead->id,
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ]);

            return false;
        } catch (Throwable $e) {
            $lead->forceFill([
                'esp_error' => $e->getMessage(),
            ])->save();

            Log::error('Brevo sync exception', [
                'lead_id' => $lead->id,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * @return array{FIRSTNAME?: string, LASTNAME?: string}
     */
    protected function nameAttributes(?string $name): array
    {
        if (blank($name)) {
            return [];
        }

        $parts = preg_split('/\s+/', trim($name), 2) ?: [];

        return array_filter([
            'FIRSTNAME' => $parts[0] ?? null,
            'LASTNAME' => $parts[1] ?? null,
        ], fn ($value) => filled($value));
    }
}
