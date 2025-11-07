<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Event;
use App\Models\Artist;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::factory()->create();

        Post::factory(5)->create(['admin_id' => $admin->id]);
        Event::factory(5)->create();
        Artist::factory(5)->create();
    }
}
