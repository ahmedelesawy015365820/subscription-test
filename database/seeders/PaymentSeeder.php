<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Payment;
use App\Enums\InvoiceStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Pay the first invoice for each tenant to simulate real data
        $invoices = Invoice::where('status', InvoiceStatus::UNPAID->value)->get();

        foreach ($invoices as $index => $invoice) {
            // Only pay every other invoice to leave some unpaid
            if ($index % 2 !== 0) continue;

            // Record payment
            Payment::create([
                'tenant_id'    => $invoice->tenant_id,
                'invoice_id'   => $invoice->id,
                'amount'       => $invoice->amount,
                'payment_date' => Carbon::now(),
            ]);

            // Update invoice status
            $invoice->update(['status' => InvoiceStatus::PAID->value]);

            // Accounting entry: Debit Cash / Credit AR
            $cashAccount = Account::where('tenant_id', $invoice->tenant_id)
                ->where('name', 'Cash')->first();
            $arAccount = Account::where('tenant_id', $invoice->tenant_id)
                ->where('name', 'Accounts Receivable')->first();

            if ($cashAccount && $arAccount) {
                $entry = JournalEntry::create([
                    'tenant_id'   => $invoice->tenant_id,
                    'description' => "Payment received for Invoice #{$invoice->id}",
                    'date'        => Carbon::now(),
                ]);

                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $cashAccount->id,
                    'debit'            => $invoice->amount,
                    'credit'           => 0,
                ]);

                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $arAccount->id,
                    'debit'            => 0,
                    'credit'           => $invoice->amount,
                ]);
            }
        }
    }
}
