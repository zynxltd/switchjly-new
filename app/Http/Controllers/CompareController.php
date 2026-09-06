<?php

namespace App\Http\Controllers;

use App\Rules\UkPostcode;
use App\Services\CrmService;
use App\Services\EnergyShop\SwitchingApiClient;
use App\Support\AffiliateAttribution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CompareController extends Controller
{
    public function details(Request $request): View
    {
        $postcode = (string) $request->session()->get('compare.postcode', $request->query('postcode', ''));

        if ($postcode !== '' && ! UkPostcode::isValid($postcode)) {
            $postcode = '';
        } elseif ($postcode !== '') {
            $postcode = UkPostcode::normalize($postcode);
        }

        return view('compare.details', [
            'step' => 1,
            'postcode' => $postcode,
            'supplier' => $request->session()->get('compare.supplier', ''),
            'tariff' => $request->session()->get('compare.tariff', ''),
        ]);
    }

    public function storeDetails(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'postcode' => ['required', 'string', 'max:8', new UkPostcode],
            'supplier' => ['required', 'string', 'max:100'],
            'tariff' => ['required', 'string', 'max:100'],
        ]);

        $data['postcode'] = UkPostcode::normalize($data['postcode']);

        $attribution = AffiliateAttribution::fromRequest($request);

        $request->session()->put('compare', array_merge(
            $request->session()->get('compare', []),
            $data,
            [
                'affiliate_id' => $attribution['affiliate_id'],
                'referral_code' => $attribution['referral_code'],
            ],
        ));

        if ($request->session()->has('compare.email')) {
            return redirect()
                ->route('compare.deals')
                ->with('status', 'Your details were updated. We’ve refreshed your deals.');
        }

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
            'name' => $request->session()->get('compare.name', ''),
            'email' => $request->session()->get('compare.email', ''),
        ]);
    }

    public function storeUsage(Request $request, CrmService $crm): RedirectResponse
    {
        $data = $request->validate([
            'usage' => ['required', 'string', 'max:20'],
            'fuel' => ['required', 'string', 'max:40'],
            'payment' => ['required', 'string', 'max:40'],
            'name' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $attribution = AffiliateAttribution::fromRequest($request);
        $compare = array_merge(
            $request->session()->get('compare', []),
            $data,
            [
                'affiliate_id' => $attribution['affiliate_id'] ?? ($request->session()->get('compare.affiliate_id')),
                'referral_code' => $attribution['referral_code'] ?? ($request->session()->get('compare.referral_code')),
            ],
        );

        $request->session()->put('compare', $compare);

        $crm->capture([
            'email' => $data['email'],
            'name' => $data['name'] ?? null,
            'postcode' => $compare['postcode'] ?? null,
            'source' => 'compare',
            'affiliate_id' => $compare['affiliate_id'] ?? null,
            'referral_code' => $compare['referral_code'] ?? null,
            'meta' => [
                'supplier' => $compare['supplier'] ?? null,
                'tariff' => $compare['tariff'] ?? null,
                'fuel' => $compare['fuel'] ?? null,
                'usage' => $compare['usage'] ?? null,
                'payment' => $compare['payment'] ?? null,
            ],
        ], $request);

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

        $demoDeals = $this->sortedDeals($this->demoDeals());
        $deals = $demoDeals;
        $dealCount = count($demoDeals);
        $savings = $this->maxSaving($demoDeals);
        $usingLiveApi = false;

        if ($apiResult !== null && $apiResult['deals'] !== []) {
            $mapped = $this->sortedDeals($this->mapApiDeals($apiResult['deals']));
            if ($mapped !== []) {
                $deals = $mapped;
                $dealCount = $apiResult['deal_count'] ?: count($mapped);
                $apiSavings = $apiResult['savings'] ?? null;
                $savings = $apiSavings !== null
                    ? (int) $apiSavings
                    : $this->maxSaving($mapped);
                $usingLiveApi = true;
            }
        }

        $request->session()->put(
            'compare.deals',
            collect($deals)->keyBy('id')->all(),
        );

        return view('compare.deals', [
            'step' => 3,
            'compare' => $compare,
            'dealCount' => $dealCount,
            'savings' => $savings,
            'deals' => $deals,
            'usingLiveApi' => $usingLiveApi,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        if (! $request->session()->has('compare.postcode')) {
            return redirect()->route('compare.details');
        }

        $data = $request->validate([
            'postcode' => ['required', 'string', 'max:8', new UkPostcode],
            'supplier' => ['required', 'string', 'max:100'],
            'tariff' => ['required', 'string', 'max:100'],
            'usage' => ['required', 'string', 'max:20'],
            'fuel' => ['required', 'string', 'max:40'],
            'payment' => ['required', 'string', 'max:40'],
        ]);

        $data['postcode'] = UkPostcode::normalize($data['postcode']);

        $request->session()->put('compare', array_merge(
            $request->session()->get('compare', []),
            $data,
        ));

        return redirect()
            ->route('compare.deals')
            ->with('status', 'Your details were updated. We’ve refreshed your deals.');
    }

    public function redirect(Request $request, string $deal): View|RedirectResponse
    {
        $selected = $this->dealFromSession($request, $deal);

        if ($selected === null) {
            return redirect()->route('compare.deals');
        }

        $destination = $this->destinationForDeal($selected);

        $request->session()->put('compare.selected_deal', $selected['id']);

        return view('compare.redirect', [
            'deal' => $selected,
            'destination' => $destination,
            'delaySeconds' => 3,
        ]);
    }

    public function apply(Request $request, string $deal): View|RedirectResponse
    {
        $selected = $this->dealFromSession($request, $deal);

        if ($selected === null) {
            return redirect()->route('compare.deals');
        }

        if ($this->isExternalUrl($selected['applyUrl'] ?? null)) {
            return redirect()->away($selected['applyUrl']);
        }

        $compare = $request->session()->get('compare', []);

        return view('compare.apply', [
            'deal' => $selected,
            'compare' => $compare,
            'name' => $compare['name'] ?? '',
            'email' => $compare['email'] ?? '',
            'phone' => $compare['phone'] ?? '',
            'postcode' => $compare['postcode'] ?? '',
        ]);
    }

    public function storeApply(Request $request, string $deal, CrmService $crm, SwitchingApiClient $switching): RedirectResponse
    {
        $selected = $this->dealFromSession($request, $deal);

        if ($selected === null) {
            return redirect()->route('compare.deals');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'postcode' => ['required', 'string', 'max:8', new UkPostcode],
            'address_line' => ['required', 'string', 'max:180'],
            'consent' => ['accepted'],
        ]);

        $data['postcode'] = UkPostcode::normalize($data['postcode']);

        $compare = array_merge($request->session()->get('compare', []), [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'postcode' => $data['postcode'],
            'address_line' => $data['address_line'],
            'selected_deal' => $selected['id'],
        ]);

        $request->session()->put('compare', $compare);

        $crm->capture([
            'email' => $data['email'],
            'name' => $data['name'],
            'postcode' => $data['postcode'],
            'source' => 'switch_apply',
            'affiliate_id' => $compare['affiliate_id'] ?? null,
            'referral_code' => $compare['referral_code'] ?? null,
            'meta' => [
                'deal_id' => $selected['id'],
                'supplier' => $selected['logoAlt'],
                'plan' => $selected['plan'],
                'phone' => $data['phone'],
                'address_line' => $data['address_line'],
                'save_year' => $selected['saveYear'] ?? null,
            ],
        ], $request);

        $switching->switch([
            'deal_id' => $selected['id'],
            'supplier' => $selected['logoAlt'],
            'plan' => $selected['plan'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'postcode' => $data['postcode'],
            'address_line' => $data['address_line'],
            'referral_code' => $compare['referral_code'] ?? null,
        ]);

        $request->session()->put('compare.application', [
            'deal_id' => $selected['id'],
            'supplier' => $selected['logoAlt'],
            'plan' => $selected['plan'],
            'submitted_at' => now()->toIso8601String(),
        ]);

        return redirect()
            ->route('compare.apply', $selected['id'])
            ->with('status', 'application_submitted');
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function dealFromSession(Request $request, string $dealId): ?array
    {
        $deals = $request->session()->get('compare.deals', []);

        if (! is_array($deals) || ! isset($deals[$dealId]) || ! is_array($deals[$dealId])) {
            return null;
        }

        return $deals[$dealId];
    }

    /**
     * @param  array<string, mixed>  $deal
     */
    protected function destinationForDeal(array $deal): string
    {
        if ($this->isExternalUrl($deal['applyUrl'] ?? null)) {
            return $deal['applyUrl'];
        }

        return route('compare.apply', $deal['id']);
    }

    protected function isExternalUrl(mixed $url): bool
    {
        if (! is_string($url) || $url === '') {
            return false;
        }

        return Str::startsWith($url, ['http://', 'https://']);
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function demoDeals(): array
    {
        $baselineAnnualCost = 1800;

        $catalog = [
            ['octopus-color.png', 'Octopus Energy', 'Octopus Go', ['12 month fixed', '100% renewable electricity', '£0 exit fees'], 312, 26.00, 4.8],
            ['scottishpower-color.png', 'ScottishPower', 'Secure Fixed 12', ['12 month fixed', '100% renewable electricity', '£0 exit fees'], 265, 22.08, 4.5],
            ['eon-color.png', 'E.ON', 'Next Flex', ['No fixed term', '100% renewable electricity', '£0 exit fees'], 198, 16.50, 4.3],
            ['british-gas-color.png', 'British Gas', 'Fixed Energy July 2027', ['12 month fixed', 'Dual fuel', 'Online account'], 184, 15.33, 4.1],
            ['ovo-color.png', 'OVO Energy', 'Better Energy Fixed', ['12 month fixed', '100% renewable electricity', '£0 exit fees'], 176, 14.67, 4.6],
            ['utilita-color.png', 'Utilita', 'Smart Pay As You Go', ['Prepayment friendly', 'No exit fees', 'Smart meter support'], 142, 11.83, 4.0],
            ['octopus-color.png', 'Octopus Energy', 'Flexible Octopus', ['No fixed term', '100% renewable electricity', '£0 exit fees'], 168, 14.00, 4.7],
            ['eon-color.png', 'E.ON', 'Next Pledge Fixed 12', ['12 month fixed', 'Green electricity', 'Paperless billing'], 155, 12.92, 4.4],
            ['scottishpower-color.png', 'ScottishPower', 'Online Fixed v24', ['12 month fixed', 'Online exclusive', 'Exit fee applies'], 149, 12.42, 4.2],
            ['ovo-color.png', 'OVO Energy', '2 Year Fixed Simpler Energy', ['24 month fixed', '100% renewable electricity', 'Exit fee applies'], 138, 11.50, 4.5],
            ['british-gas-color.png', 'British Gas', 'Variable Standard', ['No fixed term', 'Dual fuel', 'Pay monthly'], 121, 10.08, 3.9],
            ['octopus-color.png', 'Octopus Energy', 'Octopus 12M Fixed', ['12 month fixed', '100% renewable electricity', 'Exit fee applies'], 205, 17.08, 4.7],
            ['utilita-color.png', 'Utilita', 'Smart Energy Fixed', ['12 month fixed', 'Smart meter required', 'No exit fees'], 133, 11.08, 4.1],
            ['eon-color.png', 'E.ON', 'Next Drive', ['EV friendly', 'No fixed term', 'Green electricity'], 160, 13.33, 4.4],
            ['scottishpower-color.png', 'ScottishPower', 'Green Fixed', ['12 month fixed', '100% renewable electricity', 'Exit fee applies'], 171, 14.25, 4.3],
            ['ovo-color.png', 'OVO Energy', 'Simpler Energy Variable', ['No fixed term', '100% renewable electricity', '£0 exit fees'], 115, 9.58, 4.4],
            ['british-gas-color.png', 'British Gas', 'Fixed Tariff Sept 2027', ['12 month fixed', 'Dual fuel', 'Exit fee applies'], 190, 15.83, 4.2],
            ['octopus-color.png', 'Octopus Energy', 'Intelligent Octopus Go', ['EV overnight rates', 'Smart tariff', '100% renewable'], 228, 19.00, 4.9],
            ['eon-color.png', 'E.ON', 'Next Fixed 15', ['15 month fixed', 'Online account', 'Exit fee applies'], 146, 12.17, 4.2],
            ['scottishpower-color.png', 'ScottishPower', 'Standard Variable', ['No fixed term', 'Dual fuel', 'Pay monthly'], 98, 8.17, 3.8],
            ['ovo-color.png', 'OVO Energy', 'Better Boiler Cover Bundle', ['12 month fixed', 'Boiler cover option', 'Green electricity'], 129, 10.75, 4.3],
            ['utilita-color.png', 'Utilita', 'Warm Home Discount Eligible', ['Prepayment friendly', 'Support schemes', 'No exit fees'], 110, 9.17, 4.0],
            ['british-gas-color.png', 'British Gas', 'Rewarding Fixed', ['12 month fixed', 'Rewards scheme', 'Exit fee applies'], 157, 13.08, 4.1],
            ['octopus-color.png', 'Octopus Energy', 'Cosy Octopus', ['Heat pump tariff', '100% renewable', 'No exit fees'], 173, 14.42, 4.6],
        ];

        return collect($catalog)->map(function (array $row) use ($baselineAnnualCost) {
            $id = Str::slug($row[1].'-'.$row[2]);
            $features = $row[3];
            $saveYear = (int) $row[4];
            $haystack = Str::lower(implode(' ', $features).' '.$row[2]);

            return [
                'id' => $id,
                'logo' => asset('images/suppliers/'.$row[0]),
                'logoAlt' => $row[1],
                'plan' => $row[2],
                'badge' => null,
                'features' => $features,
                'saveYear' => $saveYear,
                'saveMonth' => $row[5],
                'annualCost' => max(0, $baselineAnnualCost - $saveYear),
                'rating' => $row[6],
                'isGreen' => Str::contains($haystack, ['renewable', 'green']),
                'isFixed' => Str::contains($haystack, ['fixed']),
                'applyUrl' => null,
            ];
        })->all();
    }

    /**
     * @param  list<array<string, mixed>>  $deals
     * @return list<array<string, mixed>>
     */
    protected function sortedDeals(array $deals): array
    {
        $sorted = collect($deals)
            ->sortBy([
                ['annualCost', 'asc'],
                ['saveYear', 'desc'],
            ])
            ->values()
            ->map(function (array $deal, int $index) {
                $deal['badge'] = $index === 0 ? 'Cheapest' : ($deal['badge'] ?? null);

                if ($index !== 0 && ($deal['badge'] ?? null) === 'Cheapest') {
                    $deal['badge'] = null;
                }

                return $deal;
            })
            ->all();

        return $sorted;
    }

    /**
     * @param  list<array<string, mixed>>  $deals
     */
    protected function maxSaving(array $deals): int
    {
        return (int) collect($deals)->max('saveYear');
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
        $baselineAnnualCost = 1800;

        foreach ($rawDeals as $index => $deal) {
            if (! is_array($deal)) {
                continue;
            }

            $saveYear = (float) ($deal['saveYear'] ?? $deal['annual_saving'] ?? $deal['savings'] ?? 0);
            $annualCost = (float) ($deal['annualCost'] ?? $deal['annual_cost'] ?? $deal['estimated_annual_cost'] ?? $deal['yearly_cost'] ?? 0);
            if ($annualCost <= 0) {
                $annualCost = max(0, $baselineAnnualCost - $saveYear);
            }

            $supplier = (string) ($deal['logoAlt'] ?? $deal['supplier'] ?? $deal['supplier_name'] ?? 'Supplier');
            $plan = (string) ($deal['plan'] ?? $deal['tariff_name'] ?? $deal['name'] ?? 'Tariff');
            $id = (string) ($deal['id'] ?? $deal['deal_id'] ?? Str::slug($supplier.'-'.$plan.'-'.$index));
            $applyUrl = $deal['applyUrl'] ?? $deal['apply_url'] ?? $deal['redirect_url'] ?? $deal['url'] ?? null;
            $features = $deal['features'] ?? [
                $deal['term'] ?? 'Fixed term',
                $deal['exit_fee'] ?? 'See exit fees',
                $deal['fuel'] ?? 'Dual fuel',
            ];
            if (! is_array($features)) {
                $features = [(string) $features];
            }
            $haystack = Str::lower(implode(' ', $features).' '.$plan);

            $mapped[] = [
                'id' => $id,
                'logo' => $deal['logo'] ?? asset('images/suppliers/octopus-color.png'),
                'logoAlt' => $supplier,
                'plan' => $plan,
                'badge' => null,
                'features' => $features,
                'saveYear' => (int) round($saveYear),
                'saveMonth' => round($saveYear / 12, 2),
                'annualCost' => (int) round($annualCost),
                'rating' => (float) ($deal['rating'] ?? $deal['score'] ?? 4.0),
                'isGreen' => (bool) ($deal['isGreen'] ?? $deal['green'] ?? Str::contains($haystack, ['renewable', 'green'])),
                'isFixed' => (bool) ($deal['isFixed'] ?? $deal['fixed'] ?? Str::contains($haystack, ['fixed'])),
                'applyUrl' => is_string($applyUrl) ? $applyUrl : null,
            ];
        }

        return $mapped;
    }
}
