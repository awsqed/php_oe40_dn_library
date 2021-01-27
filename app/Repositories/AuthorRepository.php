<?php

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{

    public function getModel()
    {
        return Author::class;
    }

    public function createAuthor($request)
    {
        $author = $this->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->birthday,
        ]);

        $author->image = $request->has('image')
                            ? $request->file('image')->store('images/authors', 'public')
                            : config('app.default-image.author');

        return $author;
    }

    public function updateAuthor($authorId, $request)
    {
        $this->update($authorId, [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->birthday,
        ]);

        $author = $this->find($authorId);
        $author->image = $request->has('image')
                            ? $request->file('image')->store('images/authors', 'public')
                            : config('app.default-image.author');
    }

    public function getRandomAuthors($limit = null)
    {
        $limit = $limit ?? config('app.random-items');

        return $this->model->inRandomOrder()->with('image')->limit($limit)->get();
    }

}
