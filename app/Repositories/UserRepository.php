<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function getModel()
    {
        return User::class;
    }

    public function paginate($perPage = null, $columns = ['*'])
    {
        $perPage = $perPage ?? config('app.num-rows');

        return $this->model->latest()->paginate($perPage, $columns);
    }

    public function createUser($request)
    {
        $user = $this->create([
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
            $user->permissions()->attach($request->permissions);
        }
    }

    public function updateUser($userId, $request)
    {
        $attributes = [
            'username' => $request->username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->birthday,
            'phone' => $request->phone,
            'address' => $request->address,
        ];
        if ($request->filled('password')) {
            $attributes['password'] = Hash::make($request->password);
        }

        $imagePath = $request->has('image')
                        ? $request->file('image')->store('images/users', 'public')
                        : config('app.default-image.user');

        $this->update($userId, $attributes);

        $user = $this->find($userId);

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
    }

    public function deleteUser($userId)
    {
        if (Auth::id() === $userId) {
            abort(403, trans('general.messages.delete-user-self'));
        }

        $this->delete($userId);
    }

}
