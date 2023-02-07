<?php

namespace App\Contracts;

interface MigratesTeamDatabase
{
    /**
     * Migrates a team database.
     *
     * @param  array  $options
     * @return void
     */
    public function migrate(array $options = []);
}
