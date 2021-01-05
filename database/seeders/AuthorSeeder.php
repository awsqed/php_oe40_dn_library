<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
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
            \App\Models\Author::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'gender' => $faker->boolean,
                'date_of_birth' => $faker->date,
            ]);
        }
    }
}
