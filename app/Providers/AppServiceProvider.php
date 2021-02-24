<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot(Charts $charts)
    {
        Relation::morphMap([
            'user' => 'App\Models\User',
            'book' => 'App\Models\Book',
            'author' => 'App\Models\Author',
            'publisher' => 'App\Models\Publisher',
        ]);

        $chartList = [];
        $chartPath = app_path() .'/Charts';
        foreach (scandir($chartPath) as $file) {
            if (!Str::endsWith($file, '.php')) {
                continue;
            }

            $className = Str::replaceLast('.php', '', $file);
            $chartList[] = "App\Charts\\${className}";
        }
        $charts->register($chartList);
    }

}
