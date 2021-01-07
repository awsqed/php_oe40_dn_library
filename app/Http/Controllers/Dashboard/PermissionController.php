<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{

    public function index(Request $request)
    {
        // TODO: Authorization

        return view('dashboard.permissions.index', [
            'permissions' => Permission::paginate(config('table.num-rows')),
        ]);
    }

    public function edit(Permission $permission)
    {
        // TODO: Authorization

        return view('dashboard.permissions.edit', [
            'permission' => $permission,
            'childs' => $permission->childArray(),
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        // TODO: Authorization

        $validatedData = $request->validate([
            'description' => 'nullable|max:254',
        ]);

        $permission->description = $validatedData['description'];
        $permission->save();

        return redirect()->back();
    }

}
