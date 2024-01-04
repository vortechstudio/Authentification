<?php

namespace Database\Factories\Railway;

use App\Models\Railway\Gare;
use App\Models\Railway\Hub;
use App\Models\Railway\Ligne;
use Illuminate\Database\Eloquent\Factories\Factory;

class LigneFactory extends Factory
{
    protected $model = Ligne::class;

    public function definition(): array
    {
        return [
            'nb_station' => $this->faker->randomNumber(),
            'price' => $this->faker->randomFloat(),
            'distance' => $this->faker->randomNumber(),
            'time_min' => $this->faker->randomNumber('2'),
            'active' => true,
            'visual' => "beta",
            'type_ligne' => "ter",

            'start_gare_id' => Gare::factory(),
            'end_gare_id' => Gare::factory(),
            'hub_id' => Hub::factory(),
        ];
    }
}
