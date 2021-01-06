<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
            \App\Models\Category::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'parent_id' => $faker->boolean ? 1 : null,
            ]);
        }
    }
}
