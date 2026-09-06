<?php

namespace Tests\Feature;

use App\Support\GuideArticles;
use Tests\TestCase;

class GuidesSeoTest extends TestCase
{
    public function test_each_guide_is_between_one_and_two_thousand_words(): void
    {
        foreach (GuideArticles::all() as $slug => $guide) {
            $count = GuideArticles::wordCount($guide);

            $this->assertGreaterThanOrEqual(1000, $count, "{$slug} is under 1,000 words ({$count}).");
            $this->assertLessThanOrEqual(2000, $count, "{$slug} is over 2,000 words ({$count}).");
        }
    }

    public function test_guide_pages_include_eeat_signals_schema_and_internal_links(): void
    {
        foreach (array_keys(GuideArticles::all()) as $slug) {
            $this->get(route('guides.show', $slug))
                ->assertOk()
                ->assertSee('application/ld+json', false)
                ->assertSee('FAQPage', false)
                ->assertSee('BreadcrumbList', false)
                ->assertSee('Zynx Ltd', false)
                ->assertSee(route('compare.details'), false)
                ->assertSee(route('guides.index'), false)
                ->assertSee('On this page', false)
                ->assertSee('Frequently asked questions', false);
        }
    }

    public function test_sitemap_lists_core_pages_and_guides(): void
    {
        $response = $this->get(route('sitemap'))
            ->assertOk();

        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee(route('home'), false);
        $response->assertSee(route('guides.index'), false);

        foreach (array_keys(GuideArticles::all()) as $slug) {
            $response->assertSee(route('guides.show', $slug), false);
        }
    }

    public function test_homepage_exposes_organization_schema_and_canonical(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('rel="canonical"', false)
            ->assertSee('"@type":"Organization"', false)
            ->assertSee(config('company.legal_name'), false);
    }
}
