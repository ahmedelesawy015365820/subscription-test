<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        // Must create a free plan first as AuthService expects it
        Plan::create([
            'name' => 'Free Plan',
            'price' => 0,
            'currency' => 'USD',
            'billing_cycle' => 'monthly',
            'days' => 0,
            'is_default' => '1',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'message', 'data']);
        
        $this->assertDatabaseHas('users', ['email' => 'user@example.com']);
    }

    public function test_user_can_login()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data' => ['user', 'token']
                 ]);
    }

    public function test_user_can_get_plan_list()
    {
        $response = $this->postJson('/api/plan-list');

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function test_user_can_subscribe()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);
        $token = $user->createToken('test')->plainTextToken;

        $plan = Plan::create([
            'name' => 'Basic Plan',
            'price' => 10,
            'currency' => 'USD',
            'billing_cycle' => 'monthly',
            'days' => 30,
            'is_default' => '1',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/subscription', [
                             'plan_id' => $plan->id,
                             'is_payment' => 1,
                         ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'message', 'data']);
        
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan_id' => $plan->id,
        ]);
    }
}
