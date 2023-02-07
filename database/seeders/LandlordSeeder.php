<?php

namespace Database\Seeders;

use Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandlordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(StoredEventsTableSeeder::class);
        return Artisan::call('event-sourcing:replay',[
            'projector' => config('landlord.event_projectors'),
            '--stored-event-model' => \App\Models\StoredEvents\EloquentStoredEvent::class,
            '-n' => true,
        ]);
    }
}
