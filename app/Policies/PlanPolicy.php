<?php

namespace App\Policies;

use App\Models\Plan;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Access\Response;

class PlanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Filtered by Global Scope
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Plan $plan): bool
    {
        return $user->tenant_id === $plan->tenant_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Plan $plan): bool
    {
        return $user->tenant_id === $plan->tenant_id && $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Plan $plan): bool
    {
        return $user->tenant_id === $plan->tenant_id && $user->role === UserRole::ADMIN;
    }
}
