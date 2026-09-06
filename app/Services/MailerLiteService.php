<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MailerLiteService
{
    public function sync(Lead $lead): bool
    {
        $token = config('services.mailerlite.key');
        $groupId = config('services.mailerlite.group_id');

        if (blank($token)) {
            $lead->forceFill([
                'esp_error' => 'MailerLite API key not configured.',
            ])->save();

            return false;
        }

        try {
            $payload = [
                'email' => $lead->email,
                'status' => 'active',
                'fields' => array_filter([
                    'name' => $lead->name,
                    'postcode' => $lead->postcode,
                    'source' => $lead->source,
                ]),
            ];

            if (filled($groupId)) {
                $payload['groups'] = [(string) $groupId];
            }

            $response = Http::withToken($token)
                ->acceptJson()
                ->timeout(15)
                ->post('https://connect.mailerlite.com/api/subscribers', $payload);

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

            Log::warning('MailerLite sync failed', [
                'lead_id' => $lead->id,
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ]);

            return false;
        } catch (Throwable $e) {
            $lead->forceFill([
                'esp_error' => $e->getMessage(),
            ])->save();

            Log::error('MailerLite sync exception', [
                'lead_id' => $lead->id,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
