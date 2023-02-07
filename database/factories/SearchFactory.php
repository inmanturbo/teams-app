<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Search>
 */
class SearchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'term' => $this->faker->word(),
            'operator' => '=',
            'key' => 'id',
            'raw_query' =>  null,
            'type' => null,
            'driver' => 'mysql',
        ];
    }
}
