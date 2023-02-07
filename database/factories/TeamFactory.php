<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\TeamDatabase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->unique()->uuid(),
            'name' => $this->faker->unique()->company(),
            'user_id' => User::factory(),
            'personal_team' => true,
        ];
    }

    public function withTeamDatabase()
    {
        return $this->has(TeamDatabase::factory());
    }
}
