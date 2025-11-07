<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Tag;


class ArticlesTagsSeeder extends Seeder
{
    public function run(): void
    {
        // 10 users
        $users = User::factory(10)->create();

        // 25 realistic tags
        $tags = Tag::factory(25)->create();

        // 60 articles
        Article::factory(60)->create()->each(function ($article) use ($tags) {
            $article->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
