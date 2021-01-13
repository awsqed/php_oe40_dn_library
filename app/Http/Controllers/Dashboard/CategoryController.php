<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{

    public function index()
    {
        $this->authorize('read-category');

        return view('dashboard.categories.index', [
            'categories' => Category::paginate(config('app.num-rows')),
        ]);
    }

    public function create()
    {
        $this->authorize('create-category');

        return view('dashboard.categories.create', [
            'categories' => Category::where('id', '<>', config('app.fallback-category'))->get(),
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent ?: null,
            'description' => $request->description,
        ]);

        return back()->with('success', trans('categories.messages.category-created'));
    }

    public function edit(Category $category)
    {
        $this->authorize('update-category');

        $fallbackCategory = config('app.fallback-category');
        $invalidCategories = [
            $fallbackCategory,
            $category->id,
        ];
        foreach ($category->childs as $child) {
            $invalidCategories[] = $child->id;
        }

        if ($category->id == $fallbackCategory) {
            return view('dashboard.categories.edit', [
                'category' => $category
            ]);
        }

        return view('dashboard.categories.edit', [
            'category' => $category,
            'categories' => Category::whereNotIn('id', $invalidCategories)->get(),
        ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->description = $request->description;

        $category->parent()->associate(Category::find($request->parent));

        $category->push();

        return back()->with('success', trans('categories.messages.category-edited'));
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete-category');

        if ($category->id == config('app.fallback-category')) {
            abort(403, trans('general.messages.delete-fallback-category'));
        }

        $category->delete();

        return back();
    }

}
