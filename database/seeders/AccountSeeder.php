<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::all();

        $accounts = [
            ['name' => 'Cash',                 'type' => \App\Enums\AccountType::ASSET->value],
            ['name' => 'Accounts Receivable',  'type' => \App\Enums\AccountType::ASSET->value],
            ['name' => 'Deferred Revenue',     'type' => \App\Enums\AccountType::LIABILITY->value],
            ['name' => 'Subscription Revenue', 'type' => \App\Enums\AccountType::REVENUE->value],
        ];

        foreach ($tenants as $tenant) {
            foreach ($accounts as $account) {
                Account::firstOrCreate(
                    ['tenant_id' => $tenant->id, 'name' => $account['name']],
                    ['type' => $account['type']]
                );
            }
        }
    }
}
