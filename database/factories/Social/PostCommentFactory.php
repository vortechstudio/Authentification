<?php

namespace Database\Factories\Social;

use App\Models\Social\Post;
use App\Models\Social\PostComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostCommentFactory extends Factory
{
    protected $model = PostComment::class;

    public function definition(): array
    {
        return [
            'text' => $this->faker->realText,
            'like' => $this->faker->randomNumber(),
            'is_reject' => false,
            'is_reject_reason' => null,
            'is_reject_at' => null,
        ];
    }
}
