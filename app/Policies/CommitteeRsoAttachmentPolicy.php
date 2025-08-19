<?php

namespace App\Policies;

use App\Models\CommitteeRsoAttachment;
use App\Models\EncoderPermission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommitteeRsoAttachmentPolicy
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
    public function view(User $user, CommitteeRsoAttachment $committeeRsoAttachment): bool
    {
        //
        return $user->roles->contains(function($role) {
            return $role->role_type == 'encoder' || $role->role_type == 'viewer';
        }) 
        && $user->office_id == $committeeRsoAttachment->office_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->roles->contains('role_type', 'encoder')
        && $user->roles->contains(function($role) {
            return $role->encoderPermissions->contains('permission', EncoderPermission::PERMISSION['Committee']);
        });
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CommitteeRsoAttachment $committeeRsoAttachment): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CommitteeRsoAttachment $committeeRsoAttachment): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CommitteeRsoAttachment $committeeRsoAttachment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CommitteeRsoAttachment $committeeRsoAttachment): bool
    {
        //
    }
}
