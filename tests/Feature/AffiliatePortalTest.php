<?php

namespace Tests\Feature;

use App\Models\AffiliateClick;
use App\Models\AffiliatePayout;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AffiliatePortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_affiliate_dashboard_to_login(): void
    {
        $this->get(route('affiliate.dashboard'))
            ->assertRedirect(route('affiliate.login'));
    }

    public function test_guests_are_redirected_from_creatives_to_login(): void
    {
        $this->get(route('affiliate.creatives'))
            ->assertRedirect(route('affiliate.login'));
    }

    public function test_affiliate_can_log_in_and_view_dashboard(): void
    {
        $affiliate = User::factory()->affiliate()->create([
            'email' => 'partner@example.com',
            'referral_code' => 'PARTNER1',
            'commission_rate' => 25,
        ]);

        AffiliateClick::query()->create([
            'affiliate_id' => $affiliate->id,
            'referral_code' => 'PARTNER1',
            'landing_path' => '/',
        ]);

        Lead::query()->create([
            'email' => 'lead@example.com',
            'source' => 'popup',
            'affiliate_id' => $affiliate->id,
            'referral_code' => 'PARTNER1',
        ]);

        AffiliatePayout::query()->create([
            'affiliate_id' => $affiliate->id,
            'amount' => 25,
            'status' => 'paid',
            'notes' => 'March payout',
            'paid_at' => now(),
        ]);

        $this->post(route('affiliate.login.store'), [
            'email' => 'partner@example.com',
            'password' => 'password',
        ])->assertRedirect(route('affiliate.dashboard'));

        $this->get(route('affiliate.dashboard'))
            ->assertOk()
            ->assertSee('Welcome back, '.$affiliate->name)
            ->assertSee('PARTNER1')
            ->assertSee('ref=PARTNER1')
            ->assertSee('Conversion rate')
            ->assertSee('Marketing creatives')
            ->assertSee('£25.00')
            ->assertSee('March payout');
    }

    public function test_affiliate_can_view_creatives_with_tracking_links(): void
    {
        $affiliate = User::factory()->affiliate()->create([
            'referral_code' => 'CREATIVE1',
        ]);

        $this->actingAs($affiliate)
            ->get(route('affiliate.creatives'))
            ->assertOk()
            ->assertSee('Marketing creatives')
            ->assertSee('CREATIVE1')
            ->assertSee('Tracking links')
            ->assertSee('Ready-made copy')
            ->assertSee('Banner embeds')
            ->assertSee('Brand assets')
            ->assertSee('ref=CREATIVE1')
            ->assertSee('/compare/details?ref=CREATIVE1');
    }

    public function test_admin_cannot_access_affiliate_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('affiliate.dashboard'))
            ->assertForbidden();
    }

    public function test_affiliate_cannot_access_admin_dashboard(): void
    {
        $affiliate = User::factory()->affiliate()->create();

        $this->actingAs($affiliate)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_non_affiliate_credentials_are_rejected_at_affiliate_login(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        $this->from(route('affiliate.login'))
            ->post(route('affiliate.login.store'), [
                'email' => 'admin@example.com',
                'password' => 'password',
            ])
            ->assertRedirect(route('affiliate.login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_invalid_affiliate_login_shows_error(): void
    {
        User::factory()->affiliate()->create([
            'email' => 'partner@example.com',
        ]);

        $this->from(route('affiliate.login'))
            ->post(route('affiliate.login.store'), [
                'email' => 'partner@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('affiliate.login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_referral_visit_records_a_click_once_per_session(): void
    {
        $affiliate = User::factory()->affiliate()->create([
            'referral_code' => 'DEMOAFF1',
        ]);

        $this->get('/?ref=DEMOAFF1')
            ->assertOk();

        $this->assertDatabaseCount('affiliate_clicks', 1);
        $this->assertDatabaseHas('affiliate_clicks', [
            'affiliate_id' => $affiliate->id,
            'referral_code' => 'DEMOAFF1',
            'landing_path' => '/',
        ]);
        $this->assertEquals('DEMOAFF1', session('affiliate_ref'));
        $this->assertEquals($affiliate->id, session('affiliate_id'));

        $this->get('/how-it-works?ref=DEMOAFF1')
            ->assertOk();

        $this->assertDatabaseCount('affiliate_clicks', 1);
    }

    public function test_lead_capture_attributes_affiliate_from_session(): void
    {
        $affiliate = User::factory()->affiliate()->create([
            'referral_code' => 'LEADREF1',
        ]);

        $this->withSession([
            'affiliate_ref' => 'LEADREF1',
            'affiliate_id' => $affiliate->id,
        ])->postJson(route('leads.store'), [
            'email' => 'attributed@example.com',
            'source' => 'popup',
        ])->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertDatabaseHas('leads', [
            'email' => 'attributed@example.com',
            'affiliate_id' => $affiliate->id,
            'referral_code' => 'LEADREF1',
        ]);
    }

    public function test_affiliate_can_log_out(): void
    {
        $affiliate = User::factory()->affiliate()->create();

        $this->actingAs($affiliate)
            ->post(route('affiliate.logout'))
            ->assertRedirect(route('affiliate.login'));

        $this->assertGuest();
    }
}
