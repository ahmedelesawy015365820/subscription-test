<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnumTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_retrieve_enums()
    {
        $response = $this->getJson('/api/enums');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'billing_cycles',
                    'invoice_statuses',
                    'subscription_statuses',
                    'user_roles',
                    'account_types',
                ]
            ]);
    }
}
