<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        foreach (User::all() as $user) {
            $user->favorites()->attach(
                Article::inRandomOrder()->take(rand(1, 5))->pluck('article_id')
            );
        }
    }
}