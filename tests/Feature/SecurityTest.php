<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_view_other_tenants_plan()
    {
        $tenantA = Tenant::factory()->create();
        $userA = User::factory()->create(['tenant_id' => $tenantA->id, 'role' => UserRole::USER]);

        $tenantB = Tenant::factory()->create();
        $planB = Plan::factory()->create(['tenant_id' => $tenantB->id]);

        $this->actingAs($userA, 'sanctum');

        $response = $this->getJson("/api/plans/{$planB->id}");

        $response->assertStatus(404); // Global Scope prevents finding the record at all
    }

    public function test_non_admin_cannot_delete_plan()
    {
        $auth = $this->authenticateUser(); // Logic to be added to TestCase or just use actingAs
        $plan = Plan::factory()->create(['tenant_id' => $auth['tenant']->id]);

        $response = $this->deleteJson("/api/plans/{$plan->id}");

        $response->assertStatus(403);
    }

    public function test_non_admin_cannot_generate_invoices()
    {
        $this->authenticateUser();

        $response = $this->postJson('/api/generate-invoices');

        $response->assertStatus(403);
    }

    protected function authenticateUser()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role'      => UserRole::USER,
        ]);

        $this->actingAs($user, 'sanctum');

        return ['user' => $user, 'tenant' => $tenant];
    }
}
