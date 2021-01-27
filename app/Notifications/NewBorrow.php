<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NewBorrow extends Notification
{

    public function __construct($borrowRequest)
    {
        $this->borrowRequest = $borrowRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => trans('notifications.new-borrow.message', [
                'fullname' => $this->borrowRequest->user->fullname,
                'title' => $this->borrowRequest->book->title,
            ]),
        ];
    }

}
