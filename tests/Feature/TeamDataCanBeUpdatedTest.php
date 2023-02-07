<?php

namespace Tests\Feature;

use App\Http\Livewire\UpdateTeamDataForm;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class TeamDataCanBeUpdatedTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_team_team_data_can_be_updated()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(UpdateTeamDataForm::class, ['team' => $user->currentTeam])
                    ->set(['state' => ['address' => ['street' => 'test', 'city' => 'test', 'state' => 'test', 'zip' => 'test']]])
                    ->call('updateTeamData');

        $this->assertCount(1, $user->fresh()->ownedTeams);

        $this->assertEquals('test', $user->currentTeam->fresh()->team_data->address->street);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_team_team_data_requires_validation()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(UpdateTeamDataForm::class, ['team' => $user->currentTeam])
                    ->set(['state' => ['email' => 'test']])
                    ->call('updateTeamData')->assertHasErrors(['email']);



        $this->assertCount(1, $user->fresh()->ownedTeams);

        $this->assertNotEquals('test', $user->currentTeam->fresh()->team_data->email);
    }
}
