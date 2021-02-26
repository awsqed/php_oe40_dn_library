<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionController extends Controller
{

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->authorize('read-permission');

        $permissions = $this->repository->paginate();

        return view('dashboard.permissions.index', compact('permissions'));
    }

    public function edit($permissionId)
    {
        $this->authorize('update-permission');

        $permission = $this->repository->find($permissionId);
        $childs = $permission->childArray();

        return view('dashboard.permissions.edit', compact('permission', 'childs'));
    }

    public function update(Request $request, $permissionId)
    {
        $this->authorize('update-permission');

        $validated = $request->validate([
            'description' => 'nullable|max:254',
        ]);

        $this->repository->update($permissionId, $validated);

        return redirect()->route('permissions.index');
    }

}
