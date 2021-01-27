<?php

namespace App\Providers;

use App\Models\BorrowRequest;
use Illuminate\Support\ServiceProvider;
use App\Observers\BorrowRequestObserver;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        Relation::morphMap([
            'user' => 'App\Models\User',
            'book' => 'App\Models\Book',
            'author' => 'App\Models\Author',
            'publisher' => 'App\Models\Publisher',
        ]);

        BorrowRequest::observe(BorrowRequestObserver::class);
    }

}
