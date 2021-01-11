<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Permission;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        $this->authorize('read-user');

        return view('dashboard.users.index', [
            'users' => User::paginate(config('app.num-rows')),
        ]);
    }

    public function create()
    {
        $this->authorize('create-user');

        return view('dashboard.users.create', [
            'permissions' => Permission::all(),
        ]);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->username),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->birthday,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $imagePath = $request->has('image')
                        ? $request->file('image')->store('images/users', 'public')
                        : config('app.default-image.user');
        $user->image()->create([
            'path' => $imagePath,
        ]);

        if (Gate::allows('update-user-permission')) {
            if ($request->has('permissions')) {
                $user->permissions()->attach($request->permissions);
            }
        }

        return back()->with('success', trans('users.messages.user-created'));
    }

    public function edit(User $user)
    {
        $this->authorize('update-user-info');

        if (Gate::allows('update-user-permission')) {
            return view('dashboard.users.edit', [
                'user' => $user,
                'permissions' => Permission::all(),
            ]);
        }

        return view('dashboard.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->birthday;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $imagePath = $request->has('image')
                        ? $request->file('image')->store('images/users', 'public')
                        : config('app.default-image.user');

        $image = $user->image();
        if ($user->image) {
            if ($imagePath != config('app.default-image.user')) {
                $image->update([
                    'path' => $imagePath,
                ]);
            }
        } else {
            $image->create([
                'path' => $imagePath,
            ]);
        }
        Cache::forget("{$user->id}-avatar");

        if (Gate::allows('update-user-permission')) {
            $user->permissions()->sync($request->permissions);
        }

        $user->push();

        return back()->with('success', trans('users.messages.user-edited'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete-user');

        if (Auth::id() === $user->id) {
            abort(403, trans('general.messages.delete-user-self'));
        }

        $user->delete();

        return back();
    }

}
