<?php

namespace Database\Factories\Railway;

use App\Models\Railway\Gare;
use Illuminate\Database\Eloquent\Factories\Factory;

class GareFactory extends Factory
{
    protected $model = Gare::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'type_gare' => "small",
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'city' => $this->faker->city(),
            'pays' => $this->faker->country(),
            'freq_base' => $this->faker->randomNumber(),
            'habitant_city' => $this->faker->randomNumber(),
            'transports' => json_encode([]),
            'equipements' => json_encode([]),
        ];
    }
}
