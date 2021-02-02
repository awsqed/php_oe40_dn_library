<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\MarkedAsRead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getUnreadNotifications(Request $request, User $user)
    {
        $unreadNotifications = $user->unreadNotifications;

        return view("layouts.{$request->view}.notification", compact('unreadNotifications'))->render();
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $user = Auth::user();
        if ($notification->id) {
            $notification->markAsRead();
        } else {
            $user->unreadNotifications->markAsRead();
        }

        try {
            $user->notify(new MarkedAsRead());
        } catch (BroadcastException $e) {}

        return back();
    }

}
