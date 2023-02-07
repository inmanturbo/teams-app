<?php

namespace Tests\Feature;

use App\Http\Livewire\UpdateTeamLandingPageForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class TeamLandingPageCanBeUpdatedTest extends TestCase
{
    /** @test */
    public function test_can_update_landing_page(): void
    {
        Storage::fake('avatars');

        $this->withoutExceptionHandling();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $component = Livewire::test(UpdateTeamLandingPageForm::class)->set('landing_page', $file = UploadedFile::fake()->create('file.html', 200))->call('updateTeamLandingPage');

        $this->assertNotNull($user->currentTeam->fresh()->team_data->landingPage());

        Storage::disk($user->currentTeam->landingPageDisk())->assertExists($user->currentTeam->fresh()->team_data->landingPage());
    }
}
