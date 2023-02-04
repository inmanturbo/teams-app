<?php

namespace App\Http\Livewire;

use App\Contracts\CreatesDatabase;
use Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class CreateDatabaseForm extends Component
{
    use RedirectsActions;
    use InteractsWithBanner;

    public $state = [];

    public $creatingNewDatabase = false;

    protected $listeners = [
        'showCreateDatabaseModal' => 'showForm',
    ];

    public function createDatabase(CreatesDatabase $creator)
    {
        $this->resetErrorBag();

        $creator->create($this->user, $this->state);

        $this->creatingNewDatabase = false;

        $this->emit('refreshTeamDatabases');

        $this->redirectPath($creator);
    }

    public function showForm()
    {
        $this->creatingNewDatabase = true;
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.create-database-form');
    }
}
