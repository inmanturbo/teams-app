<?php

namespace Tests\Feature;

use App\Models\SuperAdmin;
use App\Models\TeamDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    // use RefreshDatabase;

    public function test_teams_can_be_created(): void
    {
        $this->actingAs($user = SuperAdmin::factory()->withPersonalTeam()->create());

        $teamDatabase = TeamDatabase::factory()->create([
            'user_id' => $user->id,
        ]);

        Livewire::test(CreateTeamForm::class)
                    ->set(['state' => ['name' => 'Test Team', 'team_database_uuid' => $teamDatabase->uuid]])
                    ->call('createTeam');

        $this->assertCount(2, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->fresh()->ownedTeams()->latest('id')->first()->name);
    }
}
