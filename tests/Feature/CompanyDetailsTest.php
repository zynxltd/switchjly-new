<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_brillia_energy_branding(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Brillia Energy', false)
            ->assertSee('images/logo-energy-wordmark-1.svg', false)
            ->assertSee('Brillia is a trading name of Zynx Ltd', false);
    }

    public function test_home_page_footer_shows_zynx_legal_entity(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Brillia is a trading name of Zynx Ltd', false)
            ->assertSee('company number 15822793', false)
            ->assertSee('11 Brendon Close, Grantham, Lincolnshire', false);
    }

    public function test_contact_page_shows_company_details(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee('Brillia is a trading name of Zynx Ltd', false)
            ->assertSee('15822793', false)
            ->assertSee('11 Brendon Close, Grantham, Lincolnshire', false);
    }
}
