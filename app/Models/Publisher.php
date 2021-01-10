<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{

    public $timestamps = false;

    protected $guarded = [];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getLogoAttribute()
    {
        $model = $this;
        return Cache::remember("publisher-{$model->id}-logo", config('app.cache-time'), function () use ($model) {
            $image = $model->image;
            $imagePath = $image == null ? '' : $image->path;
            return !empty($imagePath)
                    ? asset("storage/{$imagePath}")
                    : asset('storage/'. config('app.default-image.publisher'));
        });
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
