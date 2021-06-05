<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove exists records to start from scratch.
        //User::truncate();

        $faker = \Faker\Factory::create();

        $password = Hash::make('securepass');

        User::create([
            'login' => 'admin',
            'password' => $password,
            'full name' => 'Marienko Maksym',
            'email' => 'zmaryenko@gmail.com',
            'rating' => '99',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        for ($i = 0; $i < 9; $i++) {
            User::create([
                'login' => $faker->userName,
                'password' => $password,
                'full name' => $faker->name,
                'email' => $faker->email,
                'rating' => $faker->biasedNumberBetween(-100, 100),
            ]);
        }
    }
}