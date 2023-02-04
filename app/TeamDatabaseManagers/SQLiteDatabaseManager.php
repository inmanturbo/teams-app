<?php

declare(strict_types=1);

namespace App\TeamDatabaseManagers;

use App\Contracts\DatabaseManager;
use App\Exceptions\NoConnectionSetException;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class SQLiteDatabaseManager implements DatabaseManager
{
    /** @var string */
    protected $connection;

    protected function database(): Connection
    {
        if ($this->connection === null) {
            throw new NoConnectionSetException(static::class);
        }
    
        return DB::connection($this->connection);
    }

    public function createDatabase($teamDatabase): bool
    {
        try {
            return file_put_contents(database_path($teamDatabase->name), '');
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteDatabase($teamDatabase): bool
    {
        try {
            return unlink(database_path($teamDatabase->name));
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getTables(): array
    {
        return $this->database()->getDoctrineSchemaManager()->listTableNames();
    }

    public function databaseExists(string $name): bool
    {
        return file_exists(database_path($name));
    }

    public function makeConnectionConfig(array $baseConfig, string $databaseName): array
    {
        $baseConfig['database'] = database_path($databaseName);

        return $baseConfig;
    }

    public function setConnection(string $connection)
    {
        $this->connection = $connection;

        return $this;
    }
}
