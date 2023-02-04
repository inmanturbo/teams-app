<?php

namespace Tests\Feature;

use App\Http\Livewire\UpdateTeamDomainForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateTeamDomainTest extends TestCase
{
    // use RefreshDatabase;

    public function test_team_domains_can_be_updated()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(UpdateTeamDomainForm::class, ['team' => $user->currentTeam])
                    ->set(['state' => ['domain' => 'test.test']])
                    ->call('updateTeamDomain');

        $this->assertCount(1, $user->fresh()->ownedTeams);
        $this->assertEquals('test.test', $user->currentTeam->fresh()->domain);
    }
}
