<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            FavoriteSeeder::class,
            // CommentSeeder::class, // Comments are created within ArticleSeeder
        ]);
    }
}
