<?php

namespace Tests\Feature;

use App\Http\Livewire\DeleteLinkForm;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteLinkTest extends TestCase
{
    // use RefreshDatabase;

    public function test_links_can_be_deleted()
    {
        // $this->withoutExceptionHandling();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $link = Link::factory()->create([
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ]);

        Livewire::test(DeleteLinkForm::class)
            ->call('showDeleteLinkModal', $link->uuid)->call('deleteLink');

        $this->assertDatabaseMissing('links', [
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ], $link->getConnectionName());
    }
}
