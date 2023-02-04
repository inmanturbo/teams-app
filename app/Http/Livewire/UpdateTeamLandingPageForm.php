<?php

namespace App\Http\Livewire;

use App\Contracts\UpdatesTeamLandingPage;
use App\Contracts\UpdatesTeamLogo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateTeamLandingPageForm extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The new landing page for the team.
     *
     * @var mixed
     */
    public $landing_page;

    public function updateTeamLandingPage(UpdatesTeamLandingPage $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            Auth::user()->currentTeam,
            $this->landing_page
                ? array_merge($this->state, ['landing_page' => $this->landing_page])
                : $this->state
        );

        if (isset($this->landing_page)) {
            return redirect()->route('teams.show', ['team' => Auth::user()->currentTeam->uuid]);
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Delete  team's profile photo.
     *
     * @return void
     */
    public function deleteLandingPage()
    {
        (Auth::user()->currentTeam)->deleteLandingPage();

        $this->emit('refresh-navigation-menu');
    }

    public function downloadLandingPage()
    {
        return (Auth::user()->currentTeam)->downloadLandingPage();
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getTeamProperty()
    {
        return Auth::user()->currentTeam;
    }

    public function render()
    {
        return view('livewire.update-team-landing-page-form');
    }
}
