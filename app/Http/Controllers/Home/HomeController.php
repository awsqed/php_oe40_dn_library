<?php

namespace App\Http\Controllers\Home;

use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class HomeController extends Controller
{

    public function __construct(AuthorRepositoryInterface $authorRepo)
    {
        $this->authorRepo = $authorRepo;
    }

    public function index()
    {
        $randomBooks = Book::inRandomOrder()->with('author', 'image')->limit(config('app.random-items'))->get();
        $randomAuthors = $this->authorRepo->getRandomAuthors();

        return view('home.index', compact('randomBooks', 'randomAuthors'));
    }

}
