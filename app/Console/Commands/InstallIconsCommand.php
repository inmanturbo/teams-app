<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallIconsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:icons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install icons';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->callSilent('vendor:publish', ['--tag' => 'buku-icons-assets']);
        $this->callSilent('icon:cache');
        $this->call('buku-icons:import');
        $this->info('Installation complete.');
    }
}
