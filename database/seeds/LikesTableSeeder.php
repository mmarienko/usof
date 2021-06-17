<?php

use Illuminate\Database\Seeder;
use App\Like;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove exists records to start from scratch.
        Like::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            Like::create([
                'author' => $faker->userName,
                'publish_date' => $faker->date(),
                'post_id' => $faker->numberBetween(1,20),
                'type' => $faker->randomElement(['like', 'dislike'])
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            Like::create([
                'author' => $faker->name,
                'publish_date' => $faker->date(),
                'comment_id' => $faker->numberBetween(1,20),
                'type' => $faker->randomElement(['like', 'dislike'])
            ]);
        }
    }
}
