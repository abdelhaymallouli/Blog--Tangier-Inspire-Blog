<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->sentence(6);
        return [
            'admin_id' => 1,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(4),
            'content' => $this->faker->paragraphs(3, true),
            'image' => null,
            'published_at' => now(),
        ];
    }
}
