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
                'user_id' => $faker->randomDigit + 1,
                'followable_id' => $faker->randomDigit + 1,
                'followable_type' => $faker->randomElement([
                    'user',
                    'book',
                    'author',
                ]),
                'followed_at' => $faker->unixTime,
            ]);
        }
    }
}
