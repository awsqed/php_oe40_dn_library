<?php

namespace App\Observers;

use App\Models\BorrowRequest;
use App\Notifications\NewBorrow;
use App\Notifications\BorrowProcessed;
use Illuminate\Support\Facades\Notification;
use Illuminate\Broadcasting\BroadcastException;
use App\Repositories\Interfaces\UserRepositoryInterface;

class BorrowRequestObserver
{

    public function created(BorrowRequest $borrowRequest)
    {
        $users = app()->make(UserRepositoryInterface::class)->whereHasPermissions([
            'admin.read-borrow-request',
            'admin.update-borrow-request',
        ]);

        try {
            Notification::send($users, new NewBorrow($borrowRequest));
        } catch (BroadcastException $e) {}
    }

    public function updated(BorrowRequest $borrowRequest)
    {
        try {
            $borrowRequest->user->notify(new BorrowProcessed($borrowRequest));
        } catch (BroadcastException $e) {}
    }

}
