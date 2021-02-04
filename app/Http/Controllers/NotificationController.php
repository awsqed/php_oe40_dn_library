<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\MarkedAsRead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getChannel()
    {
        $channel = '';
        try {
            Broadcast::connection(config('broadcasting.default'))->broadcast([], '');
            $channel = 'App.Models.User.'. Auth::id();
        } catch (BroadcastException $e) {}

        return $channel;
    }

    public function getUnreadNotifications(Request $request)
    {
        $unreadNotifications = Auth::user()->unreadNotifications;

        return view("layouts.notifications.{$request->view}", compact('unreadNotifications'))->render();
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
