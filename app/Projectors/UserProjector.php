<?php

namespace App\Projectors;

use App\Aggregates\TeamAggregate;
use App\Models\Team;
use App\Models\User;
use App\Models\UserType;
use App\StorableEvents\MainUserUpdated;
use App\StorableEvents\UserCreated;
use App\StorableEvents\UserDeleted;
use App\StorableEvents\UserPasswordUpdated;
use App\StorableEvents\UserProfileUpdated;
use App\StorableEvents\UserPromoCodeEntered;
use App\StorableEvents\UserSwitchedTeam;
use App\StorableEvents\UserTypeUpdated;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UserProjector extends Projector
{
    public function onUserPromoCodeEntered(UserPromoCodeEntered $event)
    {
        $user = User::whereUuid($event->userUuid)->firstOrFail();

        $user->forceFill([
            'trial_ends_at' => $event->createdAt()->addDays(config('charter.trial_days')),
        ])->save();
    }

    public function onUserCreated(UserCreated $event)
    {
        $user = User::forceCreate([
            'uuid' => $event->userUuid,
            'name' => $event->name,
            'email' => $event->email,
            'password' => $this->hashPassword($event->password),
            'type' => User::count() === 0 ? UserType::SuperAdmin : UserType::User,
        ]);

        $teamUuid = $event->teamUuid ?
            $event->teamUuid :
            Str::uuid();

        if ($event->withPersonalTeam) {
            $this->withPersonalTeam(
                userUuid: $user->uuid,
                userName: $user->name,
                teamUuid: $teamUuid,
                teamDatabaseUuid: $event->teamDatabaseUuid,
            );
        }
    }

    public function onUserProfileUpdated(UserProfileUpdated $event)
    {
        $user = User::whereUuid($event->userUuid)->first();

        // if (
        //     $event->email !== $user->email &&
        //     $user instanceof MustVerifyEmail
        // ) {
        //     $this->updateVerifiedUser($user, $event);
        // } else {
        $user->forceFill([
                'name' => $event->name,
                'email' => $event->email,
            ])->save();
        // }
    }

    public function onUserPasswordUpdated(UserPasswordUpdated $event)
    {
        $user = User::whereUuid($event->userUuid)->first();

        $user->forceFill([
            'password' => $this->hashPassword($event->password),
        ])->save();
    }

    public function onUserDeleted(UserDeleted $event)
    {
        $user = User::whereUuid($event->userUuid)->first();
        $user->deleteProfilePhoto();
        // $user->connectedAccounts->each->delete();
        $user->tokens->each->delete();
        $user->delete();
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array  $input
     */
    protected function updateVerifiedUser(MustVerifyEmail $user, UserProfileUpdated $event): void
    {
        $user->forceFill([
            'name' => $event->name,
            'email' => $event->email,
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    private function withPersonalTeam($userUuid, $userName, $teamUuid, $teamDatabaseUuid, $teamName = null)
    {
        $teamName = $teamName ?: explode(' ', $userName, 2)[0] . "'s Team";

        $teamAggregate = TeamAggregate::retrieve($teamUuid);

        $teamAggregate->createTeam(
            name: $teamName,
            ownerUuid: $userUuid,
            personalTeam: true,
            teamDatabaseUuid: $teamDatabaseUuid,
        )->persist();
    }

    public function onUserSwitchedTeam(UserSwitchedTeam $event)
    {
        $user = User::whereUuid($event->userUuid)->firstOrFail();
        $team = Team::whereUuid($event->teamUuid)->firstOrFail();

        $user->switchTeam($team);
    }

    public function onUserTypeUpdated(UserTypeUpdated $event)
    {
        $user = User::whereUuid($event->userUuid)->firstOrFail();

        $user->forceFill([
            'type' => $event->userType,
        ])->save();
    }

    protected function hashPassword(string $password)
    {
        return (strlen($password) === 60 && preg_match('/^\$2y\$/', $password)) ||
        (strlen($password) === 95 && preg_match('/^\$argon2i\$/', $password)) ?
            $password :
            Hash::make($password);
    }
}
