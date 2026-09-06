<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompareEditDetailsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    protected function completedCompareSession(): array
    {
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
            ],
        ];
    }

    public function test_deals_page_shows_inline_edit_controls(): void
    {
        $this->withSession($this->completedCompareSession())
            ->get(route('compare.deals'))
            ->assertOk()
            ->assertSee('Update your details')
            ->assertSee('Update results')
            ->assertSee(route('compare.deals.update'), false);
    }

    public function test_user_can_update_compare_details_without_restarting_funnel(): void
    {
        $this->withSession($this->completedCompareSession())
            ->post(route('compare.deals.update'), [
                'postcode' => 'SW1A 1AA',
                'supplier' => 'British Gas',
                'tariff' => 'Standard Variable',
                'usage' => '2800',
                'fuel' => 'electricity',
                'payment' => 'prepayment',
            ])
            ->assertRedirect(route('compare.deals'))
            ->assertSessionHas('status');

        $this->assertSame('SW1A 1AA', session('compare.postcode'));
        $this->assertSame('British Gas', session('compare.supplier'));
        $this->assertSame('Standard Variable', session('compare.tariff'));
        $this->assertSame('2800', session('compare.usage'));
        $this->assertSame('electricity', session('compare.fuel'));
        $this->assertSame('prepayment', session('compare.payment'));
        $this->assertSame('alex@example.com', session('compare.email'));
        $this->assertSame('Alex Example', session('compare.name'));
    }

    public function test_updated_details_appear_on_deals_summary(): void
    {
        $session = $this->completedCompareSession();
        $session['compare']['postcode'] = 'SW1A 1AA';
        $session['compare']['supplier'] = 'British Gas';
        $session['compare']['usage'] = '2800';
        $session['compare']['fuel'] = 'electricity';

        $this->withSession($session)
            ->get(route('compare.deals'))
            ->assertOk()
            ->assertSee('SW1A 1AA')
            ->assertSee('British Gas')
            ->assertSee('2,800 kWh')
            ->assertSee('Electricity only');
    }

    public function test_update_validation_keeps_user_on_deals_flow(): void
    {
        $this->withSession($this->completedCompareSession())
            ->from(route('compare.deals'))
            ->post(route('compare.deals.update'), [
                'postcode' => 'NOPE',
                'supplier' => '',
                'tariff' => '',
                'usage' => '',
                'fuel' => '',
                'payment' => '',
            ])
            ->assertRedirect(route('compare.deals'))
            ->assertSessionHasErrors(['postcode', 'supplier', 'tariff', 'usage', 'fuel', 'payment']);
    }

    public function test_editing_details_after_completion_returns_to_deals(): void
    {
        $this->withSession($this->completedCompareSession())
            ->post(route('compare.details.store'), [
                'postcode' => 'M1 1AE',
                'supplier' => 'OVO Energy',
                'tariff' => 'Tracker',
            ])
            ->assertRedirect(route('compare.deals'));

        $this->assertSame('M1 1AE', session('compare.postcode'));
        $this->assertSame('OVO Energy', session('compare.supplier'));
        $this->assertSame('alex@example.com', session('compare.email'));
    }
}
