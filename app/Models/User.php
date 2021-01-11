<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function avatar()
    {
        return $this->image->path
                ?? "https://ui-avatars.com/api/?name={$this->username}?size=256?background=random";
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')->using(UserPermission::class);
    }

    public function hasPermission($permission)
    {
        $cacheTime = config('app.cache-time');
        $model = Cache::remember("{$permission}", $cacheTime, function () use ($permission) {
            try {
                return Permission::where('name', $permission)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return null;
            }
        });

        if (!$model) {
            return false;
        }

        $userPermissions = $this->permissions();
        $cacheKey = $this->username ."-{$permission}";
        $hasPermission = Cache::remember($cacheKey, $cacheTime, function () use ($userPermissions, $model, $permission) {
            return $userPermissions
                    ->whereIn(
                        'name',
                        array_merge(
                            $model->parentArray(),
                            [
                                $permission,
                            ]
                        )
                    )
                    ->get()
                    ->isNotEmpty();
        });

        return $hasPermission;
    }

    public function bookBorrowRequests()
    {
        return $this->belongsToMany(Book::class, 'borrow_requests')->using(BorrowRequest::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function followings()
    {
        return $this->hasMany(Follow::class);
    }

    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function reviews()
    {
        return $this->belongsToMany(Book::class, 'review')->using(Review::class);
    }

}
