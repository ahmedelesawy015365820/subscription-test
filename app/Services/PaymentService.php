<?php

namespace App\Services;

use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Dtos\PaymentDTO;
use App\Enums\InvoiceStatus;
use Carbon\Carbon;

class PaymentService extends BaseService
{
    protected PaymentRepositoryInterface $paymentRepository;
    protected InvoiceRepositoryInterface $invoiceRepository;
    protected AccountingService $accountingService;

    public function __construct(
        PaymentRepositoryInterface $paymentRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        AccountingService $accountingService
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->accountingService = $accountingService;
    }

    public function getAllPayments()
    {
        return $this->paymentRepository->all();
    }

    public function getPayment($id)
    {
        return $this->paymentRepository->find($id);
    }

    public function processPayment(PaymentDTO $dto)
    {
        return $this->execute(function () use ($dto) {
            $data = $dto->toArray();

            if (!isset($data['payment_date'])) {
                $data['payment_date'] = Carbon::now();
            }

            // 1. Record payment
            $payment = $this->paymentRepository->create($data);

            // 2. Update invoice status
            $invoice = $this->invoiceRepository->find($data['invoice_id']);
            if ($invoice && $invoice->status !== InvoiceStatus::PAID->value) {
                $this->invoiceRepository->update($invoice->id, [
                    'status' => InvoiceStatus::PAID->value
                ]);
            }

            // 3. Trigger accounting entry (Debit: Cash, Credit: Accounts Receivable)
            $cashAccount = $this->accountingService->getOrCreateAccount('Cash', 'Asset');
            $arAccount = $this->accountingService->getOrCreateAccount('Accounts Receivable', 'Asset');

            $this->accountingService->createJournalEntry("Payment received for Invoice #{$invoice->id}", [
                [
                    'account_id' => $cashAccount->id,
                    'debit' => $data['amount'],
                    'credit' => 0
                ],
                [
                    'account_id' => $arAccount->id,
                    'debit' => 0,
                    'credit' => $data['amount']
                ]
            ]);

            return $payment;
        });
    }
}
