<?php

namespace App\Models\StoredEvents;

use App\Models\UsesLandlordConnection;

use Spatie\EventSourcing\Snapshots\EloquentSnapshot as SpatieEloquentSnapshot;

class EloquentSnapshot extends SpatieEloquentSnapshot
{
    use UsesLandlordConnection;
}
