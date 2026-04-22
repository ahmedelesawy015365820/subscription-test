<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use App\Enums\UserRole;

class PaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Payment $payment): bool
    {
        return $user->tenant_id === $payment->tenant_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function delete(User $user, Payment $payment): bool
    {
        return $user->tenant_id === $payment->tenant_id && $user->role === UserRole::ADMIN;
    }
}
