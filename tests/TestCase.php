<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\Models\Tenant;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    protected function authenticateAdmin()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
            'role'      => \App\Enums\UserRole::ADMIN,
        ]);

        Sanctum::actingAs($user);

        return ['user' => $user, 'tenant' => $tenant];
    }
}
