<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
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
            \App\Models\Image::create([
                'path' => $faker->imageUrl(300, 300),
                'imageable_id' => $faker->randomDigit + 1,
                'imageable_type' => $faker->randomElement([
                    'user',
                    'book',
                    'author',
                    'publisher',
                ]),
            ]);
        }
    }
}
