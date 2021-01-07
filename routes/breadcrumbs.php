<?php

Breadcrumbs::macro('resource', function ($parent, $name, $title, $only = [
    'index',
    'create',
    'show',
    'edit',
]) {
    if (in_array('index', $only)) {
        // Home > Model
        Breadcrumbs::for("{$name}.index", function ($trail) use ($parent, $name, $title) {
            $trail->parent($parent);
            $trail->push($title, route("{$name}.index"));
        });
    }

    if (in_array('create', $only)) {
        // Home > Model > New
        Breadcrumbs::for("{$name}.create", function ($trail) use ($name) {
            $trail->parent("{$name}.index");
            $trail->push(trans('general.new'), route("{$name}.create"));
        });
    }

    if (in_array('show', $only)) {
        // Home > Model > {model}
        Breadcrumbs::for("{$name}.show", function ($trail, $model) use ($name) {
            $trail->parent("{$name}.index");
            $trail->push($model->breadcrumb, route("{$name}.show", $model));
        });
    }

    if (in_array('edit', $only)) {
        // Home > Model > {model} > Edit
        Breadcrumbs::for("{$name}.edit", function ($trail, $model) use ($name) {
            $parentCrumb = "{$name}.index";
            $crumbTitle = $model->breadcrumb;

            if (Breadcrumbs::exists("{$name}.show")) {
                $parentCrumb = "{$name}.show";
                $crumbTitle = trans('general.edit');
            }

            $trail->parent($parentCrumb, $model);
            $trail->push($crumbTitle, route("{$name}.edit", $model));
        });
    }
});

Breadcrumbs::resource('dashboard', 'permissions', trans('dashboard.permissions'), [
    'index',
    'edit'
]);

// Dashboard
Breadcrumbs::for('dashboard', function($trail) {
    $trail->push(trans('dashboard.dashboard'), route('dashboard'));
});


