<?php

namespace App\Policies;

use App\Models\CommitteePosition;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommitteePositionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        $roles = $user->roles;
        if(!$roles->contains('role_type', 'admin')) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CommitteePosition $committeePosition): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CommitteePosition $committeePosition): bool
    {
        //
        return $user->roles->contains(function ($role) use ($committeePosition) {
            return $role->role_type === 'admin' && $role->office_id === $committeePosition->office_id;
        });
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CommitteePosition $committeePosition): bool
    {
        //
        return $user->roles->contains(function ($role) use ($committeePosition) {
            return $role->role_type === 'admin' && $role->office_id === $committeePosition->office_id;
        });
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CommitteePosition $committeePosition): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CommitteePosition $committeePosition): bool
    {
        //
    }
}
