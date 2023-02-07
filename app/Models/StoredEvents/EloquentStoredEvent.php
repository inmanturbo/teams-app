<?php

namespace App\Models\StoredEvents;

use App\Models\UsesLandlordConnection;
use Illuminate\Support\Facades\Auth;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent as SpatieEloquentStoredEvent;
use Spatie\EventSourcing\StoredEvents\StoredEvent;

class EloquentStoredEvent extends SpatieEloquentStoredEvent
{
    use UsesLandlordConnection;

    public function toStoredEvent(): StoredEvent
    {
        $ownerUuid = $this->getOwnerUuid();
        $teamUuid = $this->getTeamUuid();
        $userUuid = $this->getUserUuid();

        return new StoredEvent([
            'id' => $this->id,
            'event_properties' => $this->event_properties,
            'user_uuid' => $this->user_uuid ?? $userUuid,
            'owner_uuid' => $this->owner_uuid ?? $ownerUuid,
            'team_uuid' => $this->team_uuid ?? $teamUuid,
            'aggregate_uuid' => $this->aggregate_uuid ?? '',
            'aggregate_version' => $this->aggregate_version ?? 0,
            'event_version' => $this->event_version,
            'event_class' => $this->event_class,
            'meta_data' => $this->meta_data,
            'created_at' => $this->created_at,
        ], $this->getOriginalEvent());
    }

    protected function getOwnerUuid(): ?string
    {
        if (! isset(Auth::user()->currentTeam)) {
            return null;
        }
        $user = Auth::user();
        if ($user->ownsTeam($user->currentTeam)) {
            return $user->uuid;
        }

        return $user->currentTeam->owner->uuid;
    }

    protected function getTeamUuid(): ?string
    {
        if (! isset(Auth::user()->currentTeam)) {
            return null;
        }

        return Auth::user()->currentTeam->uuid;
    }

    protected function getUserUuid(): ?string
    {
        if (! isset(Auth::user()->uuid)) {
            return null;
        }

        return Auth::user()->uuid;
    }
}
