<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_register()
    {
        $response = $this->postJson('/api/admin/register', [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'message', 'data']);
        
        $this->assertDatabaseHas('admins', ['email' => 'admin@example.com']);
    }

    public function test_admin_can_login()
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => [
                         'admin' => ['id', 'name', 'email'],
                         'token'
                     ]
                 ]);
    }

    public function test_admin_can_get_enums()
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);
        $token = $admin->createToken('test')->plainTextToken;

        $endpoints = [
            '/api/admin/get-billing-cycle',
            '/api/admin/get-currency',
            '/api/admin/get-payment-status',
            '/api/admin/get-subscription-status',
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                             ->getJson($endpoint);
            $response->assertStatus(200)
                     ->assertJsonStructure(['status', 'message', 'data']);
        }
    }

    public function test_admin_can_manage_plans()
    {
        $admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);
        $token = $admin->createToken('test')->plainTextToken;

        // Create
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/admin/plans', [
                             'name' => 'Basic Plan',
                             'price' => 10,
                             'currency' => 'USD',
                             'billing_cycle' => 'monthly',
                             'days' => 30,
                             'is_default' => '1',
                         ]);
        $response->assertStatus(200);
        $planId = $response->json('data.id');

        // List
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/admin/plans');
        $response->assertStatus(200);

        // Show
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/admin/plans/' . $planId);
        $response->assertStatus(200);

        // Update
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->putJson('/api/admin/plans/' . $planId, [
                             'name' => 'Updated Plan',
                             'price' => 15,
                             'currency' => 'USD',
                             'billing_cycle' => 'monthly',
                             'days' => 30,
                             'is_default' => '0',
                         ]);
        $response->assertStatus(200);

        // Delete
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->deleteJson('/api/admin/plans/' . $planId);
        $response->assertStatus(200);
    }
}
