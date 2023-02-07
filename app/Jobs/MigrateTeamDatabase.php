<?php

namespace App\Jobs;

use App\Actions\Charter\ArtisanTeamDatabaseMigrate;
use App\Contracts\MigratesTeamDatabase;
use App\Models\TeamDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MigrateTeamDatabase implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected string $teamDatabaseUuid,
        protected array $options = []
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $teamDatabase = TeamDatabase::whereUuid($this->teamDatabaseUuid)->firstOrFail();

        $options = array_merge([
            'db' => $teamDatabase->id,
        ], $this->options);

        /** @var \App\Contracts\MigratesTeamDatabase $migrator */
        $migrator = app()->make(MigratesTeamDatabase::class);
        $migrator->migrate($options);
    }
}
