<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            UserPermissionSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            PublisherSeeder::class,
            BookSeeder::class,
            BorrowRequestSeeder::class,
            LikeSeeder::class,
            ReviewSeeder::class,
            FollowSeeder::class,
            ImageSeeder::class,
    ]);
    }
}
