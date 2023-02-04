<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\TeamDatabase;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Tests\TestCase;

class UserCanCreateFirstTeamTest extends TestCase
{
    public function test_first_team_can_be_created()
    {
        $this->actingAs(User::factory()->create([
            'type' => UserType::UpgradedUser,
        ]));

        $teamDatabase = TeamDatabase::factory()->create([
            'user_id' => Auth::id(),
        ]);

        $this->withExceptionHandling();

        $component = Livewire::test(CreateTeamForm::class)->set('state', [
            'name' => 'First Team',
            'team_database_uuid' => $teamDatabase->uuid,
        ])->call('createTeam');

        $this->assertDatabaseHas('teams', [
            'name' => 'First Team',
        ], (new Team())->getConnectionName());

        $this->assertTrue(Auth::user()->fresh()->isMemberOfATeam());
    }
}
