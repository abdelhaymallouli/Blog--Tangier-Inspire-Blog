<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        // Comments are created within ArticleSeeder, so this seeder might not be strictly necessary
        // unless you want to create comments independently. For now, I'll leave it empty or
        // you can remove it if comments are always tied to articles through the ArticleSeeder.
    }
}