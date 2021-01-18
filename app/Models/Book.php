<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $guarded = [];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getCoverAttribute()
    {
        $model = $this;
        return Cache::remember("book-{$model->id}-cover", config('app.cache-time'), function () use ($model) {
            $image = $model->image;
            $imagePath = $image == null ? '' : $image->path;
            return !empty($imagePath)
                    ? asset("storage/{$imagePath}")
                    : asset('storage/'. config('app.default-image.book'));
        });
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowers()
    {
        return $this->belongsToMany(User::class, 'borrow_requests')
                    ->using(BorrowRequest::class)
                    ->withPivot('from', 'to', 'note', 'status', 'processed_at', 'returned_at')
                    ->withTimestamps();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function reviews()
    {
        return $this->belongsToMany(User::class, 'reviews')
                    ->using(Review::class)
                    ->withPivot('rating', 'comment', 'reviewed_at');
    }

    public function getAvgRatingAttribute()
    {
        return $this->reviews->avg('pivot.rating');
    }

    public function printAvgRatingText()
    {
        $star = '';

        $avgRating = (int) $this->avg_rating;
        if ($avgRating) {
            $star .= '<span class="text-danger">';
            for ($i = 0; $i < $avgRating; $i++) {
                $star .= '★';
            }
            $star .= '</span>';
        }

        for ($i = 0; $i < (5 - $avgRating); $i++) {
            $star .= '☆';
        }

        return $star;
    }

}
