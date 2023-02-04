<?php

namespace App\Actions\Charter;

use App\Contracts\MigratesTeamDatabase;
use Illuminate\Support\Facades\Artisan;

class ArtisanTeamDatabaseMigrate implements MigratesTeamDatabase
{
    public function migrate(array $options = [])
    {
        $artisan = Artisan::call('team-db:migrate', $options);

        return $artisan;
    }
}
