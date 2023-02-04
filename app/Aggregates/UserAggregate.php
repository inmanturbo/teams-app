<?php

namespace App\Aggregates;

use App\StorableEvents\UserCreated;
use App\StorableEvents\UserDeleted;
use App\StorableEvents\UserPasswordUpdated;
use App\StorableEvents\UserProfileUpdated;
use App\StorableEvents\UserPromoCodeEntered;
use App\StorableEvents\UserSwitchedTeam;
use App\StorableEvents\UserTypeUpdated;
use Illuminate\Support\Facades\Hash;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class UserAggregate extends AggregateRoot
{
    public function createUser(
        string $name,
        string $email,
        string $password,
        ?bool  $withPersonalTeam = false,
        ?string $teamUuid = null,
        ?string $teamName = null,
    ) {
        $password = (strlen($password) === 60 && preg_match('/^\$2y\$/', $password)) ||
        (strlen($password) === 95 && preg_match('/^\$argon2i\$/', $password)) ?
            $password :
            Hash::make($password);
        $this->recordThat(
            new UserCreated(
                userUuid: $this->uuid(),
                name: $name,
                email: $email,
                password: $password,
                withPersonalTeam: $withPersonalTeam,
                teamUuid: $teamUuid,
                teamName: $teamName,
            )
        );

        return $this;
    }

    public function updateUserProfile(
        string $name,
        string $email,
        ?string $profilePhotoPath = null,
    ) {
        $this->recordThat(
            new UserProfileUpdated(
                userUuid: $this->uuid(),
                name: $name,
                email: $email,
                profilePhotoPath: $profilePhotoPath,
            )
        );

        return $this;
    }

    public function updateUserPassword(
        string $password,
    ) {
        $this->recordThat(
            new UserPasswordUpdated(
                userUuid: $this->uuid(),
                password: $password,
            )
        );

        return $this;
    }

    public function deleteUser()
    {
        $this->recordThat(
            new UserDeleted(
                userUuid: $this->uuid(),
            )
        );

        return $this;
    }

    public function switchUserTeam(
        string $teamUuid,
    ) {
        $this->recordThat(
            new UserSwitchedTeam(
                userUuid: $this->uuid(),
                teamUuid: $teamUuid,
            )
        );

        return $this;
    }

    public function updateUserType(
        string $type,
    ) {
        $this->recordThat(
            new UserTypeUpdated(
                userUuid: $this->uuid(),
                userType: $type,
            )
        );

        return $this;
    }

    public function subscribeUserByPromoCode(
        string $promoCode,
    ) {
        $this->recordThat(
            new UserPromoCodeEntered(
                userUuid: $this->uuid(),
                promoCode: $promoCode,
            )
        );

        return $this;
    }
}
