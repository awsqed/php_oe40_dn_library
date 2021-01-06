<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
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
            \App\Models\Publisher::create([
                'name' => $faker->words(2, true),
                'description' => $faker->paragraph,
            ]);
        }
    }
}
