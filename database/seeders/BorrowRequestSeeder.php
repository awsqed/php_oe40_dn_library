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
            for ($j = 0; $j < 100; $j++) {
                if ($faker->boolean) {
                    \App\Models\BorrowRequest::create([
                        'user_id' => $i + 1,
                        'book_id' => $j + 1,
                        'from' => $faker->dateTimeBetween('-30 days', "-5 days"),
                        'to' => $faker->dateTimeBetween('+15 days', "+30 days"),
                        'note' => $faker->sentence,
                        'status' => false,
                    ]);
                }
            }
        }
    }
}
