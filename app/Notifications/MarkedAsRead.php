<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class MarkedAsRead extends Notification
{

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toArray($notifiable)
    {
        return [];
    }

}
