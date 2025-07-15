<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\PersonInfo;
use App\Models\User;

class PersonInfoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PersonInfo $personInfo): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PersonInfo $personInfo): bool
    {
        //
        return $user->roles->contains(function($role) use($personInfo) {
            return $role->role_type == 'encoder' && $role->office_id == $personInfo->office_id;
        });
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PersonInfo $personInfo): bool
    {
        //
        return $user->roles->contains(function($role) use($personInfo) {
            return $role->role_type == 'encoder' && $role->office_id == $personInfo->office_id;
        });
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PersonInfo $personInfo): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PersonInfo $personInfo): bool
    {
        //
        return $user->roles->contains(function($role) use($personInfo) {
            return $role->role_type == 'encoder' && $role->office_id == $personInfo->office_id;
        });
    }
}
