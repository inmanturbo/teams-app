<?php

namespace App\Console\Commands;

use App\Models\TeamDatabase;
use Illuminate\Console\Command;

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
        $this->line("Showing team database #{$db->id} ({$db->name}) for {$db->user->currentTeam->name}");
        $this->line('-----------------------------------------');
        $this->line('');

        $options = ['--database' => 'team'];

        $this->call(
            'db:show',
            $options
        );
    }
}
