<?php

namespace App\Http\Livewire;

use App\Contracts\CreatesLink;
use App\Models\LinkMenu;
use App\Models\LinkTarget;
use App\Models\LinkType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class CreateLinkForm extends Component
{
    use RedirectsActions;
    use InteractsWithBanner;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    public $creatingNewLink = false;

    protected $listeners = [
        'creatingNewLink' => 'showForm',
        'copyingLink' => 'copyLink',
    ];

    public function mount()
    {
        $this->state = [
            'role' => array_keys(config('roles'))[0],
            'type' => LinkType::ExternalLink->value,
            'target' => LinkTarget::Self->value,
            'url' => '',
            'title' => '',
            'label' => '',
            'view' => LinkMenu::NavigationMenu->value,
            'order_column' => \App\Models\Link::max('order_column') + 1,
        ];
    }

    public function showForm($icon = null)
    {
        if ($icon) {
            $this->state['icon'] = $icon;
        }
        $this->creatingNewLink = true;
    }

    /**
     * Create a new team.
     */
    public function createLink(CreatesLink $creator): void
    {
        $this->resetErrorBag();

        // convert true/false string to boolean
        $this->state['active'] = filter_var($this->state['active'] ?? 'true', FILTER_VALIDATE_BOOLEAN);

        $creator->create(Auth::user(), $this->team, $this->state);

        $this->creatingNewLink = false;

        $this->banner('Link created successfully.', 'success');
        $this->emit('refresh-navigation-menu');
    }

    public function copyLink($linkUuid)
    {
        $link = \App\Models\Link::where('uuid', $linkUuid)->first();

        $this->state = Arr::except($link->toArray(), ['id', 'uuid', 'created_at', 'updated_at', 'deleted_at']);

        $this->state['label'] = $this->state['label'] . ' (copy)';

        $this->state['order_column'] = \App\Models\Link::max('order_column') + 1;

        $this->creatingNewLink = true;
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
        return view('livewire.create-link-form');
    }
}
