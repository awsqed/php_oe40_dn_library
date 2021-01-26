<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->authorize('read-category');

        $categories = $this->repository->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('create-category');

        $categories = $this->repository->allWithoutFallback();

        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $this->repository->create([
            'name' => $request->name,
            'parent_id' => $request->parent ?: null,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', trans('categories.messages.category-created'));
    }

    public function edit($categoryId)
    {
        $this->authorize('update-category');

        $category = $this->repository->find($categoryId);
        $categories = $this->repository->getValidParents($categoryId);

        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    public function update(CategoryRequest $request, $categoryId)
    {
        $this->repository->updateCategory($categoryId, $request);

        return redirect()->route('categories.index')->with('success', trans('categories.messages.category-edited'));
    }

    public function destroy($categoryId)
    {
        $this->authorize('delete-category');

        $this->repository->deleteCategory($categoryId);

        return back();
    }

}
