<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            \App\Models\Follow::create([
                'user_id' => $i + 1,
                'followable_id' => $faker->randomDigitNot($i + 1) + 1,
                'followable_type' => 'user',
                'followed_at' => $faker->unixTime,
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            \App\Models\Follow::create([
                'user_id' => $faker->randomDigit + 1,
                'followable_id' => $i + 1,
                'followable_type' => 'book',
                'followed_at' => $faker->unixTime,
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            \App\Models\Follow::create([
                'user_id' => $i + 1,
                'followable_id' => $faker->randomDigit + 1,
                'followable_type' => 'author',
                'followed_at' => $faker->unixTime,
            ]);
        }
    }
}
