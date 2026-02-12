<?php

namespace App\Policies;

use App\Models\GenderIssue;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GenderIssuePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->roles->contains('role_type', 'admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GenderIssue $genderIssue): bool
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
    public function update(User $user, GenderIssue $genderIssue): bool
    {
        //
        return $user->roles->contains(function($role) use($genderIssue) {
            return $role->role_type === 'admin' && $role->office_id === $genderIssue->office_id;
        });
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GenderIssue $genderIssue): bool
    {
        //
        return $user->roles->contains(function($role) use($genderIssue) {
            return $role->role_type === 'admin' && $role->office_id === $genderIssue->office_id;
        });
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GenderIssue $genderIssue): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GenderIssue $genderIssue): bool
    {
        //
        return $user->roles->contains(function($role) use($genderIssue) {
            return $role->role_type === 'admin' && $role->office_id === $genderIssue->office_id;
        });
    }
}
