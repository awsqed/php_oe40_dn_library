<?php

namespace App\Http\Controllers\Home;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class LibraryController extends Controller
{

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

}
