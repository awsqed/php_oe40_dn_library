<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        Gate::authorize('read-user');

        return view('dashboard.users.index', [
            'users' => User::paginate(config('app.num-rows')),
        ]);
    }

    public function create()
    {
        Gate::authorize('create-user');
    }

    public function store(Request $request)
    {
        Gate::authorize('create-user');
    }

    public function show(User $user)
    {
        Gate::authorize('read-user');

        return view('dashboard.users.show', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update-user');
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete-user');

        if (Auth::id() === $user->id) {
            abort(403, trans('general.messages.delete-user-self'));
        }

        $user->delete();

        return redirect()->back();
    }

}
