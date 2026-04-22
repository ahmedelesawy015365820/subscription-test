<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_customers()
    {
        $auth = $this->authenticateAdmin();
        Customer::factory()->count(3)->create(['tenant_id' => $auth['tenant']->id]);

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_create_customer()
    {
        $this->authenticateAdmin();

        $response = $this->postJson('/api/customers', [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '123456789',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('customers', ['email' => 'jane@example.com']);
    }
}
