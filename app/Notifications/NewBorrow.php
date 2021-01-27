<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NewBorrow extends Notification
{

    public function __construct($borrowRequest)
    {
        $this->user = $borrowRequest->user;
        $this->book = $borrowRequest->book;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => trans('notifications.new-borrow.message', [
                'fullname' => $this->user->fullname,
                'title' => $this->book->title,
            ]),
            'href' => route('borrows.index'),
        ];
    }

}
