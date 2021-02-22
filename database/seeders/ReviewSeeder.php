<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= 100; $i++) {
            for ($j = 1; $j <= 425; $j++) {
                if ($faker->boolean) {
                    \App\Models\Review::create([
                        'user_id' => $i,
                        'book_id' => $j,
                        'rating' => $faker->numberBetween(1, 5),
                        'comment' => $faker->paragraph($faker->numberBetween(5, 10)),
                        'reviewed_at' => $faker->unixTime,
                    ]);
                }
            }
        }
    }

}
