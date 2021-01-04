<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BorrowRequest extends Pivot
{

    public $table = 'borrow_requests';

    public $incrementing = true;

    const UPDATED_AT = null;

    protected $guarded = [];

}
