<?php

namespace Database\Seeders;

use DateInterval;
use App\Models\BorrowRequest;
use Illuminate\Database\Seeder;

class BorrowRequestSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        BorrowRequest::withoutEvents(function () use ($faker) {
            for ($i = 1; $i <= 100; $i++) {
                for ($j = 1; $j <= 4; $j++) {
                    $from = $faker->dateTimeThisYear('2021-12-30');
                    $to = $from->add(new DateInterval('P1D'));

                    BorrowRequest::create([
                        'user_id' => $i,
                        'book_id' => $faker->unique()->numberBetween(1, 425),
                        'from' => $from,
                        'to' => $to,
                        'created_at' => $from,
                        'updated_at' => $from,
                    ]);
                }
            }
        });
    }

}
