<?php

namespace Database\Factories\Social;

use App\Models\Social\Post;
use App\Models\Social\PostComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $visibility = $this->faker->randomElement(['public', 'friends']);
        $created = $this->faker->dateTimeBetween('-1 year', 'now');
        return [
            'title' => $this->faker->realText(255),
            'content' => $this->faker->realText(500),
            'visibility' => $visibility,
            'anonymous' => false,
            'commentable' => true,
            'is_reject' => false,
            'is_reject_reason' => null,
            'is_reject_at' => null,
            'views' => $this->faker->randomNumber(),
            'created_at' => $created,
            'updated_at' => $created,
        ];
    }
}
