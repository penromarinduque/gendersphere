<?php

namespace App\Policies;

use App\Models\ActivityDetail;
use App\Models\Attendee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendeePolicy
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
    public function view(User $user, Attendee $attendee): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ActivityDetail $activityDetail): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $user->office_id == $activityDetail->gad_activity->plan_budget->office_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendee $attendee): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $user->office_id == $attendee->activity_detail->gad_activity->plan_budget->office_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendee $attendee): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $user->office_id == $attendee->activityDetail->gad_activity->plan_budget->office_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attendee $attendee): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attendee $attendee): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $user->office_id == $attendee->activity_detail->gad_activity->plan_budget->office_id;
    }
}
