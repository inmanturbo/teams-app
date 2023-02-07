<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateLinkForm;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateLinkTest extends TestCase
{
    // use RefreshDatabase;

    public function test_links_can_be_created(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $this->withoutExceptionHandling();

        Livewire::test(CreateLinkForm::class)
                    ->set(['state' => [
                        'teamUuid' => $user->currentTeam->uuid,
                        'role' => 'admin',
                        'type' => 'internal_link',
                        'target' => '_self',
                        'url' => 'https://example.com',
                        'title' => 'Example',
                        'label' => 'Example',
                        'view' => 'navigation-menu',
                        ]])
                    ->call('createLink');

        $this->assertDatabaseHas('links', [
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'target' => '_self',
            'url' => 'https://example.com',
            'title' => 'Example',
            'label' => 'Example',
            'view' => 'navigation-menu',
        ], (new Link())->getConnectionName());
    }

    public function test_creating_link_requires_validation(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(CreateLinkForm::class)
                    ->set(['state' => [
                        'teamUuid' => $user->currentTeam->uuid,
                        'role' => 'admin',
                        'type' => 'internal_link',
                        'target' => '_self',
                        'url' => '',
                        'title' => '',
                        'label' => '',
                        'order_column' => 'not an integer',
                        ]])
                    ->call('createLink')
                    ->assertHasErrors(['order_column']);

        $this->assertDatabaseMissing('links', [
            'target' => '_self',
            'url' => '',
            'title' => '',
            'label' => '',
        ], (new Link)->getConnectionName());
    }

    public function test_null_link_type_will_create_internal_link(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(CreateLinkForm::class)
                    ->set(['state' => [
                        'teamUuid' => $user->currentTeam->uuid,
                        'role' => 'admin',
                        'type' => null,
                        'target' => '_self',
                        'url' => 'https://example.com',
                        'title' => 'Example',
                        'label' => 'Example',
                        ]])
                    ->call('createLink');

        $this->assertDatabaseHas('links', [
            'target' => '_self',
            'type' => 'internal_link',
            'url' => 'https://example.com',
            'title' => 'Example',
            'label' => 'Example',
        ], (new Link())->getConnectionName());
    }

    public function test_creating_link_requires_authorization(): void
    {
        $user = User::factory()->withPersonalTeam()->create();

        $adminTeamMember = User::factory()->withPersonalTeam()->create();

        $this->actingAs($supervisorTeamMember = User::factory()->withPersonalTeam()->create());

        //assign the supervisor to the user's team
        $user->currentTeam->users()->attach($supervisorTeamMember, ['role' => 'supervisor']);
        $user->currentTeam->users()->attach($adminTeamMember, ['role' => 'admin']);

        $supervisorTeamMember->switchTeam($user->currentTeam);
        $adminTeamMember->switchTeam($user->currentTeam);

        $this->actingAs($supervisorTeamMember);

        $this->createLink();

        $this->assertDatabaseMissing('links', [
            'target' => '_self',
            'url' => 'https://example.com',
            'title' => 'Example',
            'label' => 'Example',
        ], (new Link())->getConnectionName());


        // try to create a link as a admin
        $this->actingAs($adminTeamMember);

        $this->createLink();

        $this->assertDatabaseHas('links', [
            'target' => '_self',
            'url' => 'https://example.com',
            'title' => 'Example',
            'label' => 'Example',
        ], (new Link)->getConnectionName());
    }

    protected function createLink()
    {
        $component = Livewire::test(CreateLinkForm::class)
        ->set(['state' => [
            'role' => 'admin',
            'type' => 'internal_link',
            'target' => '_self',
            'url' => 'https://example.com',
            'title' => 'Example',
            'label' => 'Example',
            ]])
        ->call('createLink');

        return $component;
    }
}
