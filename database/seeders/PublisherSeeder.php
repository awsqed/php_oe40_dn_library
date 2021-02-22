<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{

    public function run()
    {
        $publishers = [
            ['name' => 'Kindle Direct Publishing'],
            ['name' => 'HarperCollins'],
            ['name' => 'Hachette Livre'],
            ['name' => 'Bonnier Books'],
            ['name' => 'Simon & Schuster'],
        ];

        foreach ($publishers as $publisher) {
            \App\Models\Publisher::create($publisher);
        }
    }

}
