<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Permission Map
    |--------------------------------------------------------------------------
    |
    | This file is for mapping the permission name to gate/policy actions.
    |
    */

    'admin' => [
        // User & Permission
        'create-user' => 'create-user',
        'read-user' => 'read-user',
        'update-user' => [
            'info' => 'update-user-info',
            'permission' => 'update-user-permission'
        ],
        'delete-user' => 'delete-user',
        'read-permission' => 'read-permission',
        'update-permission' => 'update-permission',

        // Category
        'create-category' => 'create-category',
        'read-category' => 'read-category',
        'update-category' => 'update-category',
        'delete-category' => 'delete-category',

        // Author
        'create-author' => 'create-author',
        'read-author' => 'read-author',
        'update-author' => 'update-author',
        'delete-author' => 'delete-author',

        // Publisher
        'create-publisher' => 'create-publisher',
        'read-publisher' => 'read-publisher',
        'update-publisher' => 'update-publisher',
        'delete-publisher' => 'delete-publisher',

        // Book
        'create-book' => 'create-book',
        'read-book' => 'read-book',
        'update-book' => 'update-book',
        'delete-book' => 'delete-book',
    ]

];
