<?php

declare(strict_types=1);

namespace App\TeamDatabaseManagers;

use App\Contracts\DatabaseManager;
use App\Exceptions\NoConnectionSetException;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class MySQLDatabaseManager implements DatabaseManager
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

    public function setConnection(string $connection)
    {
        $this->connection = $connection;

        return $this;
    }

    public function getTables(): array
    {
        return $this->database()->getDoctrineSchemaManager()->listTableNames();
    }

    public function createDatabase($databaseName): bool
    {
        $charset = $this->database()->getConfig('charset');
        $collation = $this->database()->getConfig('collation');

        return $this->database()->statement("CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET `$charset` COLLATE `$collation`");
    }

    public function deleteDatabase($databaseName): bool
    {
        return $this->database()->statement("DROP DATABASE IF EXISTS `{$databaseName}`");
    }

    public function databaseExists(string $databaseName): bool
    {
        return (bool) $this->database()->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$databaseName}'");
    }

    public function makeConnectionConfig(array $baseConfig, string $databaseName): array
    {
        $baseConfig['database'] = $databaseName;

        return $baseConfig;
    }
}
