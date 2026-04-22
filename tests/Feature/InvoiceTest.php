<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Subscription;
use App\Enums\AccountType;
use App\Enums\InvoiceStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_invoices_and_accounting_entries()
    {
        $auth = $this->authenticateAdmin();
        $tenantId = $auth['tenant']->id;

        // Setup accounts
        Account::factory()->create(['tenant_id' => $tenantId, 'name' => 'Accounts Receivable', 'type' => AccountType::ASSET]);
        Account::factory()->create(['tenant_id' => $tenantId, 'name' => 'Deferred Revenue', 'type' => AccountType::LIABILITY]);

        Subscription::factory()->create(['tenant_id' => $tenantId]);

        $response = $this->postJson('/api/generate-invoices');

        $response->assertStatus(201);

        $this->assertDatabaseHas('invoices', [
            'tenant_id' => $tenantId,
            'status' => InvoiceStatus::UNPAID->value,
        ]);

        $this->assertDatabaseHas('journal_entries', ['tenant_id' => $tenantId]);
        $this->assertDatabaseHas('journal_entry_lines', ['debit' => 29.99]); // AR Debit
    }
}
