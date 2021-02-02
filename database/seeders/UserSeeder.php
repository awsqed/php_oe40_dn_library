<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::create([
            'username' => 'foobar',
            'email' => 'foobar@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'first_name' => 'Foo',
            'last_name' => 'Bar',
        ]);
        User::create([
            'username' => 'loremipsum',
            'email' => 'loremipsum@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'first_name' => 'Lorem',
            'last_name' => 'Ipsum',
        ]);
        User::factory()->times(98)->create();
    }

}
