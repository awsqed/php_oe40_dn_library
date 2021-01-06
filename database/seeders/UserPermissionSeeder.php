<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
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
            \App\Models\UserPermission::create([
                'user_id' => $i + 1,
                'permission_id' => $faker->unique()->randomDigit + 1,
            ]);
        }
    }
}
