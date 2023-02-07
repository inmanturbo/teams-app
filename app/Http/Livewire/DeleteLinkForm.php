<?php

namespace App\Http\Livewire;

use App\Contracts\DeletesLink;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class DeleteLinkForm extends Component
{
    use RedirectsActions;

    /**
     * The uuid for the link.
     *
     * @var mixed
     */
    public $linkUuid;

    /**
     * Indicates if team deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingLinkDeletion = false;

    protected $listeners = [ 'showDeleteLinkModal'];

    public function showDeleteLinkModal($linkUuid)
    {
        $this->linkUuid = (Link::where('uuid', $linkUuid)->firstOrFail())->uuid;
        $this->confirmingLinkDeletion = true;
    }

    public function deleteLink(DeletesLink $deleter)
    {
        $deleter->delete($this->user, $this->linkUuid);

        session()->flash('flash.banner', 'Link deleted successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return $this->redirectPath($deleter);
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.delete-link-form');
    }
}
