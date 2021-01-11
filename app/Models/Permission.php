<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    public $timestamps = false;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Permission::class);
    }

    public function childs()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions')->using(UserPermission::class);
    }

    public function allParents()
    {
        return $this->parent()->with('allParents');
    }

    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }

    public function parentArray($model = null)
    {
        if (!$model) {
            $model = $this;
        }

        $result = [];

        if ($model !== $this) {
            array_push($result, $model->name);
        }

        if ($model->allParents) {
            $result = array_merge($result, $this->parentArray($model->allParents));
        }

        return $result;
    }

    public function childArray($model = null)
    {
        if ($model == null) {
            $model = $this;
        }

        $result = [];

        if ($model !== $this) {
            array_push($result, $model->name);
        }

        if ($model->allChilds->isNotEmpty()) {
            foreach ($model->allChilds as $value) {
                $result = array_merge($result, $this->childArray($value));
            }
        }

        return $result;
    }

    public function getBreadcrumbAttribute()
    {
        return $this->name;
    }

}
