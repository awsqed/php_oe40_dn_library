<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use SoftDeletes;

    protected $table = 'likes';

    const CREATED_AT = null;
    const UPDATED_AT = 'liked_at';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    static public function of(User $user, Book $book)
    {
        return Like::withTrashed()->where('user_id', $user->id)->where('book_id', $book->id)->first();
    }

    static public function check(User $user, Book $book)
    {
        return optional(Like::of($user, $book))->trashed() === false;
    }

}
