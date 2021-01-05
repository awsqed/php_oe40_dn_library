<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
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
            \App\Models\Review::create([
                'user_id' => $faker->randomDigit + 1,
                'book_id' => $faker->randomDigit + 1,
                'rating' => $faker->numberBetween(0, 5),
                'comment' => $faker->paragraph,
                'reviewed_at' => $faker->unixTime,
            ]);
        }
    }
}
