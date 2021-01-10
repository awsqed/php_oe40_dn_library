<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

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
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        //
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
