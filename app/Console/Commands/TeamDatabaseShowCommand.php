<?php

namespace App\Console\Commands;

use App\Models\TeamDatabase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TeamDatabaseShowCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'team-db:show {db?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show info for the specified team database, or all team databases if none is specified.';

    /**
     * Execute the console command.
     */
    public function handle(): int
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
        $this->line("Showing team database #{$db->id} ({$db->name}) for {$db->user->currentTeam->name}");
        $this->line('-----------------------------------------');
        $this->line('');
        
        $options = [
            '--database' => is_null($db->driver) ? config('team.db_connection', 'team') : ($db->driver === 'sqlite' ? 'team_sqlite' : 'team'),
        ];

        $this->call(
            'db:show',
            $options
        );
    }
}
