<?php

namespace App\Http\Livewire;

use App\Contracts\UpdatesLink;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;

class UpdateLinkForm extends Component
{
    use InteractsWithBanner;

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $link;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    public $editingLink = false;

    protected $listeners = ['editingLink' => 'showForm'];

    public function showForm($linkUuid)
    {
        $this->link = Link::where('uuid', $linkUuid)->first();

        $this->state = $this->link->withoutRelations()->toArray();

        $this->editingLink = true;
    }

    public function updateLink(UpdatesLink $updater)
    {
        $this->resetErrorBag();

        // convert true/false string to boolean
        if(isset($this->state['active'])){
            $this->state['active'] = filter_var($this->state['active'], FILTER_VALIDATE_BOOLEAN);
        }

        $updater->update($this->user, $this->link, $this->state);

        $this->emit('saved');

        $this->editingLink = false;

        $this->banner('Link updated successfully.', 'success');
        $this->emit('refresh-navigation-menu');
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
        return view('livewire.update-link-form');
    }
}
