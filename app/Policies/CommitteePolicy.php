<?php

namespace App\Policies;

use App\Models\Committee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommitteePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->roles->contains(function($role) {
            return $role->role_type == 'encoder' || $role->role_type == 'viewer';
        });
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Committee $committee): bool
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
    public function update(User $user, Committee $committee): bool
    {
        //
        return $user->roles->contains(function($role) use ($committee) {
           return $role->role_type === 'encoder' && $role->office_id === $committee->office_id; 
        });
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Committee $committee): bool
    {
        //
        return $user->roles->contains(function($role) use ($committee) {
           return $role->role_type === 'encoder' && $role->office_id === $committee->office_id; 
        });
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Committee $committee): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Committee $committee): bool
    {
        //
        return $user->roles->contains(function($role) use ($committee) {
           return $role->role_type === 'encoder' && $role->office_id === $committee->office_id; 
        });
    }
}
