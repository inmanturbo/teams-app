<?php

namespace App\Console\Commands;

use App\Models\TeamDatabase;
use Illuminate\Console\Command;

class TeamDatabaseTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'team-db:table {db?} {--table=} {--json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show table info for the specified team database, or all team databases if none is specified.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->argument('db')) {
            $this->show(
                $database = TeamDatabase::whereId($this->argument('db'))->firstOrFail()
            );
        } else {
            TeamDatabase::all()->each(
                fn ($db) => $this->show($db)
            );
        }
    }

    protected function show($db)
    {
        $db->configure()->use();

        $this->line('');
        $this->line('-----------------------------------------');
        $this->line("Showing team database table for #{$db->id} ({$db->name}) for Team: {$db->user->currentTeam->name}");
        $this->line('-----------------------------------------');
        $this->line('');

        $options = [
            '--database' => is_null($db->driver) ? config('team.db_connection', 'team') : ($db->driver === 'sqlite' ? 'team_sqlite' : 'team'),
        ];

        if ($this->option('table')) {
            $options['table'] = $this->option('table');
        }
        
        if ($this->option('json')) {
            $options['--json'] = true;
        }

        $this->call(
            'db:table',
            $options
        );
    }
}
