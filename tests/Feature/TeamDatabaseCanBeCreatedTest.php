<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateDatabaseForm;
use App\Models\TeamDatabase;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class TeamDatabaseCanBeCreatedTest extends TestCase
{
    public function test_team_databases_can_be_created(): void
    {
        $this->actingAs(User::factory()->create());

        $this->withoutExceptionHandling();

        $component = Livewire::test(CreateDatabaseForm::class)->set('state', [
            'name' => 'test_create_database',
        ])->call('createDatabase');

        $this->assertDatabaseHas('team_databases', [
            'name' => 'test_create_database',
        ], (new TeamDatabase())->getConnectionName());
    }
}
