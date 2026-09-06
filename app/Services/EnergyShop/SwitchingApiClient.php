<?php

namespace App\Services\EnergyShop;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class SwitchingApiClient
{
    public function configured(): bool
    {
        return filled(config('services.energy_shop.api_key'))
            && filled(config('services.energy_shop.switching_base_url'));
    }

    /**
     * Request live switch quotes/deals for a household comparison payload.
     *
     * @param  array<string, mixed>  $payload
     * @return array{deals: list<array<string, mixed>>, savings: int|float|null, deal_count: int, raw: mixed}|null
     */
    public function quote(array $payload): ?array
    {
        if (! $this->configured()) {
            return null;
        }

        try {
            $response = $this->client()
                ->post($this->url('/quotes'), $payload);

            if (! $response->successful()) {
                Log::warning('Energy Shop Switching API quote failed', [
                    'status' => $response->status(),
                    'body' => $response->json() ?? $response->body(),
                ]);

                return null;
            }

            $data = $response->json() ?? [];
            $deals = $data['deals'] ?? $data['tariffs'] ?? $data['results'] ?? [];

            if (! is_array($deals)) {
                $deals = [];
            }

            return [
                'deals' => array_values($deals),
                'savings' => $data['savings'] ?? $data['max_savings'] ?? null,
                'deal_count' => (int) ($data['deal_count'] ?? count($deals)),
                'raw' => $data,
            ];
        } catch (Throwable $e) {
            Log::error('Energy Shop Switching API quote exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Submit a switch application once the customer picks a deal.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>|null
     */
    public function switch(array $payload): ?array
    {
        if (! $this->configured()) {
            return null;
        }

        try {
            $response = $this->client()
                ->post($this->url('/switches'), $payload);

            if (! $response->successful()) {
                Log::warning('Energy Shop Switching API switch failed', [
                    'status' => $response->status(),
                    'body' => $response->json() ?? $response->body(),
                ]);

                return null;
            }

            return $response->json();
        } catch (Throwable $e) {
            Log::error('Energy Shop Switching API switch exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    protected function client(): PendingRequest
    {
        return Http::baseUrl(rtrim((string) config('services.energy_shop.switching_base_url'), '/'))
            ->acceptJson()
            ->asJson()
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
