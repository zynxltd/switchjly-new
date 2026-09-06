<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeroPostcodeValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_hero_postcode_field_is_required_with_uk_pattern(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('postcodeCompareForm()', false)
            ->assertSee('name="postcode"', false)
            ->assertSee('required', false)
            ->assertSee('Enter a valid UK postcode', false);
    }

    public function test_compare_details_ignores_invalid_postcode_query(): void
    {
        $this->get(route('compare.details', ['postcode' => 'NOTAPOSTCODE']))
            ->assertOk()
            ->assertDontSee('value="NOTAPOSTCODE"', false);
    }

    public function test_compare_details_normalises_valid_postcode_query(): void
    {
        $this->get(route('compare.details', ['postcode' => 'sw1a1aa']))
            ->assertOk()
            ->assertSee('value="SW1A 1AA"', false);
    }
}
