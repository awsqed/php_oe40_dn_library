<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{

    public function run()
    {
        $authors = [
            [
                'first_name' => 'Victor',
                'last_name' => 'Hugo',
                'gender' => 0,
                'date_of_birth' => '1802-02-28',
            ],
            [
                'first_name' => 'Rita Mae',
                'last_name' => 'Brown',
                'gender' => 1,
                'date_of_birth' => '1944-11-28',
            ],
            [
                'first_name' => 'Jules',
                'last_name' => 'Verne',
                'gender' => 0,
                'date_of_birth' => '1828-02-08',
            ],
            [
                'first_name' => 'Barbara',
                'last_name' => 'Cartland',
                'gender' => 1,
                'date_of_birth' => '1901-07-09',
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Mitchell',
                'gender' => 0,
                'date_of_birth' => '1969-01-12',
            ],
        ];

        foreach ($authors as $author) {
            \App\Models\Author::create($author);
        }
    }

}
