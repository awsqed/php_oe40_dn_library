<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Review extends Pivot
{

    protected $table = 'reviews';

    public $incrementing = true;

    const CREATED_AT = 'reviewed_at';
    const UPDATED_AT = null;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function getRatingTextAttribute()
    {
        $star = '';

        $rating = $this->rating;
        if ($rating) {
            $star .= '<span class="text-danger">';
            for ($i = 0; $i < $rating; $i++) {
                $star .= '★';
            }
            $star .= '</span>';
        }

        return $star;
    }

}
