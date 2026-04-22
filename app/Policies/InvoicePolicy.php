<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use App\Enums\UserRole;

class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $user->tenant_id === $invoice->tenant_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->tenant_id === $invoice->tenant_id;
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->tenant_id === $invoice->tenant_id && $user->role === UserRole::ADMIN;
    }

    public function generate(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
