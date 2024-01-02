<?php

namespace Database\Factories\Railway;

use App\Models\Railway\RailwayBadge;
use Illuminate\Database\Eloquent\Factories\Factory;

class RailwayBadgeFactory extends Factory
{
    protected $model = RailwayBadge::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'action' => $this->faker->word(),
            'action_count' => $this->faker->randomNumber(),
        ];
    }
}
