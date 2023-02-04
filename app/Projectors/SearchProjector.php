<?php

namespace App\Projectors;

use App\Models\Search;
use App\Models\Searchable;
use App\StorableEvents\SearchCreated;
use App\StorableEvents\SearchUpdated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class SearchProjector extends Projector
{
    public function onSearchCreated(SearchCreated $event)
    {
        $search = Search::forceCreate([
            'name' => $event->name,
        ]);

        $searchableData = [
            'searchable_type' => $event->searchableType,
            'searchable_uuid' => $event->searchableUuid,
            'search_uuid' => $search->uuid,
            'user_uuid' => $event->userUuid,
        ];

        $searchable = Searchable::forceCreate($searchableData);
    }

    public function onSearchUpdated(SearchUpdated $event)
    {
        $search = Search::where('uuid', $event->searchUuid)->first();

        $data = [
            'name' => $event->name,
            'term' => $event->term,
            'operator' => $event->operator,
            'key' => $event->key,
            'driver' => 'mysql',
            'description' => $event->description,
            'raw_query' => $event->rawQuery,
            'type' => $event->type,
        ];

        $search->forceFill($data)->save();
    }
}
