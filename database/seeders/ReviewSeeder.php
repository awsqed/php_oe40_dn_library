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
            for ($j = 0; $j < 100; $j++) {
                if ($faker->boolean) {
                    \App\Models\Review::create([
                        'user_id' => $i + 1,
                        'book_id' => $j + 1,
                        'rating' => $faker->numberBetween(1, 5),
                        'comment' => $faker->paragraph,
                        'reviewed_at' => $faker->unixTime,
                    ]);
                }
            }
        }
    }
}
