<?php

declare(strict_types=1);

namespace Tests;

use App\Contracts\DatabaseManager;

class FakeDatabaseManager implements DatabaseManager
{
    public function createDatabase($teamDatabase): bool
    {
        return true;
    }

    public function deleteDatabase($teamDatabase): bool
    {
        return true;
    }

    public function databaseExists(string $name): bool
    {
        return false;
    }

    public function makeConnectionConfig(array $baseConfig, string $databaseName): array
    {
        $baseConfig['database'] = database_path($databaseName);

        return $baseConfig;
    }

    public function setConnection(string $connection)
    {
        return $this;
    }
}
