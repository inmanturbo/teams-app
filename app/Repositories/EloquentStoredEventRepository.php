<?php

namespace App\Repositories;

use Auth;
use Carbon\Carbon;
use Spatie\EventSourcing\Enums\MetaData;
use Spatie\EventSourcing\EventSerializers\EventSerializer;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository as SpatieEloquentStoredEventRepository;
use Spatie\EventSourcing\StoredEvents\Repositories\StoredEventRepository;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Spatie\EventSourcing\StoredEvents\StoredEvent;

class EloquentStoredEventRepository extends SpatieEloquentStoredEventRepository implements StoredEventRepository
{
    public function persist(ShouldBeStored $event, string $uuid = null): StoredEvent
    {
        /** @var EloquentStoredEvent $eloquentStoredEvent */
        $eloquentStoredEvent = new $this->storedEventModel();

        $eloquentStoredEvent->setOriginalEvent($event);

        $createdAt = Carbon::now();

        $eloquentStoredEvent->setRawAttributes([
            'event_properties' => app(EventSerializer::class)->serialize(clone $event),
            'aggregate_uuid' => $uuid,
            'user_uuid' => $this->getUserUuid(),
            'owner_uuid' => $this->getOwnerUuid(),
            'team_uuid' => $this->getTeamUuid(),
            'aggregate_version' => $event->aggregateRootVersion(),
            'event_version' => $event->eventVersion(),
            'event_class' => $this->getEventClass(get_class($event)),
            'meta_data' => json_encode($event->metaData() + [
                MetaData::CREATED_AT => $createdAt->toDateTimeString(),
            ]),
            'created_at' => $createdAt,
        ]);

        $eloquentStoredEvent->save();

        $eloquentStoredEvent->meta_data->set(MetaData::STORED_EVENT_ID, $eloquentStoredEvent->id);

        $eloquentStoredEvent->save();

        $eloquentStoredEvent->event->setStoredEventId($eloquentStoredEvent->id);

        return $eloquentStoredEvent->toStoredEvent();
    }

    private function getEventClass(string $class): string
    {
        $map = config('event-sourcing.event_class_map', []);

        if (! empty($map) && in_array($class, $map)) {
            return array_search($class, $map, true);
        }

        return $class;
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
