<?php

namespace App\Http\Livewire;

use App\Contracts\UpdatesTeamDomains;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateTeamDomainForm extends Component
{
    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team): void
    {
        $this->team = $team;

        $this->state = $team->withoutRelations()->toArray();
    }

    /**
     * Update the  team's name.
     *
     * @param  \Laravel\Jetstream\Contracts\UpdatesTeamDomains  $updater
     * @return void
     */
    public function updateTeamDomain(UpdatesTeamDomains $updater): void
    {
        $this->resetErrorBag();

        $updater->update($this->user, $this->team, $this->state);

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');

        $this->mount($this->team->fresh());
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.update-team-domain-form');
    }
}
