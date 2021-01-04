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

}
