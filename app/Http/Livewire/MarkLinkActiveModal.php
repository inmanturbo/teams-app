<?php

namespace App\Http\Livewire;

use App\Contracts\UpdatesLink;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class MarkLinkActiveModal extends Component
{
    use RedirectsActions;

    /**
     * The uuid for the link.
     *
     * @var mixed
     */
    public $linkUuid;

    public bool $active = true;

    /**
     * Indicates if team deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingMark = false;


    protected $listeners = [ 'markingLink'];

    public function markingLink($linkUuid)
    {
        $this->linkUuid = (Link::where('uuid', $linkUuid)->firstOrFail())->uuid;
        $this->active = (Link::where('uuid', $linkUuid)->firstOrFail())->active;
        $this->confirmingMark = true;
    }

    public function markLink(UpdatesLink $updater)
    {
        $this->resetErrorBag();

        $link = Link::where('uuid', $this->linkUuid)->firstOrFail();

        $updater->update($this->user, $link, array_merge($link->toArray(), ['active' => $toBeActivatedOrDeactivated = ! $link->isActive()]));

        $activatedOrDeactived = $toBeActivatedOrDeactivated ? 'activated' : 'deactivated';

        session()->flash('flash.banner', 'Link '. $activatedOrDeactived .' successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return $this->redirectPath($updater);
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.mark-link-active-modal');
    }
}
