<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Notifications\Messages\MailMessage;

class NewBorrow extends Notification implements ShouldQueue
{
    use Queueable;

    public $borrowId;
    public $user;
    public $book;

    public function __construct($borrowRequest)
    {
        $this->borrowId = $borrowRequest->id;
        $this->user = $borrowRequest->user->withoutRelations();
        $this->book = $borrowRequest->book->withoutRelations();
    }

    public function via($notifiable)
    {
        $via = [
            'database',
            'mail',
        ];

        try {
            Broadcast::connection(config('broadcasting.default'))->broadcast([], '');
            $via[] = 'broadcast';
        } catch (BroadcastException $e) {}

        return $via;
    }

    public function toArray($notifiable)
    {
        return [
            'message' => trans('notifications.new-borrow.message', [
                'fullname' => $this->user->fullname,
                'title' => $this->book->title,
            ]),
            'href' => route('borrows.index') ."?search={$this->user->fullname}",
            'borrow-id' => $this->borrowId,
            'can-accept' => $this->book->amount > 0,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
                ->subject(trans('notifications.new-borrow.mail.subject'))
                ->markdown('mails.new-borrow', [
                    'notifiable' => $notifiable,
                    'user' => $this->user,
                    'book' => $this->book,
                ]);
    }

}
