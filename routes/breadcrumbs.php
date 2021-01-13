<?php

Breadcrumbs::macro('resource', function ($parent, $name, $title, $only = [
    'index',
    'create',
    'show',
    'edit',
]) {
    if (in_array('index', $only)) {
        Breadcrumbs::for("{$name}.index", function ($trail) use ($parent, $name, $title) {
            $trail->parent($parent);
            $trail->push($title, route("{$name}.index"));
        });
    }

    if (in_array('create', $only)) {
        Breadcrumbs::for("{$name}.create", function ($trail) use ($name) {
            $trail->parent("{$name}.index");
            $trail->push(trans("{$name}.new"), route("{$name}.create"));
        });
    }

    if (in_array('show', $only)) {
        Breadcrumbs::for("{$name}.show", function ($trail, $model) use ($name) {
            $trail->parent("{$name}.index");
            $trail->push($model->breadcrumb, route("{$name}.show", $model));
        });
    }

    if (in_array('edit', $only)) {
        Breadcrumbs::for("{$name}.edit", function ($trail, $model) use ($name) {
            $parentCrumb = "{$name}.index";
            $crumbTitle = $model->breadcrumb;

            if (Breadcrumbs::exists("{$name}.show")) {
                $parentCrumb = "{$name}.show";
                $crumbTitle = trans("{$name}.editing");
            }

            $trail->parent($parentCrumb, $model);
            $trail->push($crumbTitle, route("{$name}.edit", $model));
        });
    }
});

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push(trans('dashboard.dashboard'), route('dashboard'));
});

Breadcrumbs::resource('dashboard', 'permissions', trans('dashboard.permissions'), [
    'index',
    'edit',
]);


Breadcrumbs::resource('dashboard', 'users', trans('dashboard.users'), [
    'index',
    'create',
    'edit',
]);

Breadcrumbs::resource('dashboard', 'categories', trans('dashboard.categories'), [
    'index',
    'create',
    'edit',
]);

Breadcrumbs::resource('dashboard', 'authors', trans('dashboard.authors'), [
    'index',
    'create',
    'edit',
]);

Breadcrumbs::resource('dashboard', 'publishers', trans('dashboard.publishers'), [
    'index',
    'create',
    'edit',
]);

Breadcrumbs::for("borrows.index", function ($trail) {
    $trail->parent('dashboard');
    $trail->push(trans('dashboard.borrow-requests'), route('borrows.index'));
});
