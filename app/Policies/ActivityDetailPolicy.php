<?php

namespace App\Policies;

use App\Models\ActivityDetail;
use App\Models\EncoderPermission;
use App\Models\GadActivity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActivityDetailPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ActivityDetail $activityDetail): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, GadActivity $gadActivity): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') 
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['PlanBudget']);
        })
        &&  $gadActivity->plan_budget->office_id == $user->office_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActivityDetail $activityDetail): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') 
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['PlanBudget']);
        })
        && $activityDetail->gad_activity->plan_budget->office_id == $user->office_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActivityDetail $activityDetail): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') 
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['PlanBudget']);
        })
        && $activityDetail->gad_activity->plan_budget->office_id == $user->office_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActivityDetail $activityDetail): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActivityDetail $activityDetail): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') 
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['PlanBudget']);
        })
        && $activityDetail->gad_activity->plan_budget->office_id == $user->office_id;
    }
}
