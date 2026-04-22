<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\Tenant;
use App\Enums\BillingCycle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_plans()
    {
        $auth = $this->authenticateAdmin();
        Plan::factory()->count(3)->create(['tenant_id' => $auth['tenant']->id]);

        $response = $this->getJson('/api/plans');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_tenant_isolation_on_plans()
    {
        $otherTenant = Tenant::factory()->create();
        Plan::factory()->create(['tenant_id' => $otherTenant->id]);

        $this->authenticateAdmin();
        $response = $this->getJson('/api/plans');

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_can_create_plan()
    {
        $this->authenticateAdmin();

        $response = $this->postJson('/api/plans', [
            'name' => 'Premium Plan',
            'price' => 50.00,
            'billing_cycle' => BillingCycle::MONTHLY->value,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('plans', ['name' => 'Premium Plan']);
    }

    public function test_can_update_plan()
    {
        $auth = $this->authenticateAdmin();
        $plan = Plan::factory()->create(['tenant_id' => $auth['tenant']->id]);

        $response = $this->putJson("/api/plans/{$plan->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('plans', ['id' => $plan->id, 'name' => 'Updated Name']);
    }

    public function test_can_delete_plan()
    {
        $auth = $this->authenticateAdmin();
        $plan = Plan::factory()->create(['tenant_id' => $auth['tenant']->id]);

        $response = $this->deleteJson("/api/plans/{$plan->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('plans', ['id' => $plan->id]);
    }
}
