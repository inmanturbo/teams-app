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
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Membership $membership): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Membership $membership): bool
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
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function impersonate(User $user, Membership $membership)
    {
        return $this->update($user, $membership);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Membership $membership): bool
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
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Membership $membership): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Membership $membership): bool
    {
        //
    }
}
