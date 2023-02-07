<?php

namespace App\Projectors;

use App\Contracts\DatabaseManager;
use App\Jobs\MigrateTeamDatabase;
use App\Models\User;
use App\StorableEvents\TeamDatabaseCreated;
use App\TeamDatabaseManagers\MySQLDatabaseManager;
use App\TeamDatabaseManagers\SQLiteDatabaseManager;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TeamDatabaseProjector extends Projector
{
    public function onTeamDatabaseCreated(TeamDatabaseCreated $event)
    {
        $user = User::where('uuid', $event->userUuid)->firstOrFail();

        $connection = is_null($event->driver) ? config('team.db_connection', 'team') : ($event->driver === 'sqlite' ? 'team_sqlite' : 'team');

        $teamDatabase = $user->teamDatabases()->firstOrCreate(
            [
                'name' => $event->name,
            ],
            [
                'name' => $event->name,
                'uuid' => $event->databaseUuid,
                'user_id' => $user->id,
                'driver' => $event->driver ?? config("database.connections.{$connection}.driver"),
            ]
        );

        $migrationOptions = [];

        $databaseDriver = app()->runningUnitTests() ? 'testing' : $teamDatabase->driver;

        switch ($databaseDriver) {
            case 'sqlite':
                $databaseManager = new SQLiteDatabaseManager;
                break;
            case 'mysql':
                $databaseManager = new MySQLDatabaseManager;
                break;
            default:
                $databaseManager = app(DatabaseManager::class);

        }

        $databaseManager->setConnection($connection);

        if (! $databaseManager->databaseExists($teamDatabase->name)) {
            $migrationOptions['--fresh'] = true;
            $migrationOptions['--seed'] = true;
        }

        $databaseManager->createDatabase($teamDatabase->name);

        MigrateTeamDatabase::dispatch(
            teamDatabaseUuid: $teamDatabase->uuid,
            options: $migrationOptions,
        )->onQueue('migrations');
    }
}
