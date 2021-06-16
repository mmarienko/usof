<?php

use Illuminate\Database\Seeder;
use App\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove exists records to start from scratch.
        Comment::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            Comment::create([
                'author' => $faker->name,
                'publish_date' => $faker->date(),
                'content' => $faker->paragraph,
                'post_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}