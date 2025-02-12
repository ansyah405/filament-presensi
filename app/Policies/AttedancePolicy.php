<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attedance;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttedancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_attedance');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attedance $attedance): bool
    {
        return $user->can('view_attedance');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_attedance');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attedance $attedance): bool
    {
        return $user->can('update_attedance');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attedance $attedance): bool
    {
        return $user->can('delete_attedance');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_attedance');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Attedance $attedance): bool
    {
        return $user->can('force_delete_attedance');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_attedance');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Attedance $attedance): bool
    {
        return $user->can('restore_attedance');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_attedance');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Attedance $attedance): bool
    {
        return $user->can('replicate_attedance');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_attedance');
    }
}
