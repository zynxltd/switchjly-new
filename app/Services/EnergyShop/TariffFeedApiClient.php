<?php

namespace App\Services\EnergyShop;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class TariffFeedApiClient
{
    public function configured(): bool
    {
        return filled(config('services.energy_shop.api_key'))
            && filled(config('services.energy_shop.tariff_feed_base_url'));
    }

    /**
     * Fetch domestic tariff data filtered by region, payment method, meter type, etc.
     *
     * @param  array<string, mixed>  $filters
     * @return list<array<string, mixed>>
     */
    public function tariffs(array $filters = []): array
    {
        if (! $this->configured()) {
            return [];
        }

        try {
            $response = $this->client()
                ->get($this->url('/tariffs'), $filters);

            if (! $response->successful()) {
                Log::warning('Energy Shop Tariff Feed API failed', [
                    'status' => $response->status(),
                    'body' => $response->json() ?? $response->body(),
                ]);

                return [];
            }

            $data = $response->json() ?? [];
            $tariffs = $data['tariffs'] ?? $data['data'] ?? $data;

            return is_array($tariffs) ? array_values($tariffs) : [];
        } catch (Throwable $e) {
            Log::error('Energy Shop Tariff Feed API exception', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }

    protected function client(): PendingRequest
    {
        return Http::baseUrl(rtrim((string) config('services.energy_shop.tariff_feed_base_url'), '/'))
            ->acceptJson()
            ->timeout((int) config('services.energy_shop.timeout', 20))
            ->withToken((string) config('services.energy_shop.api_key'))
            ->withHeaders([
                'X-Api-Key' => (string) config('services.energy_shop.api_key'),
            ]);
    }

    protected function url(string $path): string
    {
        return '/'.ltrim($path, '/');
    }
}
