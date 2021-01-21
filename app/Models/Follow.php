<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use SoftDeletes;

    protected $table = 'follows';

    const CREATED_AT = null;
    const UPDATED_AT = 'followed_at';

    protected $guarded = [];

    public function followable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    static public function of(User $user, $followable)
    {
        return Follow::withTrashed()->whereHasMorph('followable', '*', function (Builder $query) use ($user, $followable) {
            $query->where('user_id', $user->id)
                    ->where('followable_id', $followable->id)
                    ->where('followable_type', $followable->getMorphClass());
        })->first();
    }

    static public function check(User $user, $followable)
    {
        return optional(Follow::of($user, $followable))->trashed() === false;
    }

}
