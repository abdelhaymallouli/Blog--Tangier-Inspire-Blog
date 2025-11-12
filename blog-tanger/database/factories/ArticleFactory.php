<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'content' => $this->faker->paragraphs(5, true),
            'status' => $this->faker->randomElement(['Draft','Published','Archived']),
            'author_id' => User::inRandomOrder()->first()->user_id,
            'views' => $this->faker->numberBetween(0,1000),
            'shares' => $this->faker->numberBetween(0,500),
            'is_moderated' => $this->faker->boolean(),
            'published_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
