<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompareDealRedirectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    protected function compareSession(array $deals = []): array
    {
        $deal = $deals[0] ?? [
            'id' => 'octopus-energy-octopus-go',
            'logo' => '/images/suppliers/octopus-color.png',
            'logoAlt' => 'Octopus Energy',
            'plan' => 'Octopus Go',
            'badge' => 'Cheapest',
            'features' => ['12 month fixed'],
            'saveYear' => 312,
            'saveMonth' => 26.0,
            'applyUrl' => null,
        ];

        return [
            'compare' => [
                'postcode' => 'NG31 8FU',
                'supplier' => 'Octopus Energy',
                'tariff' => 'Fixed',
                'usage' => '3100',
                'fuel' => 'dual',
                'payment' => 'direct_debit',
                'name' => 'Alex Example',
                'email' => 'alex@example.com',
                'deals' => [
                    $deal['id'] => $deal,
                ],
            ],
        ];
    }

    public function test_view_deal_opens_redirect_interstitial(): void
    {
        $session = $this->compareSession();
        $dealId = 'octopus-energy-octopus-go';

        $this->withSession($session)
            ->get(route('compare.redirect', $dealId))
            ->assertOk()
            ->assertSee('Taking you to complete your Octopus Energy switch')
            ->assertSee('Octopus Go')
            ->assertSee(route('compare.apply', $dealId), false);
    }

    public function test_redirect_page_for_unknown_deal_returns_to_deals(): void
    {
        $this->withSession($this->compareSession())
            ->get(route('compare.redirect', 'missing-deal'))
            ->assertRedirect(route('compare.deals'));
    }

    public function test_apply_page_shows_completion_form(): void
    {
        $session = $this->compareSession();
        $dealId = 'octopus-energy-octopus-go';

        $this->withSession($session)
            ->get(route('compare.apply', $dealId))
            ->assertOk()
            ->assertSee('Complete your Octopus Energy switch')
            ->assertSee('alex@example.com')
            ->assertSee('Submit application');
    }

    public function test_submitting_apply_form_captures_lead_and_confirms(): void
    {
        $session = $this->compareSession();
        $dealId = 'octopus-energy-octopus-go';

        $this->withSession($session)
            ->post(route('compare.apply.store', $dealId), [
                'name' => 'Alex Example',
                'email' => 'alex@example.com',
                'phone' => '07700900000',
                'postcode' => 'NG31 8FU',
                'address_line' => '12 High Street',
                'consent' => '1',
            ])
            ->assertRedirect(route('compare.apply', $dealId))
            ->assertSessionHas('status', 'application_submitted');

        $this->assertDatabaseHas('leads', [
            'email' => 'alex@example.com',
            'source' => 'switch_apply',
            'postcode' => 'NG31 8FU',
        ]);

        $lead = Lead::query()->where('email', 'alex@example.com')->first();
        $this->assertNotNull($lead);
        $this->assertSame('octopus-energy-octopus-go', $lead->meta['deal_id'] ?? null);

        $this->withSession([
            ...$session,
            'status' => 'application_submitted',
        ])->followingRedirects()
            ->get(route('compare.apply', $dealId));
    }

    public function test_deals_page_links_view_deal_to_redirect_route(): void
    {
        $this->withSession([
            'compare' => [
                'postcode' => 'NG31 8FU',
                'supplier' => 'Octopus Energy',
                'tariff' => 'Fixed',
                'usage' => '3100',
                'fuel' => 'dual',
                'payment' => 'direct_debit',
                'email' => 'alex@example.com',
            ],
        ])
            ->get(route('compare.deals'))
            ->assertOk()
            ->assertSee(route('compare.redirect', 'octopus-energy-octopus-go'), false)
            ->assertDontSee('href="#"', false);
    }

    public function test_external_apply_url_is_used_as_redirect_destination(): void
    {
        $deal = [
            'id' => 'external-deal',
            'logo' => '/images/suppliers/octopus-color.png',
            'logoAlt' => 'Octopus Energy',
            'plan' => 'External Go',
            'badge' => null,
            'features' => ['12 month fixed'],
            'saveYear' => 200,
            'saveMonth' => 16.67,
            'applyUrl' => 'https://supplier.example/apply/123',
        ];

        $this->withSession($this->compareSession([$deal]))
            ->get(route('compare.redirect', 'external-deal'))
            ->assertOk()
            ->assertSee('https://supplier.example/apply/123', false);

        $this->withSession($this->compareSession([$deal]))
            ->get(route('compare.apply', 'external-deal'))
            ->assertRedirect('https://supplier.example/apply/123');
    }

    public function test_apply_validation_requires_consent_and_fields(): void
    {
        $session = $this->compareSession();
        $dealId = 'octopus-energy-octopus-go';

        $this->withSession($session)
            ->from(route('compare.apply', $dealId))
            ->post(route('compare.apply.store', $dealId), [])
            ->assertRedirect(route('compare.apply', $dealId))
            ->assertSessionHasErrors(['name', 'email', 'phone', 'postcode', 'address_line', 'consent']);
    }
}
