<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = [
            ['name' => 'TechCorp Ltd',    'email' => 'admin@techcorp.com'],
            ['name' => 'StartupHub Inc',  'email' => 'admin@startuphub.com'],
            ['name' => 'SaaSify Corp',    'email' => 'admin@saasify.com'],
        ];

        foreach ($tenants as $tenantData) {
            $tenant = Tenant::create($tenantData);

            // Create an admin user for each tenant
            User::create([
                'tenant_id' => $tenant->id,
                'name'      => $tenantData['name'] . ' Admin',
                'email'     => $tenantData['email'],
                'password'  => Hash::make('password'),
                'role'      => \App\Enums\UserRole::ADMIN->value,
            ]);
        }
    }
}
