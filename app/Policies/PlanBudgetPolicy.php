<?php

namespace App\Policies;

use App\Models\EncoderPermission;
use App\Models\PlanBudget;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlanBudgetPolicy
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
     * Determine whether the user can view accomplishment report.
     */
    public function viewAccomplishmentReport(User $user): bool
    {
        //
        return $user->roles->contains(function($role) {
            return $role->role_type == 'encoder' || $role->role_type == 'viewer';
        });
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanBudget $planBudget): bool
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
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['PersonInfo']);
        });
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlanBudget $planBudget): bool
    {
        //
        return $user->roles->contains(function($role) use($planBudget) {
            return $role->role_type == 'encoder' && $role->office_id == $planBudget->office_id; 
        })
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['PersonInfo']);
        });
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanBudget $planBudget): bool
    {
        //
        return $user->roles->contains(function($role) use($planBudget) {
            return $role->role_type == 'encoder' && $role->office_id == $planBudget->office_id; 
        })
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['PersonInfo']);
        });
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PlanBudget $planBudget): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PlanBudget $planBudget): bool
    {
        //
        return $user->roles->contains(function($role) use($planBudget) {
            return $role->role_type == 'encoder' && $role->office_id == $planBudget->office_id; 
        })
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['PersonInfo']);
        });
    }
}
