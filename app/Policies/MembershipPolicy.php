<?php

namespace App\Policies;

use App\Models\Membership;
use App\Models\Team;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembershipPolicy
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
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Membership $membership)
    {
        //
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
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Membership $membership)
    {
        $team = Team::findOrFail($membership->team_id);
        $member = User::findOrFail($membership->user_id);

        if ($member->type === UserType::SuperAdmin && $user->type !== UserType::SuperAdmin) {
            return false;
        }

        return $user->ownsTeam($team) ||
        $user->hasTeamRole($team, 'admin') &&
        ! $member->hasTeamRole($team, 'admin') &&
        $member->id !== $user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function impersonate(User $user, Membership $membership)
    {
        return $this->update($user, $membership);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Membership $membership)
    {
        $team = Team::find($membership->team_id);
        $member = User::find($membership->user_id);

        return $user->ownsTeam($team) ||
        $member->id == $user->id ||
        $user->hasTeamRole($team, 'admin') &&
        ! $member->hasTeamRole($team, 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Membership $membership)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Membership $membership)
    {
        //
    }
}
