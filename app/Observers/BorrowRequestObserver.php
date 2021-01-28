<?php

namespace App\Observers;

use App\Models\BorrowRequest;
use App\Notifications\NewBorrow;
use App\Notifications\BorrowProcessed;
use Illuminate\Support\Facades\Notification;
use App\Repositories\Interfaces\UserRepositoryInterface;

class BorrowRequestObserver
{

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function created(BorrowRequest $borrowRequest)
    {
        $users = $this->userRepo->whereHasPermissions([
            'admin.read-borrow-request',
            'admin.update-borrow-request',
        ]);

        Notification::send($users, new NewBorrow($borrowRequest));
    }

    public function updated(BorrowRequest $borrowRequest)
    {
        $configKey = 'app.borrow-request.status-code';
        $status = $borrowRequest->status;
        if ($status == config("{$configKey}.accepted") || $status == config("{$configKey}.rejected")) {
            $borrowRequest->user->notify(new BorrowProcessed($borrowRequest));
        }
    }

}
