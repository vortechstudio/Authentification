<?php

namespace Database\Factories\Railway;

use App\Models\Railway\Engine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EngineFactory extends Factory
{
    protected $model = Engine::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'type_transport' => 'ter',
            'type_train' => 'automotrice',
            'type_energy' => 'diesel',
            'duration_maintenance' => Carbon::now(),
            'image' => $this->faker->word(),
            'active' => $this->faker->boolean(),
            'in_shop' => $this->faker->boolean(),
            'in_game' => $this->faker->boolean(),
            'visual' => 'beta',
            'price_shop' => $this->faker->randomFloat(),
            'money_shop' => 'argent',
        ];
    }
}
