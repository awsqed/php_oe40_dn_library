<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class HomeController extends Controller
{

    public function __construct(
        AuthorRepositoryInterface $authorRepo,
        BookRepositoryInterface $bookRepo
    ) {
        $this->authorRepo = $authorRepo;
        $this->bookRepo = $bookRepo;
    }

    public function index()
    {
        $randomBooks = $this->bookRepo->getRandomBooks();
        $randomAuthors = $this->authorRepo->getRandomAuthors();

        return view('home.index', compact('randomBooks', 'randomAuthors'));
    }

}
