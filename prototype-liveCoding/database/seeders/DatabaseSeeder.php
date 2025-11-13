<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create categories & tags
        $categories = Category::factory(6)->create();
        $tags = Tag::factory(15)->create();

        // 2. Create the MAIN WRITER
        $writer = User::factory()->create([
            'username'  => 'John_Doe',
            'email' => 'writer@example.com',
            'role'  => 'writer',
        ]);

        // 3. Give him 10 published articles
        Article::factory(10)->create([
            'author_id'    => $writer->user_id,
            'published_at' => now(),
            'is_moderated' => true,
        ])->each(function ($article) use ($tags) {
            $article->tags()->attach(
                $tags->random(rand(1, 3))->pluck('tag_id')
            );
        });

        
    }
}