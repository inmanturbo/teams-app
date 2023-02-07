<?php

namespace App\Http\Livewire;

use App\Contracts\UpdatesTeamLogo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateTeamLogoForm extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    public $photo;

    /**
     * Prepare the component.
     */
    public function mount(): void
    {
        $this->state = (Auth::user()->currentTeam)->withoutRelations()->toArray();
    }

    public function updateTeamLogo(UpdatesTeamLogo $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            Auth::user()->currentTeam,
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

        if (isset($this->photo)) {
            return redirect()->route('teams.show', ['team' => Auth::user()->currentTeam->uuid]);
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Delete  team's profile photo.
     */
    public function deleteProfilePhoto(): void
    {
        (Auth::user()->currentTeam)->deleteProfilePhoto();

        $this->emit('refresh-navigation-menu');
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
        return view('livewire.update-team-profile-information-form');
    }
}
