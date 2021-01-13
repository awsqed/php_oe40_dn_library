<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

    public $timestamps = false;

    protected $guarded = [];

    protected static function booted()
    {
        // Delete all related records before deleting the user
        static::deleting(function($user) {
            DB::transaction(function() use ($user) {
                $user->image()->delete();
                $user->books()->delete();
                $user->followers()->delete();
            });
        });
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getAvatarAttribute()
    {
        $model = $this;
        return Cache::remember("author-{$model->id}-avatar", config('app.cache-time'), function () use ($model) {
            $image = $model->image;
            $imagePath = $image == null ? '' : $image->path;
            return !empty($imagePath)
                    ? asset("storage/{$imagePath}")
                    : asset('storage/'. config('app.default-image.author'));
        });
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function getFullnameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getBreadcrumbAttribute()
    {
        return $this->fullname;
    }

}
