<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\PaymentRequest;
use App\Services\PaymentService;
use App\Dtos\PaymentDTO;
use Illuminate\Http\JsonResponse;

class PaymentController extends BaseController
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\Payment::class);
        $payments = $this->paymentService->getAllPayments();
        return $this->responseJson($payments, 'Payments retrieved successfully.');
    }

    public function store(PaymentRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Payment::class);
        $dto = new PaymentDTO($request->validated());
        $payment = $this->paymentService->processPayment($dto);

        return $this->responseJson($payment, 'Payment processed successfully.', 201);
    }

    public function show($id): JsonResponse
    {
        $payment = $this->paymentService->getPayment($id);

        if (!$payment) {
            return $this->responseJson(null, 'Payment not found.', 404);
        }

        $this->authorize('view', $payment);

        return $this->responseJson($payment, 'Payment retrieved successfully.');
    }
}
