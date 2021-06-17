<?php

use Illuminate\Database\Seeder;
use App\Post;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove exists records to start from scratch.
        Post::truncate();
        DB::table('category_post')->truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $post = Post::create([
                'author' => $faker->userName,
                'title' => $faker->sentence,
                'publish_date' => $faker->date(),
                'status' => $faker->randomElement(['active', 'inactive']),
                'content' => $faker->paragraph,
            ]);

            $post->categories()->attach($faker->randomElements(['1', '2', '3', '4'], $faker->numberBetween(1, 4)));
        }
    }
}
