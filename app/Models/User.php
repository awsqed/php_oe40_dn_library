<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Translation\HasLocalePreference;

class User extends Authenticatable implements HasLocalePreference
{
    use HasFactory, Notifiable, HasImage;

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

    public function getAvatarAttribute()
    {
        return $this->image;
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
        return $this->belongsToMany(Book::class, 'borrow_requests')
                    ->using(BorrowRequest::class)
                    ->withPivot('from', 'to', 'note', 'status', 'processed_at', 'returned_at')
                    ->withTimestamps();
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
        $fullname = "{$this->first_name} {$this->last_name}";
        return Str::title(trim($fullname)) ?: $this->username;
    }

    public function getBreadcrumbAttribute()
    {
        return $this->username;
    }

    public function preferredLocale()
    {
        return Session::get('locale', 'en');
    }

}
