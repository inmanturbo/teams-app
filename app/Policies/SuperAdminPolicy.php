<?php

namespace App\Policies;

use App\Models\SuperAdmin;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuperAdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SuperAdmin $superAdmin)
    {
        if ($superAdmin->type === UserType::SuperAdmin && $user->type !== UserType::SuperAdmin) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SuperAdmin  $superAdmin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SuperAdmin $superAdmin)
    {
        //
    }
}
