<?php

return [

    'title' => '{0} Notification|{1} Notification (1)|[2,*] Notifications (:count)',
    'mark-as-read' => 'Mark all as read',
    'empty' => 'No new notification',
    'new-borrow' => [
        'message' => '<strong>:fullname</strong> wants to borrow <strong>:title</strong>',
    ],
    'borrow-processed' => [
        'message' => [
            'accepted' => '<strong>:title</strong>\'s borrow request has been <strong class="text-success">accepted</strong>',
            'rejected' => '<strong>:title</strong>\'s borrow request has been <strong class="text-danger">rejected</strong>',
        ],
    ],

];
