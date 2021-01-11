<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return view('home');
})->name('home');

Route::prefix('dashboard')->middleware('auth')->group(function() {

    Route::get('/', function() {
        return view('dashboard.index');
    })->name('dashboard');

    Route::resource('permissions', PermissionController::class)->only([
        'index',
        'edit',
        'update',
    ]);

});

Route::get('/locale/{locale?}', function($locale = 'en') {
    App::setLocale($locale);
    Session::put('locale', $locale);

    return back();
});

Auth::routes([
    'reset' => false,
]);
