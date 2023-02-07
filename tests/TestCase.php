<?php

namespace Tests;

use App\Charter;
use App\Console\Kernel;
use App\Contracts\DatabaseManager;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $landlordConnectionName = config('landlord.db_connection');
        $teamConnectionName = config('team.db_connection', 'team');

        Charter::manageDatabasesUsing(FakeDatabaseManager::class);


        config(['database.connections.' . $landlordConnectionName => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],
            // 'database.connections.'
            // . $teamConnectionName =>
            //     app(DatabaseManager::class)
            //     ->makeConnectionConfig(
            //         config('database.connections.' . $teamConnectionName),
            //         'tests_team'
            //     ),
        ]);

        $this->artisan("migrate --database={$landlordConnectionName} --path=database/migrations/landlord");
        $this->artisan('migrate --database=' . $teamConnectionName);

        $this->app[Kernel::class]->setArtisan(null);
    }
}
