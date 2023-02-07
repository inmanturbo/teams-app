<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Link $link): bool
    {
        $teamIsCurrent = isset(app()['team']) && app('team')->id == $link->team->id;

        return $user->id == $link->user_id ||
        $teamIsCurrent && $user->ownsTeam($link->team) ||
        $teamIsCurrent && $user->hasTeamRole($link->team, 'admin') ||
        $teamIsCurrent && $user->hasTeamRole($link->team, $link->role);
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return $user->ownsTeam($user->currentTeam) ||
         $user->hasTeamRole($user->currentTeam, 'admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Link $link): bool
    {
        return $user->id == $link->user_id ||
        $user->ownsTeam($link->team) ||
        $user->hasTeamRole($link->team, 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Link $link): bool
    {
        return $this->update($user, $link);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Link $link): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Link $link): bool
    {
        //
    }
}
