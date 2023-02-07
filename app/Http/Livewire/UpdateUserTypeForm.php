<?php

namespace App\Http\Livewire;

use App\Contracts\UpdatesUserType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateUserTypeForm extends Component
{
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
    public function mount(): void
    {
        $this->state = (Auth::user())->withoutRelations()->toArray();
        $this->state['user_type'] = (Auth::user())->type;
    }

    public function updateUserType(UpdatesUserType $updater)
    {
        $this->resetErrorBag();

        $updater->update($this->user, $this->state);

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.update-user-type-form');
    }
}
