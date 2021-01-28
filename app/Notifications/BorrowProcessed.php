<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Notifications\Messages\MailMessage;

class BorrowProcessed extends Notification implements ShouldQueue
{
    use Queueable;

    public $borrowRequest;
    public $status;
    public $book;

    public function __construct($borrowRequest)
    {
        $this->borrowRequest = $borrowRequest->withoutRelations();
        $this->status = $borrowRequest->status == config('app.borrow-request.status-code.accepted') ? 'accepted' : 'rejected';
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
        $message = trans("notifications.borrow-processed.{$this->status}.message", [
            'title' => $this->book->title,
        ]);

        return [
            'message' => $message,
            'href' => route('library.book', $this->book),
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
                ->subject(trans("notifications.borrow-processed.{$this->status}.mail.subject", [
                    'title' => $this->book->title,
                ]))
                ->markdown("mails.borrow-processed-{$this->status}", [
                    'notifiable' => $notifiable,
                    'book' => $this->book,
                    'from' => $this->borrowRequest->from,
                    'to' => $this->borrowRequest->to,
                ]);
    }

}
