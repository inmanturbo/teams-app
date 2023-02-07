<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Laravel\Jetstream\Jetstream;
use Livewire\Livewire;
use Tests\TestCase;

class ApiTokenPermissionsTest extends TestCase
{
    // use RefreshDatabase;

    public function test_api_token_permissions_can_be_updated()
    {
        if (! Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $token = $user->tokens()->create([
            'name' => 'Test Token',
            'token' => Str::random(40),
            'abilities' => [ Jetstream::$permissions[0], Jetstream::$permissions[1] ],
        ]);

        Livewire::test(ApiTokenManager::class)
                    ->set(['managingPermissionsFor' => $token])
                    ->set(['updateApiTokenForm' => [
                        'permissions' => [
                            Jetstream::$permissions[0],
                            'missing-permission',
                        ],
                    ]])
                    ->call('updateApiToken');

        $this->assertTrue($user->fresh()->tokens->first()->can(Jetstream::$permissions[0]));
        $this->assertFalse($user->fresh()->tokens->first()->can(Jetstream::$permissions[1]));
        $this->assertFalse($user->fresh()->tokens->first()->can('missing-permission'));
    }
}
