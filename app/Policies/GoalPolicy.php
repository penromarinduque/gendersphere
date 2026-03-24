<?php

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GoalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->roles->contains('role_type', 'admin') || $user->roles->contains('role_type', 'encoder');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Goal $goal): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->roles->contains('role_type', 'admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Goal $goal): bool
    {
        //
        return $user->roles->contains(function ($role) use($goal) {
            return ($role->role_type === 'admin' || $role->role_type == 'encoder') && $role->office_id === $goal->office_id;
        });
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Goal $goal): bool
    {
        //
        return $user->roles->contains(function ($role) use($goal) {
            return ($role->role_type === 'admin' || $role->role_type == 'encoder') && $role->office_id === $goal->office_id;
        });
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Goal $goal): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Goal $goal): bool
    {
        //
        return $user->roles->contains(function ($role) use($goal) {
            return $role->role_type === 'admin' && $role->office_id === $goal->office_id;
        });
    }
}
