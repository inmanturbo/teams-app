<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
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
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'table_header' => $this->faker->text(),
            'color' => $this->faker->hexColor(),
            'opactity' => $this->faker->numberBetween(0, 100),
            'font_size' => $this->faker->numberBetween(0, 100),
            'font_color' => $this->faker->hexColor(),
            'height' => $this->faker->numberBetween(0, 100),
            'width' => $this->faker->numberBetween(0, 100),
            'date_from' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'date_to' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
