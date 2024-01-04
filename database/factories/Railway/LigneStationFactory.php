<?php

namespace Database\Factories\Railway;

use App\Models\Railway\Gare;
use App\Models\Railway\Ligne;
use App\Models\Railway\LigneStation;
use Illuminate\Database\Eloquent\Factories\Factory;

class LigneStationFactory extends Factory
{
    protected $model = LigneStation::class;

    public function definition(): array
    {
        return [
            'time' => $this->faker->randomNumber('2'),
            'distance' => $this->faker->randomFloat(),

            'gare_id' => Gare::factory(),
            'ligne_id' => Ligne::factory(),
        ];
    }
}
