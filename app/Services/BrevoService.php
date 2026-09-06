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
        $result = $this->pushContact($lead->email, $lead->name);

        try {
            if ($result['ok']) {
                $lead->forceFill([
                    'esp_synced_at' => now(),
                    'esp_error' => null,
                ])->save();

                return true;
            }

            $lead->forceFill([
                'esp_error' => $result['error'] ?? 'Brevo sync failed.',
            ])->save();
        } catch (Throwable $e) {
            Log::warning('Brevo lead status update skipped.', [
                'lead_id' => $lead->id,
                'message' => $e->getMessage(),
            ]);
        }

        return false;
    }

    /**
     * Create or update a Brevo contact by email (no local DB required).
     */
    public function syncContact(string $email, ?string $name = null): bool
    {
        return $this->pushContact($email, $name)['ok'];
    }

    /**
     * @return array{ok: bool, error: string|null}
     */
    protected function pushContact(string $email, ?string $name = null): array
    {
        $apiKey = config('services.brevo.key');
        $listId = config('services.brevo.list_id');

        if (blank($apiKey)) {
            return [
                'ok' => false,
                'error' => 'Brevo API key not configured.',
            ];
        }

        try {
            $attributes = array_filter(
                $this->nameAttributes($name),
                fn ($value) => filled($value),
            );

            $payload = [
                'email' => $email,
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
                return [
                    'ok' => true,
                    'error' => null,
                ];
            }

            Log::warning('Brevo sync failed', [
                'email' => $email,
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ]);

            return [
                'ok' => false,
                'error' => $response->body(),
            ];
        } catch (Throwable $e) {
            Log::error('Brevo sync exception', [
                'email' => $email,
                'message' => $e->getMessage(),
            ]);

            return [
                'ok' => false,
                'error' => $e->getMessage(),
            ];
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
