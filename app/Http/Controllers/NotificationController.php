<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

}
