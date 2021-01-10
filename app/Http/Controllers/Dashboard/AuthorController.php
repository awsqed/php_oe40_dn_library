<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{

    public function index()
    {
        $this->authorize('read-author');

        return view('dashboard.authors.index', [
            'authors' => Author::paginate(config('app.num-rows')),
        ]);
    }

    public function create()
    {
        $this->authorize('create-author');

        return view('dashboard.authors.create');
    }

    public function store(AuthorRequest $request)
    {
        $author = Author::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->birthday,
        ]);

        $imagePath = $request->has('image')
                        ? $request->file('image')->store('images/authors', 'public')
                        : config('app.default-image.author');
        $author->image()->create([
            'path' => $imagePath,
        ]);

        return back()->with('success', trans('authors.messages.author-created'));
    }

    public function edit(Author $author)
    {
        $this->authorize('update-author');

        return view('dashboard.authors.edit', [
            'author' => $author,
        ]);
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $author->first_name = $request->first_name;
        $author->last_name = $request->last_name;
        $author->gender = $request->gender;
        $author->date_of_birth = $request->birthday;
        $author->save();

        $imagePath = $request->has('image')
                        ? $request->file('image')->store('images/authors', 'public')
                        : config('app.default-image.author');

        $image = $author->image();
        if ($author->image) {
            if ($imagePath != config('app.default-image.author')) {
                $image->update([
                    'path' => $imagePath,
                ]);
            }
        } else {
            $image->create([
                'path' => $imagePath,
            ]);
        }
        Cache::forget("author-{$author->id}-avatar");

        return back()->with('success', trans('authors.messages.author-edited'));
    }

    public function destroy(Author $author)
    {
        $this->authorize('delete-author');

        $author->delete();

        return back();
    }

}
