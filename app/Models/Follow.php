<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use SoftDeletes;

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

}
