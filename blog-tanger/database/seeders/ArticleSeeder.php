<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Tag;
use App\Models\Comment;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory(50)->create()->each(function ($article) {
            $article->tags()->attach(Tag::inRandomOrder()->take(rand(1, 3))->pluck('tag_id'));
            Comment::factory(rand(0, 5))->create(['article_id' => $article->article_id]);
        });
    }
}