<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PermissionController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('dashboard')->middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::resource('permissions', PermissionController::class)->only([
        'index',
        'edit',
        'update',
    ]);

    Route::resource('users', UserController::class)->except([
        'show',
    ]);

    Route::resource('categories', CategoryController::class)->except([
        'show',
    ]);

});

Route::get('/locale/{locale?}', function ($locale = 'en') {
    App::setLocale($locale);
    Session::put('locale', $locale);

    return back();
});

Auth::routes([
    'reset' => false,
]);
