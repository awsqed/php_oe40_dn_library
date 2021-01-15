<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
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

    protected static function booted()
    {
        // Delete all related records before deleting the user
        static::deleting(function($user) {
            DB::transaction(function() use ($user) {
                $user->image()->delete();
                $user->permissions()->detach();
                $user->bookBorrowRequests()->detach();
                $user->likes()->forceDelete();
                $user->followings()->forceDelete();
                $user->followers()->forceDelete();
                $user->reviews()->detach();
            });
        });
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function avatar()
    {
        $model = $this;
        return Cache::remember("{$model->id}-avatar", config('app.cache-time'), function () use ($model) {
            $image = $model->image;
            $imagePath = $image == null ? '' : $image->path;
            return !empty($imagePath)
                    ? asset("storage/{$imagePath}")
                    : asset('storage/'. config('app.default-image.user'));
        });
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')->using(UserPermission::class);
    }

    public function hasPermission($permission, $recursive = true)
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
        if (!$recursive) {
            return $userPermissions->where('name', $permission)->get()->isNotEmpty();
        }

        $cacheKey = $this->id ."-{$permission}";
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
        return $this->belongsToMany(Book::class, 'reviews')
                    ->using(Review::class)
                    ->withPivot('rating', 'comment', 'reviewed_at');
    }

    public function getFullnameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getBreadcrumbAttribute()
    {
        return $this->username;
    }

}
