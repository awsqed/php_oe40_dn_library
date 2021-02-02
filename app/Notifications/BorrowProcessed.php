<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class BorrowProcessed extends Notification
{

    public function __construct($borrowRequest)
    {
        $this->status = $borrowRequest->status;
        $this->book = $borrowRequest->book;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $status = $this->status == config('app.borrow-request.status-code.accepted') ? 'accepted' : 'rejected';
        $message = trans("notifications.borrow-processed.message.{$status}", [
            'title' => $this->book->title,
        ]);

        return [
            'message' => $message,
            'href' => route('library.book', $this->book),
        ];
    }

}
