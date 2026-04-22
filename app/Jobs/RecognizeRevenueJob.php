<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\AccountingService;
use App\Enums\InvoiceStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class RecognizeRevenueJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(AccountingService $accountingService): void
    {
        try {
            // Get all paid invoices to recognize revenue
            $paidInvoices = Invoice::where('status', InvoiceStatus::PAID->value)->get();

            $count = 0;
            foreach ($paidInvoices as $invoice) {
                // Scenario: Deferred Revenue -> Subscription Revenue
                $deferredAccount = $accountingService->getOrCreateAccount('Deferred Revenue', 'Liability');
                $revenueAccount = $accountingService->getOrCreateAccount('Subscription Revenue', 'Revenue');

                $accountingService->createJournalEntry("Revenue recognition for Invoice #{$invoice->id}", [
                    [
                        'account_id' => $deferredAccount->id,
                        'debit' => $invoice->amount,
                        'credit' => 0
                    ],
                    [
                        'account_id' => $revenueAccount->id,
                        'debit' => 0,
                        'credit' => $invoice->amount
                    ]
                ]);

                $count++;
            }

            Log::info('[RecognizeRevenueJob] Revenue recognized for ' . $count . ' invoices.');
        } catch (\Throwable $e) {
            Log::error('[RecognizeRevenueJob] Failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
