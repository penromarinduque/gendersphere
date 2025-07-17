<?php

namespace App\Policies;

use App\Models\FrontlineService;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FrontlineServicePolicy
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
    public function view(User $user, FrontlineService $frontlineService): bool
    {
        //
    }

    /**
     * Determine whether the user can view the sex aggregated data report.
     */
    public function viewSexAggregatedDataReport(User $user): bool
    {
        //
        return $user->roles->contains('role_type', 'viewer');
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
    public function update(User $user, FrontlineService $frontlineService): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $user->office_id == $frontlineService->office_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FrontlineService $frontlineService): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $user->office_id == $frontlineService->office_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FrontlineService $frontlineService): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FrontlineService $frontlineService): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder') && $user->office_id == $frontlineService->office_id;
    }
}
