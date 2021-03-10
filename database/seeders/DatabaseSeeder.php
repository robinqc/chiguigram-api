<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{ User, Post, Category };
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();
        Post::factory(120)->create();
        Category::factory(20)->create();
        $categories = Category::all()->pluck('id')->toArray();
        $users = User::all()->pluck('id')->toArray();
        $posts = Post::all();
        foreach ($posts as $post) {
            $post->categories()->attach(array_rand($categories, 4));
            $post->likes()->attach(array_rand($users, random_int(1, 30)));
        }
    }
}
