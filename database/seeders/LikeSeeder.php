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
            for ($j = 0; $j < 100; $j++) {
                if ($faker->boolean) {
                    \App\Models\Like::create([
                        'user_id' => $i + 1,
                        'book_id' => $j + 1,
                        'liked_at' => $faker->unixTime,
                    ]);
                }
            }
        }
    }
}
