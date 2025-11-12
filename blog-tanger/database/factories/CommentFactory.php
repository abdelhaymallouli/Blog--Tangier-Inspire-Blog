<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'article_id' => Article::inRandomOrder()->first()->article_id,
            'user_id' => User::inRandomOrder()->first()->user_id,
            'guest_name' => $this->faker->optional()->name(),
            'content' => $this->faker->paragraph(),
            'is_approved' => $this->faker->boolean(),
        ];
    }
}