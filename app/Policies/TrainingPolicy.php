<?php

namespace App\Policies;

use App\Models\EncoderPermission;
use Illuminate\Auth\Access\Response;
use App\Models\Training;
use App\Models\User;

class TrainingPolicy
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
    public function view(User $user, Training $training): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder')
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['Training']);
        });
    }

    /**
     * Determine whether the user can view the employee list report.
     */
 /*    public function viewEmployeeReport(User $user): bool
    {
        //
        return $user->roles->contains(function($role) {
            return $role->role_type == 'encoder' || $role->role_type == 'viewer';
        });
    }
 */


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Training $training): bool
    {
        //
        return $user->roles->contains(function($role) use($training) {
            return $role->role_type == 'encoder' && $role->office_id == $training->office_id;
        })
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['Training']);
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
        })
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['Training']);
        });
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Training $training): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Training $training): bool
    {
        //
        return $user->roles->contains(function($role) use($training) {
            return $role->role_type == 'encoder' && $role->office_id == $training->office_id;
        })
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['Training']);
        });
    }
}