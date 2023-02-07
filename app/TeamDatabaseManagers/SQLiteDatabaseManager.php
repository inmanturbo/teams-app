<?php

declare(strict_types=1);

namespace App\TeamDatabaseManagers;

use App\Contracts\DatabaseManager;
use App\Exceptions\NoConnectionSetException;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function createDatabase($databaseName): bool
    {
        try {
            return $this->databaseResolver()->put($databaseName, '');
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteDatabase($databaseName): bool
    {
        try {
            return $this->databaseResolver()->delete($databaseName);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getTables(): array
    {
        return $this->database()->getDoctrineSchemaManager()->listTableNames();
    }

    public function databaseExists(string $databaseName): bool
    {
        return $this->databaseResolver()->exists($databaseName);
    }

    public function makeConnectionConfig(array $baseConfig, string $databaseName): array
    {
        $baseConfig['database'] = $this->resolveDatabaseName($databaseName);
      
        return $baseConfig;
    }

    public function setConnection(string $connection)
    {
        $this->connection = $connection;

        return $this;
    }

    public function resolveDatabaseName(string $databaseName): string
    {
        return $this->databaseResolver()->path($databaseName);
    }

    protected function databaseResolver()
    {
        return Storage::disk('team-database');
    }
}
