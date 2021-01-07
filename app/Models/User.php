<?php

namespace App\Models;

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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')->using(UserPermission::class);
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

    public function hasPermission($permissionNode)
    {
        try {
            $permission = Permission::where('name', $permissionNode)->firstOrFail();
            return $this->permissions()
                        ->whereIn('name', array_merge(
                            $permission->parentArray(),
                            [
                                $permissionNode,
                            ]
                        ))
                        ->get()
                        ->isNotEmpty();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

}
