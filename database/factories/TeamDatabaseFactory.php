<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeamDatabase>
 */
class TeamDatabaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'name' => str($this->faker->name)->snake(),
            'driver' => 'mysql',
            'user_id' => isset(Auth::user()->id) ? Auth::user()->id : $this->faker->unique()->numberBetween(1, User::count()),
        ];
    }
}
