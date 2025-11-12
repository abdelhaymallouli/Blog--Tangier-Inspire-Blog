<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Technology', 'Travel', 'Food', 'Fashion', 'Sports'];
        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => 'A description for ' . $category . ' category.',
            ]);
        }
    }
}