<?php

namespace App\Http\Livewire;

use App\Contracts\SubscribesByPromoCode;
use Auth;
use Livewire\Component;

class EnterPromoCodeForm extends Component
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
    public function mount()
    {
        $this->state = (Auth::user())->withoutRelations()->toArray();
    }

    public function subscribeByPromoCode(SubscribesByPromoCode $subscriber)
    {
        $this->resetErrorBag();

        $subscriber->subscribe($this->user, $this->state);

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.enter-promo-code-form');
    }
}
