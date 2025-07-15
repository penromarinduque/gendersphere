<?php

namespace App\Policies;

use App\Models\FrontlineServiceType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FrontlineServiceTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FrontlineServiceType $frontlineServiceType): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FrontlineServiceType $frontlineServiceType): bool
    {
        //
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FrontlineServiceType $frontlineServiceType): bool
    {
        //
        return $user->is_super_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FrontlineServiceType $frontlineServiceType): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FrontlineServiceType $frontlineServiceType): bool
    {
        //
        return $user->is_super_admin;
    }
}
