<?php

namespace Tests\Feature;

use App\Http\Livewire\UpdateLinkForm;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateLinkTest extends TestCase
{
    // use RefreshDatabase;

    public function test_links_can_be_updated(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $this->withoutExceptionHandling();

        $link = Link::factory()->create([
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ]);

        Livewire::test(UpdateLinkForm::class, ['link' => $link])
                    ->set(['state' => array_merge($link->withoutRelations()->toArray(), [
                        'url' => 'https://example.com/updated',
                        'title' => 'Example Updated',
                        'label' => 'Example Updated',
                        'view' => 'navigation-menu',
                        'active' => true,
                    ])])
                    ->call('updateLink');

        $this->assertDatabaseHas('links', [
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com/updated',
            'title' => 'Example Updated',
            'label' => 'Example Updated',
            'view' => 'navigation-menu',
        ], $link->getConnectionName());
    }

    public function test_updating_a_link_requires_validation(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $link = Link::factory()->create([
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ]);

        Livewire::test(UpdateLinkForm::class, ['link' => $link])
                    ->set(['state' => array_merge($link->withoutRelations()->toArray(), [
                        'url' => '',
                    ])])
                    ->call('updateLink')
                    ->assertHasErrors(['url']);
    }

    public function test_updating_a_link_requires_authorization(): void
    {
        $user = User::factory()->withPersonalTeam()->create();

        $adminTeamMember = User::factory()->withPersonalTeam()->create();

        $this->actingAs($supervisorTeamMember = User::factory()->withPersonalTeam()->create());

        //assign the supervisor to the user's team
        $user->currentTeam->users()->attach($supervisorTeamMember, ['role' => 'supervisor']);
        $user->currentTeam->users()->attach($adminTeamMember, ['role' => 'admin']);


        $link = Link::factory()->create([
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ]);



        $component = Livewire::test(UpdateLinkForm::class, ['link' => $link])
                    ->set(['state' => array_merge($link->withoutRelations()->toArray(), [
                        'url' => 'https://example.com/updated',
                        'title' => 'Example Updated',
                        'label' => 'Example Updated',
                        'view' => 'navigation-menu',
                    ])])
                    ->call('updateLink');

        //assert that the link wa not updated
        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ], $link->getConnectionName());

        $this->assertDatabaseMissing('links', [
            'id' => $link->id,
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com/updated',
        ], $link->getConnectionName());


        //try to update the link acting th adminTeamMember
        $this->actingAs($adminTeamMember);

        $component->set(['state' => array_merge($link->withoutRelations()->toArray(), [
            'url' => 'https://example.com/updated',
            'title' => 'Example Updated',
            'label' => 'Example Updated',
            'view' => 'navigation-menu',
        ])])->call('updateLink');

        //assert that the link was updated

        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com/updated',
        ], $link->getConnectionName());
    }
}
