<?php

namespace Database\Factories;

use App\Models\LinkType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExternalIframe>
 */
class ExternalIframeFactory extends LinkFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return array_merge(parent::definition(), [
            'type' => LinkType::ExternalIframe->value,
        ]);
    }
}
