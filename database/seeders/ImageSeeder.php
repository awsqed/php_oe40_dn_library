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
                'path' => $faker->imageUrl(256, 256),
                'imageable_id' => $i + 1,
                'imageable_type' => 'user',
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            \App\Models\Image::create([
                'path' => $faker->imageUrl(150, 100),
                'imageable_id' => $i + 1,
                'imageable_type' => 'category',
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            \App\Models\Image::create([
                'path' => $faker->imageUrl(150, 100),
                'imageable_id' => $i + 1,
                'imageable_type' => 'publisher',
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            \App\Models\Image::create([
                'path' => $faker->imageUrl(1280, 2048),
                'imageable_id' => $i + 1,
                'imageable_type' => 'book',
            ]);
        }
    }
}
