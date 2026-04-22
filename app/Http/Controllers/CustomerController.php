<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CustomerRequest;
use App\Services\CustomerService;
use App\Dtos\CustomerDTO;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\Customer::class);
        $customers = $this->customerService->getAllCustomers();
        return $this->responseJson($customers, 'Customers retrieved successfully.');
    }

    public function store(CustomerRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Customer::class);
        $dto = new CustomerDTO($request->validated());
        $customer = $this->customerService->createCustomer($dto);

        return $this->responseJson($customer, 'Customer created successfully.', 201);
    }

    public function show($id): JsonResponse
    {
        $customer = $this->customerService->getCustomer($id);

        if (!$customer) {
            return $this->responseJson(null, 'Customer not found.', 404);
        }

        $this->authorize('view', $customer);

        return $this->responseJson($customer, 'Customer retrieved successfully.');
    }

    public function update(CustomerRequest $request, $id): JsonResponse
    {
        $customer = $this->customerService->getCustomer($id);
        if (!$customer) {
            return $this->responseJson(null, 'Customer not found.', 404);
        }

        $this->authorize('update', $customer);

        $dto = new CustomerDTO($request->validated());
        $updated = $this->customerService->updateCustomer($id, $dto);

        return $this->responseJson(null, 'Customer updated successfully.');
    }

    public function destroy($id): JsonResponse
    {
        $customer = $this->customerService->getCustomer($id);
        if (!$customer) {
            return $this->responseJson(null, 'Customer not found.', 404);
        }

        $this->authorize('delete', $customer);

        $this->customerService->deleteCustomer($id);

        return $this->responseJson(null, 'Customer deleted successfully.');
    }
}
