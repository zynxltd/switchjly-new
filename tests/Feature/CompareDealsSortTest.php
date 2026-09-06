<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompareDealsSortTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, mixed>
     */
    protected function completedCompareSession(): array
    {
        return [
            'compare' => [
                'postcode' => 'SW1A 1AA',
                'supplier' => 'British Gas',
                'tariff' => 'Standard Variable',
                'usage' => '3100',
                'fuel' => 'dual',
                'payment' => 'direct_debit',
                'name' => 'Alex Example',
                'email' => 'alex@example.com',
            ],
        ];
    }

    public function test_deals_are_ordered_by_lowest_annual_cost_with_max_saving_headline(): void
    {
        $response = $this->withSession($this->completedCompareSession())
            ->get(route('compare.deals'));

        $response
            ->assertOk()
            ->assertSee('£312', false)
            ->assertSee('Est. annual cost', false)
            ->assertSee('£1,488', false)
            ->assertSee('Cheapest', false)
            ->assertSee('dealResults', false)
            ->assertSee('Green energy only', false)
            ->assertSee('Fixed tariffs only', false)
            ->assertSee('filterOpen = false', false);

        $html = $response->getContent();

        $cheapestCost = strpos($html, 'data-cost="1488"');
        $nextCost = strpos($html, 'data-cost="1535"');
        $octopusGo = strpos($html, 'Octopus Go');
        $intelligentGo = strpos($html, 'Intelligent Octopus Go');

        $this->assertNotFalse($cheapestCost);
        $this->assertNotFalse($nextCost);
        $this->assertNotFalse($octopusGo);
        $this->assertNotFalse($intelligentGo);
        $this->assertTrue($cheapestCost < $nextCost, 'Lowest annual-cost deal should appear first');
        $this->assertTrue($octopusGo < $intelligentGo, 'Octopus Go should rank above Intelligent Octopus Go');
    }
}
