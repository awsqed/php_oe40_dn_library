<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Review extends Pivot
{

    public $table = 'reviews';

    public $incrementing = true;

    const CREATED_AT = 'reviewed_at';
    const UPDATED_AT = null;

    protected $guarded = [];

    public function getRatingTextAttribute()
    {
        $star = '';

        $avgRating = $this->rating;
        if ($avgRating) {
            $star .= '<span class="text-danger">';
            for ($i = 0; $i < $avgRating; $i++) {
                $star .= '★';
            }
            $star .= '</span>';
        }

        return $star;
    }

    static public function hasReview(User $user, Book $book)
    {
        return Review::where('user_id', $user->id)->where('book_id', $book->id)->get()->isNotEmpty();
    }

}
