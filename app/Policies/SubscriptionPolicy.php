<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Access\Response;

class SubscriptionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Subscription $subscription): bool
    {
        return $user->tenant_id === $subscription->tenant_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $user->tenant_id === $subscription->tenant_id;
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->tenant_id === $subscription->tenant_id && $user->role === UserRole::ADMIN;
    }

    public function cancel(User $user, Subscription $subscription): bool
    {
        return $user->tenant_id === $subscription->tenant_id && $user->role === UserRole::ADMIN;
    }

    public function activate(User $user, Subscription $subscription): bool
    {
        return $user->tenant_id === $subscription->tenant_id && $user->role === UserRole::ADMIN;
    }
}
