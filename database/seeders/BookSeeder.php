<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
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
            \App\Models\Book::create([
                'title' => $faker->sentence,
                'author_id' => $faker->randomDigit + 1,
                'publisher_id' => $faker->randomDigit + 1,
                'category_id' => $faker->randomDigit + 1,
                'description' => $faker->paragraph,
                'page_count' => $faker->numberBetween(10,100),
            ]);
        }
    }
}
