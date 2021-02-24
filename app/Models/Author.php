<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasImage;

    public $timestamps = false;

    protected $guarded = [];

    public function getAvatarAttribute()
    {
        return $this->image;
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
        return Str::title("{$this->first_name} {$this->last_name}");
    }

    public function getBreadcrumbAttribute()
    {
        return $this->fullname;
    }

}
