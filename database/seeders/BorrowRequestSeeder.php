<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BorrowRequestSeeder extends Seeder
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
            \App\Models\BorrowRequest::create([
                'user_id' => $faker->randomDigit + 1,
                'book_id' => $faker->randomDigit + 1,
                'from' => $faker->dateTime,
                'to' => $faker->dateTime,
                'note' => $faker->sentence,
                'status' => $faker->boolean,
                'processed_at' => $faker->dateTime,
                'returned_at' => $faker->dateTime,
            ]);
        }
    }
}
