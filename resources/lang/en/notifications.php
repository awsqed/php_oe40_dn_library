<?php

return [

    'title' => '{0} Notification|{1} Notification (1)|[2,*] Notifications (:count)',
    'mark-as-read' => 'Mark all as read',
    'empty' => 'No new notification',
    'new-borrow' => [
        'message' => '<strong>:fullname</strong> wants to borrow <strong>:title</strong>',
        'mail' => [
            'subject' => 'Someone sent a new book borrow request',
            'intro' => 'You have a new book borrow request.',
        ],
    ],
    'borrow-processed' => [
        'accepted' => [
            'message' => '<strong>:title</strong>\'s borrow request has been <strong class="text-success">accepted</strong>',
            'mail' => [
                'subject' => ':title\'s borrow request has been accepted',
                'intro' => 'Your book borrow request has been accepted. Please visit our nearest library and collect the book.',
                'outro' => 'Remember to return the book **on time** or you will be fined.',
            ],
        ],
        'rejected' => [
            'message' => '<strong>:title</strong>\'s borrow request has been <strong class="text-danger">rejected</strong>',
            'mail' => [
                'subject' => ':title\'s borrow request has been rejected',
                'intro' => 'Your book borrow request has been rejected.',
            ],
        ],
    ],
    'mail' => [
        'hello' => 'Hello',
        'check-it-now' => 'Check It Now',
        'regards' => 'Regards',
        'subcopy' => 'If you’re having trouble clicking the button, copy and paste the URL below into your web browser',
    ],

];
