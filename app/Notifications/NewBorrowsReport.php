<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Notifications\Messages\MailMessage;

class NewBorrowsReport extends Notification implements ShouldQueue
{
    use Queueable;

    public $newBorrows;

    public function __construct($newBorrows)
    {
        $this->newBorrows = $newBorrows;
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
        $count = $this->newBorrows->count();

        return [
            'message' => trans_choice('notifications.new-borrows-report.message', $count),
            'href' => route('borrows.index'),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
                ->subject(trans('notifications.new-borrows-report.mail.subject'))
                ->markdown('mails.new-borrows-report', [
                    'notifiable' => $notifiable,
                    'newBorrows' => $this->newBorrows,
                ]);
    }

}
