<?php

namespace Database\Factories\Railway;

use App\Models\Railway\RailwayAdvantageCard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RailwayAdvantageCardFactory extends Factory
{
    protected $model = RailwayAdvantageCard::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'qte' => $this->faker->randomFloat(),
            'tpoint_cost' => $this->faker->randomNumber(),
            'drop_rate' => $this->faker->randomFloat(0, 0, 100),
            'model_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
