<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LeadSubscribeBrevoTest extends TestCase
{
    use RefreshDatabase;

    public function test_lead_store_posts_contact_to_brevo(): void
    {
        config([
            'services.brevo.key' => 'test-brevo-key',
            'services.brevo.list_id' => '42',
        ]);

        Http::preventStrayRequests();
        Http::fake([
            'https://api.brevo.com/v3/contacts' => Http::response(['id' => 123], 201),
        ]);

        $this->postJson(route('leads.store'), [
            'email' => 'subscriber@example.com',
            'source' => 'newsletter',
        ])
            ->assertOk()
            ->assertJson([
                'ok' => true,
                'synced' => true,
                'crm' => true,
            ]);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.brevo.com/v3/contacts'
                && $request->hasHeader('api-key', 'test-brevo-key')
                && $request['email'] === 'subscriber@example.com'
                && $request['updateEnabled'] === true
                && $request['listIds'] === [42]
                && ! isset($request['attributes']['SOURCE']);
        });

        $this->assertDatabaseHas('leads', [
            'email' => 'subscriber@example.com',
            'source' => 'newsletter',
        ]);

        $lead = Lead::query()->where('email', 'subscriber@example.com')->first();
        $this->assertNotNull($lead?->esp_synced_at);
        $this->assertNull($lead?->esp_error);
    }

    public function test_lead_store_still_saves_when_brevo_fails(): void
    {
        config([
            'services.brevo.key' => 'test-brevo-key',
            'services.brevo.list_id' => null,
        ]);

        Http::preventStrayRequests();
        Http::fake([
            'https://api.brevo.com/v3/contacts' => Http::response([
                'code' => 'invalid_parameter',
                'message' => 'Invalid email',
            ], 400),
        ]);

        $this->postJson(route('leads.store'), [
            'email' => 'kept-locally@example.com',
            'source' => 'newsletter',
        ])
            ->assertOk()
            ->assertJson([
                'ok' => true,
                'synced' => false,
                'crm' => true,
            ]);

        $lead = Lead::query()->where('email', 'kept-locally@example.com')->first();
        $this->assertNotNull($lead);
        $this->assertNull($lead->esp_synced_at);
        $this->assertNotNull($lead->esp_error);
    }
}
