<?php

namespace App\Services;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Dtos\CustomerDTO;

class CustomerService extends BaseService
{
    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAllCustomers()
    {
        return $this->customerRepository->all();
    }

    public function getCustomer($id)
    {
        return $this->customerRepository->find($id);
    }

    public function createCustomer(CustomerDTO $dto)
    {
        return $this->execute(function () use ($dto) {
            return $this->customerRepository->create($dto->toArray());
        });
    }

    public function updateCustomer($id, CustomerDTO $dto)
    {
        return $this->execute(function () use ($id, $dto) {
            return $this->customerRepository->update($id, $dto->toArray());
        });
    }

    public function deleteCustomer($id)
    {
        return $this->execute(function () use ($id) {
            return $this->customerRepository->delete($id);
        });
    }
}
