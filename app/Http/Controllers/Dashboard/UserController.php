<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class UserController extends Controller
{

    public function __construct(
        UserRepositoryInterface $userRepo,
        PermissionRepositoryInterface $permRepo
    ) {
        $this->userRepo = $userRepo;
        $this->permRepo = $permRepo;
    }

    public function index()
    {
        $this->authorize('read-user');

        $users = $this->userRepo->paginate();

        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create-user');

        $permissions = $this->permRepo->all();

        return view('dashboard.users.create', compact('permissions'));
    }

    public function store(UserRequest $request)
    {
        $this->userRepo->createUser($request);

        return redirect()->route('users.index');
    }

    public function edit($userId)
    {
        $this->authorize('update-user-info');

        $user = $this->userRepo->find($userId);
        $permissions = Gate::allows('update-user-permission') ? $this->permRepo->all() : [];

        return view('dashboard.users.edit', compact('user', 'permissions'));
    }

    public function update(UserRequest $request, $userId)
    {
        $this->userRepo->updateUser($userId, $request);

        return redirect()->route('users.index');
    }

    public function destroy($userId)
    {
        $this->authorize('delete-user');

        $this->userRepo->deleteUser($userId);

        return back();
    }

}
