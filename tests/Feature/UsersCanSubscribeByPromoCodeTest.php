<?php

namespace Tests\Feature;

use App\Http\Livewire\EnterPromoCodeForm;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class UsersCanSubscribeByPromoCodeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_subscribe_by_promo_code(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $component = Livewire::test(EnterPromoCodeForm::class)->set('state.promo_code', config('charter.promo_codes')[0])->call('subscribeByPromoCode');

        $this->assertTrue($user->fresh()->trialEndsAt()->isSameDay(now()->addDays(config('charter.trial_days'))));
    }
}
