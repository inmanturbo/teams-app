<?php

namespace App\Contracts;

use App\Exceptions\NoConnectionSetException;

interface DatabaseManager
{
    /**
     * Create a database.
     */
    public function createDatabase($teamDatabase): bool;

    /**
     * Delete a database.
     */
    public function deleteDatabase($teamDatabase): bool;

    /**
     * Does a database exist.
     *
     * @param string $name
     * @return bool
     */
    public function databaseExists(string $name): bool;

    /**
     * Make a DB connection config array.
     *
     * @param array $baseConfig
     * @param string $databaseName
     * @return array
     */
    public function makeConnectionConfig(array $baseConfig, string $databaseName): array;

    /**
     * Set the DB connection that should be used by the tenant database manager.
     *
     * @throws NoConnectionSetException
     *
     * @param string $connection
     * @return void
     */
    public function setConnection(string $connection);
}
