<?php

namespace Database\Factories\Railway;

use App\Models\Railway\RailwayBadgeReward;
use Illuminate\Database\Eloquent\Factories\Factory;

class RailwayBadgeRewardFactory extends Factory
{
    protected $model = RailwayBadgeReward::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'value' => $this->faker->word(),
            'railway_badge_id' => $this->faker->randomNumber(),
        ];
    }
}
