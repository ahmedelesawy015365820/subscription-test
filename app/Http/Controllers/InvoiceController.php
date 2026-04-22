<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\InvoiceRequest;
use App\Services\InvoiceService;
use App\Dtos\InvoiceDTO;
use Illuminate\Http\JsonResponse;

class InvoiceController extends BaseController
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\Invoice::class);
        $invoices = $this->invoiceService->getAllInvoices();
        return $this->responseJson($invoices, 'Invoices retrieved successfully.');
    }

    public function store(InvoiceRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Invoice::class);
        $dto = new InvoiceDTO($request->validated());
        $invoice = $this->invoiceService->createInvoice($dto);

        return $this->responseJson($invoice, 'Invoice created successfully.', 201);
    }

    public function show($id): JsonResponse
    {
        $invoice = $this->invoiceService->getInvoice($id);

        if (!$invoice) {
            return $this->responseJson(null, 'Invoice not found.', 404);
        }

        $this->authorize('view', $invoice);

        return $this->responseJson($invoice, 'Invoice retrieved successfully.');
    }

    public function update(InvoiceRequest $request, $id): JsonResponse
    {
        $invoice = $this->invoiceService->getInvoice($id);
        if (!$invoice) {
            return $this->responseJson(null, 'Invoice not found.', 404);
        }

        $this->authorize('update', $invoice);

        $dto = new InvoiceDTO($request->validated());
        $updated = $this->invoiceService->updateInvoice($id, $dto);

        return $this->responseJson(null, 'Invoice updated successfully.');
    }

    public function destroy($id): JsonResponse
    {
        $invoice = $this->invoiceService->getInvoice($id);
        if (!$invoice) {
            return $this->responseJson(null, 'Invoice not found.', 404);
        }

        $this->authorize('delete', $invoice);

        $this->invoiceService->deleteInvoice($id);

        return $this->responseJson(null, 'Invoice deleted successfully.');
    }

    public function generateInvoices(): JsonResponse
    {
        $this->authorize('generate', \App\Models\Invoice::class);
        $invoices = $this->invoiceService->generateInvoices();

        return $this->responseJson([
            'count' => count($invoices),
            'invoices' => $invoices
        ], 'Invoices generated successfully.', 201);
    }
}
