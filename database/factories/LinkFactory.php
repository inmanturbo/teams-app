<?php

namespace Database\Factories;

use App\Models\LinkMenu;
use App\Models\LinkTarget;
use App\Models\LinkType;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => LinkType::InternalLink->value,
            'url' => $this->faker->url,
            'title' => $this->faker->sentence,
            'label' => $this->faker->word,
            'target' => LinkTarget::Self->value,
            'view' => LinkMenu::NavigationMenu->value,
            'icon' => null,
            'team_id' => function () {
                return TeamFactory::new()->create()->id;
            },
        ];
    }

    public function blank()
    {
        return $this->state(function(){
            return [
                'target' => LinkTarget::Blank->value,
            ];
        });
    }

    public function self()
    {
        return $this->state(function(){
            return [
                'target' => LinkTarget::Self->value,
            ];
        });
    }

    public function parent()
    {
        return $this->state(function(){
            return [
                'target' => LinkTarget::Parent->value,
            ];
        });
    }

    public function top()
    {
        return $this->state(function(){
            return [
                'target' => LinkTarget::Top->value,
            ];
        });
    }

}
