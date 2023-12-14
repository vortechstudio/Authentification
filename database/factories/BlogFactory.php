<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        return [
            "contenue" => $this->faker->paragraph($nb = 8, $asText = true),
            "published" => true,
            'published_at' => $this->faker->dateTimeBetween('-30 days'),
            "description" => $this->faker->realText(),
            "publish_to_social" => false
        ];
    }
}
