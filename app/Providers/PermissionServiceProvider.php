<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\QueryException;

class PermissionServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }


    public function boot()
    {
        $this->loadPermissions(config('permissions'));

        $permissions = [];
        try {
            $permissions = Permission::all();
        } catch (QueryException $e) {}

        foreach ($permissions as $value) {
            $permissionName = $value->name;
            $configValue = config("permissions.{$permissionName}");

            if (isset($configValue) && !is_array($configValue)) {
                $actionName = empty($configValue) ? $value : $configValue;

                Gate::define($actionName, function(User $user) use ($permissionName) {
                    return $user->hasPermission($permissionName)
                            ? Response::allow()
                            : Response::deny(trans('general.messages.no-permission'));
                });
            }
        }
    }

    protected function loadPermissions(array $arg, Permission $parent = null)
    {
        try {
            foreach ($arg as $key => $value) {
                $permission = Permission::create([
                    'name' => ($parent == null ? '' : "{$parent->name}.") . $key,
                    'parent_id' => $parent == null ? null : $parent->id,
                ]);

                if (is_array($value)) {
                    foreach ($value as $key2 => $value2) {
                        $childPermission = $permission->childs()->save(
                            new Permission([
                                'name' => "{$key}.{$key2}",
                            ]
                        ));

                        if (is_array($value2)) {
                            $this->loadPermissions($value2, $childPermission);
                        }
                    }
                }
            }
        } catch (QueryException $e) {}
    }

}
