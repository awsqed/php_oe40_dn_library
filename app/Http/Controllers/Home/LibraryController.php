<?php

namespace App\Http\Controllers\Home;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BorrowFormRequest;
use Illuminate\Database\Eloquent\Builder;

class LibraryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except([
            'index',
            'viewBook',
        ]);
    }

    public function index(Request $request)
    {
        $books = Book::with('image', 'author', 'reviews');

        if ($request->filled('category')) {
            $books->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = '%'. str_replace(' ', '%', $request->search ?: '') .'%';
            $books->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(title) like ?', $search)
                        ->orWhereRaw('LOWER(description) like ?', $search)
                        ->orWhereHas('author', function (Builder $query) use ($search) {
                            $query->whereRaw('LOWER(first_name) like ?', $search)
                                    ->orWhereRaw('LOWER(last_name) like ?', $search);
                        });
            });
        }

        return view('home.library.index', [
            'categories' => Category::doesntHave('parent')->with('childs')->get(),
            'books' => $books->paginate(config('app.num-rows'))->withQueryString(),
        ]);
    }

    public function viewBook(Book $book)
    {
        return view('home.library.book', [
            'book' => $book,
        ]);
    }

    public function borrowBook(BorrowFormRequest $request, Book $book)
    {
        $user = Auth::user();
        $user->bookBorrowRequests()->attach($book, [
            'from' => $request->from,
            'to' => $request->to,
        ]);

        return back();
    }

    public function borrowHistory()
    {
        $user = Auth::user();

        return view('home.library.borrow-history', [
            'history' => $user->bookBorrowRequests()->latest('pivot_created_at', 'from', 'to')->paginate(config('app.num-rows')),
        ]);
    }

}
