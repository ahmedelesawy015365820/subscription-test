<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Invoice;
use App\Enums\AccountType;
use App\Enums\InvoiceStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_process_payment_and_update_accounting()
    {
        $auth = $this->authenticateAdmin();
        $tenantId = $auth['tenant']->id;

        // Setup accounts
        Account::factory()->create(['tenant_id' => $tenantId, 'name' => 'Cash', 'type' => AccountType::ASSET]);
        Account::factory()->create(['tenant_id' => $tenantId, 'name' => 'Accounts Receivable', 'type' => AccountType::ASSET]);

        $invoice = Invoice::factory()->create(['tenant_id' => $tenantId, 'amount' => 100, 'status' => InvoiceStatus::UNPAID]);

        $response = $this->postJson('/api/payments', [
            'invoice_id' => $invoice->id,
            'amount' => 100,
            'payment_date' => now()->toDateTimeString(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'status' => InvoiceStatus::PAID->value]);
        $this->assertDatabaseHas('journal_entry_lines', ['debit' => 100]); // Cash Debit
    }
}
