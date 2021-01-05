<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
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
            \App\Models\Like::create([
                'user_id' => $faker->randomDigit + 1,
                'book_id' => $faker->randomDigit + 1,
                'liked_at' => $faker->unixTime,
            ]);
        }
    }
}
