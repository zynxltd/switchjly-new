<?php

namespace App\Http\Controllers;

use App\Services\EnergyShop\SwitchingApiClient;
use App\Support\AffiliateAttribution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompareController extends Controller
{
    public function details(Request $request): View
    {
        return view('compare.details', [
            'step' => 1,
            'postcode' => $request->session()->get('compare.postcode', $request->query('postcode', '')),
            'supplier' => $request->session()->get('compare.supplier', ''),
            'tariff' => $request->session()->get('compare.tariff', ''),
        ]);
    }

    public function storeDetails(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'postcode' => ['required', 'string', 'max:12'],
            'supplier' => ['required', 'string', 'max:100'],
            'tariff' => ['required', 'string', 'max:100'],
        ]);

        $attribution = AffiliateAttribution::fromRequest($request);

        $request->session()->put('compare', array_merge(
            $request->session()->get('compare', []),
            $data,
            [
                'affiliate_id' => $attribution['affiliate_id'],
                'referral_code' => $attribution['referral_code'],
            ],
        ));

        return redirect()->route('compare.usage');
    }

    public function usage(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('compare.postcode')) {
            return redirect()->route('compare.details');
        }

        return view('compare.usage', [
            'step' => 2,
            'usage' => $request->session()->get('compare.usage', '3100'),
            'fuel' => $request->session()->get('compare.fuel', 'dual'),
            'payment' => $request->session()->get('compare.payment', 'direct_debit'),
        ]);
    }

    public function storeUsage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'usage' => ['required', 'string', 'max:20'],
            'fuel' => ['required', 'string', 'max:40'],
            'payment' => ['required', 'string', 'max:40'],
        ]);

        $request->session()->put('compare', array_merge(
            $request->session()->get('compare', []),
            $data,
        ));

        return redirect()->route('compare.deals');
    }

    public function deals(Request $request, SwitchingApiClient $switching): View|RedirectResponse
    {
        $compare = $request->session()->get('compare');

        if (! $compare || empty($compare['postcode'])) {
            return redirect()->route('compare.details');
        }

        $apiResult = $switching->quote([
            'postcode' => $compare['postcode'] ?? null,
            'supplier' => $compare['supplier'] ?? null,
            'tariff' => $compare['tariff'] ?? null,
            'usage' => $compare['usage'] ?? null,
            'fuel' => $compare['fuel'] ?? null,
            'payment' => $compare['payment'] ?? null,
            'referral_code' => $compare['referral_code'] ?? null,
        ]);

        $demoDeals = $this->demoDeals();
        $deals = $demoDeals;
        $dealCount = 24;
        $savings = 312;
        $usingLiveApi = false;

        if ($apiResult !== null && $apiResult['deals'] !== []) {
            $mapped = $this->mapApiDeals($apiResult['deals']);
            if ($mapped !== []) {
                $deals = $mapped;
                $dealCount = $apiResult['deal_count'] ?: count($mapped);
                $savings = (int) ($apiResult['savings'] ?? ($mapped[0]['saveYear'] ?? 0));
                $usingLiveApi = true;
            }
        }

        return view('compare.deals', [
            'step' => 3,
            'compare' => $compare,
            'dealCount' => $dealCount,
            'savings' => $savings,
            'deals' => $deals,
            'usingLiveApi' => $usingLiveApi,
        ]);
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function demoDeals(): array
    {
        $features = [
            '12 month fixed',
            '100% renewable electricity',
            '£0 exit fees',
        ];

        return [
            [
                'logo' => asset('images/suppliers/octopus-color.png'),
                'logoAlt' => 'Octopus Energy',
                'plan' => 'Octopus Go',
                'badge' => 'Cheapest',
                'features' => $features,
                'saveYear' => 312,
                'saveMonth' => 26.00,
            ],
            [
                'logo' => asset('images/suppliers/scottishpower-color.png'),
                'logoAlt' => 'ScottishPower',
                'plan' => 'Secure Fixed 12',
                'badge' => null,
                'features' => $features,
                'saveYear' => 265,
                'saveMonth' => 22.08,
            ],
            [
                'logo' => asset('images/suppliers/eon-color.png'),
                'logoAlt' => 'E.ON',
                'plan' => 'Next Flex',
                'badge' => null,
                'features' => [
                    'No fixed term',
                    '100% renewable electricity',
                    '£0 exit fees',
                ],
                'saveYear' => 198,
                'saveMonth' => 16.50,
            ],
        ];
    }

    /**
     * Normalise Energy Shop payloads into deal-card shape when field names differ.
     *
     * @param  list<array<string, mixed>>  $rawDeals
     * @return list<array<string, mixed>>
     */
    protected function mapApiDeals(array $rawDeals): array
    {
        $mapped = [];

        foreach ($rawDeals as $index => $deal) {
            if (! is_array($deal)) {
                continue;
            }

            $saveYear = (float) ($deal['saveYear'] ?? $deal['annual_saving'] ?? $deal['savings'] ?? 0);
            $supplier = (string) ($deal['logoAlt'] ?? $deal['supplier'] ?? $deal['supplier_name'] ?? 'Supplier');
            $plan = (string) ($deal['plan'] ?? $deal['tariff_name'] ?? $deal['name'] ?? 'Tariff');

            $mapped[] = [
                'logo' => $deal['logo'] ?? asset('images/suppliers/octopus-color.png'),
                'logoAlt' => $supplier,
                'plan' => $plan,
                'badge' => $deal['badge'] ?? ($index === 0 ? 'Cheapest' : null),
                'features' => $deal['features'] ?? [
                    $deal['term'] ?? 'Fixed term',
                    $deal['exit_fee'] ?? 'See exit fees',
                    $deal['fuel'] ?? 'Dual fuel',
                ],
                'saveYear' => (int) round($saveYear),
                'saveMonth' => round($saveYear / 12, 2),
            ];
        }

        return $mapped;
    }
}
