<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Plan;
use App\Models\Subscription;
use App\Enums\SubscriptionStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_subscription()
    {
        $auth = $this->authenticateAdmin();
        $customer = Customer::factory()->create(['tenant_id' => $auth['tenant']->id]);
        $plan = Plan::factory()->create(['tenant_id' => $auth['tenant']->id]);

        $response = $this->postJson('/api/subscriptions', [
            'customer_id' => $customer->id,
            'plan_id' => $plan->id,
            'start_date' => now()->toDateString(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('subscriptions', [
            'customer_id' => $customer->id,
            'plan_id' => $plan->id,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);
    }

    public function test_can_cancel_subscription()
    {
        $auth = $this->authenticateAdmin();
        $sub = Subscription::factory()->create(['tenant_id' => $auth['tenant']->id]);

        $response = $this->postJson("/api/subscriptions/{$sub->id}/cancel");

        $response->assertStatus(200);
        $this->assertDatabaseHas('subscriptions', [
            'id' => $sub->id,
            'status' => SubscriptionStatus::CANCELED->value,
        ]);
    }
}
