<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove exists records to start from scratch.
        Category::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 4; $i++) {
            Category::create([
                'title' => $faker->unique()->randomElement(['C++', 'Python', 'JavaScript', 'PHP']),
                'desription' => $faker->sentence,
            ]);
        }
    }
}