<?php

namespace Tests\Feature;

use App\Http\Livewire\UpdateUserTypeForm;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire;
use Tests\TestCase;

class UserTypeCanBeUpdatedTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_types_can_be_updated()
    {
        $this->actingAs(User::factory()->withPersonalTeam()->create([
            'type' => UserType::SuperAdmin,
        ]));

        $user = User::factory()->create([
            'type' => UserType::User,
        ]);

        Auth::user()->impersonate($user);

        $this->withoutExceptionHandling();

        $component = Livewire::test(UpdateUserTypeForm::class)->set('state.user_type', UserType::Admin->value)->call('updateUserType');

        $this->assertDatabaseHas('users', [
            'type' => UserType::Admin->value,
        ], $user->getConnectionName());
    }
}
