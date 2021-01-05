<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserPermission extends Pivot
{

    public $table = 'user_permissions';

    public $incrementing = true;

    public $timestamps = false;

    protected $guarded = [];

}
