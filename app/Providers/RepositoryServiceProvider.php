<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\AuthorRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PublisherRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use App\Repositories\Interfaces\PublisherRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->singleton(
            AuthorRepositoryInterface::class,
            AuthorRepository::class
        );

        $this->app->singleton(
            PublisherRepositoryInterface::class,
            PublisherRepository::class
        );
    }

    public function boot()
    {
        //
    }

}
