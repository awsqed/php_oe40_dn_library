<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Facades\Cache;

trait HasImage
{

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getImageAttribute()
    {
        $model = $this;
        $cacheKey = get_class($this) .'.'. $this->id;
        return Cache::remember($cacheKey, config('app.cache-time'), function () use ($model) {
            $imagePath = optional($model->image()->first())->path ?? '';
            return !empty($imagePath)
                    ? asset("storage/{$imagePath}")
                    : asset('storage/'. config('app.default-image.'. $model->getMorphClass()));
        });
    }

    public function setImageAttribute($imagePath)
    {
        $image = $this->image();
        if ($image->first()) {
            if ($imagePath != config('app.default-image.'. $this->getMorphClass())) {
                $image->update([
                    'path' => $imagePath,
                ]);
            }
        } else {
            $image->create([
                'path' => $imagePath,
            ]);
        }
        Cache::forget(get_class($this) .'.'. $this->id);
    }

}
