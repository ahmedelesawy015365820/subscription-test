<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::all();

        $customersPerTenant = [
            ['name' => 'Alice Johnson',  'email' => 'alice@example.com'],
            ['name' => 'Bob Smith',      'email' => 'bob@example.com'],
            ['name' => 'Carol Williams', 'email' => 'carol@example.com'],
            ['name' => 'David Brown',    'email' => 'david@example.com'],
        ];

        foreach ($tenants as $index => $tenant) {
            foreach ($customersPerTenant as $cIndex => $customer) {
                Customer::create([
                    'tenant_id' => $tenant->id,
                    'name'      => $customer['name'],
                    'email'     => "tenant{$tenant->id}_{$customer['email']}",
                ]);
            }
        }
    }
}
