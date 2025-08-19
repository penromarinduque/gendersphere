<?php

namespace App\Policies;

use App\Models\ActivityDetailReport;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActivityDetailReportPolicy
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
    public function view(User $user, ActivityDetailReport $activityDetailReport): bool
    {
        //
        return $user->roles->contains(function($role) {
            return $role->role_type == 'encoder' || $role->role_type == 'viewer';
        }) 
        && $user->office_id == $activityDetailReport->activityDetail->gad_activity->plan_budget->office_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->roles->contains(function($role) {
            return $role->role_type == 'encoder' ;
        }) ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActivityDetailReport $activityDetailReport): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActivityDetailReport $activityDetailReport): bool
    {
        //
        return $user->roles->contains(function($role) {
            return $role->role_type == 'encoder';
        }) 
        && $user->office_id == $activityDetailReport->activityDetail->gad_activity->plan_budget->office_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActivityDetailReport $activityDetailReport): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActivityDetailReport $activityDetailReport): bool
    {
        //
        return $user->roles->contains(function($role) {
            return $role->role_type == 'encoder';
        }) 
        && $user->office_id == $activityDetailReport->activityDetail->gad_activity->plan_budget->office_id;
    }
}
