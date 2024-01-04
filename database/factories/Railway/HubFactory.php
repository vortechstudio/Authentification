<?php

namespace Database\Factories\Railway;

use App\Models\Railway\Gare;
use App\Models\Railway\Hub;
use Illuminate\Database\Eloquent\Factories\Factory;

class HubFactory extends Factory
{
    protected $model = Hub::class;

    public function definition(): array
    {
        return [
            'price_base' => $this->faker->randomFloat(),
            'taxe_hub_price' => $this->faker->randomFloat(),
            'active' => true,
            'visual' => "beta",

            'gare_id' => Gare::factory(),
        ];
    }
}
