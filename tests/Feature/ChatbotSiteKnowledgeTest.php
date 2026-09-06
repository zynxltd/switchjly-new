<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotSiteKnowledgeTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_chatbot_exposes_company_context_for_assist(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('x-data="brilliaChat"', false)
            ->assertSee('x-data="leadPopup"', false)
            ->assertSee('Get deal drops in your inbox', false)
            ->assertSee('data-trading-name="'.config('company.trading_name').'"', false)
            ->assertSee('data-product-name="'.config('company.product_name').'"', false)
            ->assertSee('data-legal-name="'.config('company.legal_name').'"', false)
            ->assertSee('data-company-number="'.config('company.number').'"', false)
            ->assertSee('data-support-email="'.config('company.support_email').'"', false)
            ->assertSee('data-contact-url="'.route('contact').'"', false)
            ->assertSee('data-affiliates-url="'.route('affiliates').'"', false)
            ->assertSee('data-guides-url="'.route('guides.index').'"', false);
    }
}
