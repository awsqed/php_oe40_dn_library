<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

    public $timestamps = false;

    protected $guarded = [];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

}
