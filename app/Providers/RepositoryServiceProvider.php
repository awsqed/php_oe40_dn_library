<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $repositoryPath = app_path() .'/Repositories';
        foreach (scandir($repositoryPath) as $file) {
            if (!Str::endsWith($file, '.php')) {
                continue;
            }

            $className = Str::replaceLast('.php', '', $file);
            if ($className === 'BaseRepository') {
                continue;
            }

            $this->app->singleton(
                "App\Repositories\Interfaces\\${className}Interface",
                "App\Repositories\\${className}"
            );
        }
    }

    public function boot()
    {
        //
    }

}
