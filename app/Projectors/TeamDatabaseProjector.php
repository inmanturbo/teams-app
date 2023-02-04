<?php

namespace App\Projectors;

use App\Contracts\DatabaseManager;
use App\Jobs\MigrateTeamDatabase;
use App\Models\User;
use App\StorableEvents\TeamDatabaseCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TeamDatabaseProjector extends Projector
{
    public function onTeamDatabaseCreated(TeamDatabaseCreated $event)
    {
        $user = User::where('uuid', $event->userUuid)->firstOrFail();

        $teamDatabase = $user->teamDatabases()->firstOrCreate(
            [
                'name' => $event->name,
            ],
            [
                'name' => $event->name,
                'uuid' => $event->databaseUuid,
                'user_id' => $user->id,
                'driver' => $event->driver ?? config('database.connections.team.driver'),
            ]
        );

        $migrationOptions = [];

        $databaseManager = app(DatabaseManager::class)->setConnection('team');

        if (! $databaseManager->databaseExists($teamDatabase->name)) {
            $migrationOptions['--fresh'] = true;
            $migrationOptions['--seed'] = true;
        }

        $databaseManager->createDatabase($teamDatabase);

        MigrateTeamDatabase::dispatch(
            teamDatabaseUuid: $teamDatabase->uuid,
            options: $migrationOptions,
        )->onQueue('migrations');
    }
}
