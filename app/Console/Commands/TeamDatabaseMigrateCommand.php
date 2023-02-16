<?php

namespace App\Console\Commands;

use App\Models\TeamDatabase;
use Illuminate\Console\Command;

class TeamDatabaseMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'team-db:migrate {db?} {--fresh : Wipe the database} {--seed : Seed the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the database for the specified team database, or all team databases if none is specified.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->argument('db')) {
            $this->migrate(
                $database = TeamDatabase::whereId($this->argument('db'))->firstOrFail()
            );
        } else {
            TeamDatabase::all()->each(
                fn ($db) => $this->migrate($db)
            );
        }
    }

    protected function migrate($db)
    {
        $db->configure()->use();

        $this->line('');
        $this->line('-----------------------------------------');
        $this->line("Migrating team database #{$db->id} ({$db->name})");
        $this->line('-----------------------------------------');
        $this->line('');

        $options = [
            '--database' => is_null($db->driver) ? config('team.db_connection', 'team') : ($db->driver === 'sqlite' ? 'team_sqlite' : 'team'),
        ];

        if ($this->option('seed')) {
            $options['--seed'] = true;
        }

        $this->call(
            $this->option('fresh') ? 'migrate:fresh' : 'migrate',
            $options
        );
    }
}
