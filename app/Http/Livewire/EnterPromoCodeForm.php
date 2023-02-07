<?php

namespace App\Http\Livewire;

use App\Contracts\SubscribesByPromoCode;
use Auth;
use Laravel\Jetstream\InteractsWithBanner;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class EnterPromoCodeForm extends Component
{
    use RedirectsActions;
    use InteractsWithBanner;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    public function subscribeByPromoCode(SubscribesByPromoCode $subscriber)
    {
        $this->resetErrorBag();

        $subscriber->subscribe($this->user, $this->state);

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');

        $this->banner('You are now subscribed!');
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
