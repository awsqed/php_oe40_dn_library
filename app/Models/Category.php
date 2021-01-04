<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $timestamps = false;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function childs()
    {
        return $this->hasMany(Category::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

}
