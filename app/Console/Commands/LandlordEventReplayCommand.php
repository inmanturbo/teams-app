<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LandlordEventReplayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'landlord:event-replay {--from=0 : Replay events starting from this event number}
                            {--stored-event-model=App\\Models\\EloquentStoredEvent : Replay events from this store}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replay events for the landlord models';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('event-sourcing:replay', [
            'projector' => config('landlord.event_projectors'),
            '--from' => $this->option('from'),
            '--stored-event-model' => $this->option('stored-event-model'),
        ]);
    }
}
