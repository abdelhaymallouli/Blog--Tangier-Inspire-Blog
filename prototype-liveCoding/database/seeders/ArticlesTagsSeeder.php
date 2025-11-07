<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Tag;

class ArticlesTagsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();

        $tags = Tag::factory(25)->create();

        Article::factory(60)->create()->each(function ($article) use ($tags) {
            $article->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}