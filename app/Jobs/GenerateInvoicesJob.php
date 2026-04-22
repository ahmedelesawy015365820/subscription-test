<?php

namespace App\Jobs;

use App\Services\InvoiceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerateInvoicesJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(InvoiceService $invoiceService): void
    {
        try {
            $invoices = $invoiceService->generateInvoices();
            Log::info('[GenerateInvoicesJob] Generated ' . count($invoices) . ' invoices.');
        } catch (\Throwable $e) {
            Log::error('[GenerateInvoicesJob] Failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
