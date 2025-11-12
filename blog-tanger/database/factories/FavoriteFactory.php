<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->user_id,
            'article_id' => Article::inRandomOrder()->first()->article_id,
        ];
    }
}