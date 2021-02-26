<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $timestamps = false;

    protected $guarded = [];

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

    public function childArray($model = null)
    {
        if ($model == null) {
            $model = $this;
        }

        $result = [];

        if ($model !== $this) {
            array_push($result, $model->id);
        }

        $childs = $model->allChilds;
        if ($childs->isNotEmpty()) {
            foreach ($childs as $value) {
                $result = array_merge($result, $this->childArray($value));
            }
        }

        return $result;
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
