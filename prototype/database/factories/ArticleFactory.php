<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title'        => $title,
            'slug'         => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 99999),
            'content'      => fake()->paragraphs(6, true),
            'image'        => fake()->optional()->imageUrl(640, 480, 'news'), // optional random image
            'author_id'    => User::factory(),
            'category_id'  => Category::factory(),
            'status'       => fake()->randomElement(['draft', 'published', 'archived']), // new field
            'published_at' => fake()->optional(0.9)->dateTimeBetween('-2 years', 'now'),
            'is_moderated' => fake()->boolean(80), // 80% chance to be true
            'views'        => fake()->numberBetween(0, 500),
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
    }
}
