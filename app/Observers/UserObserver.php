<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserObserver
{

    public function deleting(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->imageRelation()->delete();
            $user->permissions()->detach();
            $user->bookBorrowRequests()->detach();
            $user->likes()->forceDelete();
            $user->followings()->forceDelete();
            $user->followers()->forceDelete();
            $user->reviews()->detach();
        });
    }

}
