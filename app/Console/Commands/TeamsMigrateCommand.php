<?php

namespace App\Console\Commands;

use App\Models\Team;
use Illuminate\Console\Command;

class TeamsMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teams:migrate {team?} {--fresh} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->argument('team')) {
            $this->migrate(
                Team::find($this->argument('team'))
            );
        } else {
            Team::all()->each(
                fn ($team) => $this->migrate($team)
            );
        }
    }

    protected function migrate($team)
    {
        $team->configure()->use();

        $this->line('');
        $this->line('-----------------------------------------');
        $this->line("Migrating team #{$team->id}");
        $this->line('-----------------------------------------');
        $this->line('');

        $options = ['--force' => true];

        if ($this->option('seed')) {
            $options['--seed'] = true;
        }

        $this->call(
            $this->options('fresh') ? 'migrate:fresh' : 'migrate',
            $options
        );
    }
}
