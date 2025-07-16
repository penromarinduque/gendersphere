<?php

namespace App\Policies;

use App\Models\GadActivity;
use App\Models\PlanBudget;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GadActivityPolicy
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
    public function view(User $user, GadActivity $gadActivity): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, PlanBudget $planBudget): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $planBudget->office_id == $user->office_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GadActivity $gadActivity): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $gadActivity->plan_budget->office_id == $user->office_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GadActivity $gadActivity): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $gadActivity->plan_budget->office_id == $user->office_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GadActivity $gadActivity): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GadActivity $gadActivity): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $gadActivity->plan_budget->office_id == $user->office_id;
    }
}
