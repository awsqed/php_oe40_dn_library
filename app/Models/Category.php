<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $timestamps = false;

    protected $guarded = [];

    protected static function booted()
    {
        // Update all related records before deleting the category
        static::deleting(function($category) {
            DB::transaction(function() use ($category) {
                $category->childs()->update([
                    'parent_id' => null,
                ]);
                $category->books()->update([
                    'category_id' => 1,
                ]);
            });
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getBreadcrumbAttribute()
    {
        return $this->name;
    }

}
