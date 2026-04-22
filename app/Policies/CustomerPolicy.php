<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Customer $customer): bool
    {
        return $user->tenant_id === $customer->tenant_id;
    }

    public function create(User $user): bool
    {
        return true; // Any user in tenant can create
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->tenant_id === $customer->tenant_id;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->tenant_id === $customer->tenant_id && $user->role === UserRole::ADMIN;
    }
}
