<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\AuthorRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorController extends Controller
{

    public function __construct(AuthorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->authorize('read-author');

        $authors = $this->repository->paginate();

        return view('dashboard.authors.index', compact('authors'));
    }

    public function create()
    {
        $this->authorize('create-author');

        return view('dashboard.authors.create');
    }

    public function store(AuthorRequest $request)
    {
        $this->repository->createAuthor($request);

        return redirect()
                ->route('authors.index')
                ->with('success', trans('authors.messages.author-created'));
    }

    public function edit($authorId)
    {
        $this->authorize('update-author');

        $author = $this->repository->find($authorId);

        return view('dashboard.authors.edit', compact('author'));
    }

    public function update(AuthorRequest $request, $authorId)
    {
        $this->repository->updateAuthor($authorId, $request);

        return redirect()
                ->route('authors.index')
                ->with('success', trans('authors.messages.author-edited'));
    }

    public function destroy($authorId)
    {
        $this->authorize('delete-author');

        $this->repository->delete($authorId);

        return back();
    }

}
