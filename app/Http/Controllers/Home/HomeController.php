<?php

namespace App\Http\Controllers\Home;

use App\Models\Book;
use App\Models\Author;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $randomItem = config('app.random-items');

        return view('home.index', [
            'randomBooks' => Book::inRandomOrder()->with('author', 'image')->limit($randomItem)->get(),
            'randomAuthors' => Author::inRandomOrder()->with('image')->limit($randomItem)->get(),
        ]);
    }

}
