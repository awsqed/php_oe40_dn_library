<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasImage;

    public $timestamps = false;

    protected $guarded = [];

    public function getLogoAttribute()
    {
        return $this->image;
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getBreadcrumbAttribute()
    {
        return $this->name;
    }

}
