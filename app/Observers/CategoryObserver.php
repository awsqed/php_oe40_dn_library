<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryObserver
{

    public function deleting(Category $category)
    {
        DB::transaction(function() use ($category) {
            $category->childs()->update([
                'parent_id' => null,
            ]);
            $category->books()->update([
                'category_id' => 1,
            ]);
        });
    }

}
