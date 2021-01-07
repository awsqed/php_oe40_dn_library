<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{

    public function index()
    {
        Gate::authorize('read-permission');

        return view('dashboard.permissions.index', [
            'permissions' => Permission::paginate(config('app.num-rows')),
        ]);
    }

    public function edit(Permission $permission)
    {
        if (Gate::none(['read-permission', 'update-permission'])) {
            abort(403, trans('general.messages.no-permission'));
        }

        return view('dashboard.permissions.edit', [
            'permission' => $permission,
            'childs' => $permission->childArray(),
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        Gate::authorize('update-permission');

        $validated = $request->validate([
            'description' => 'nullable|max:254',
        ]);

        $permission->description = $validated['description'];
        $permission->save();

        return back();
    }

}
