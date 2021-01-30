<?php

namespace App\Tasks;

use App\Notifications\NewBorrowsReport;
use Illuminate\Support\Facades\Notification;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;

class BorrowsRemind
{

    public function __construct(
        UserRepositoryInterface $userRepo,
        BorrowRequestRepositoryInterface $borrowRepo
    ) {
        $this->userRepo = $userRepo;
        $this->borrowRepo = $borrowRepo;
    }

    public function __invoke()
    {
        $newBorrows = $this->borrowRepo->search('', config('app.borrow-request.status-code.new'), false);
        if ($newBorrows->count()) {
            $users = $this->userRepo->whereHasPermissions([
                'admin.read-borrow-request',
                'admin.update-borrow-request',
            ]);

            Notification::send($users, new NewBorrowsReport($newBorrows));
        }
    }

}
