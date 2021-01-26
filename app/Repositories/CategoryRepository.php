<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    public function getModel()
    {
        return Category::class;
    }

    public function allWithoutFallback()
    {
        return $this->model
                    ->where('id', '<>', config('app.fallback-category'))
                    ->get();
    }

    public function getValidParents($categoryId)
    {
        $invalid = array_merge([
            config('app.fallback-category'),
            $categoryId,
        ], $this->find($categoryId)->childArray());

        return $this->model
                    ->whereNotIn('id', $invalid)
                    ->get();
    }

    public function updateCategory($categoryId, $request)
    {
        $this->update($categoryId, [
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $category = $this->find($categoryId);
        if ($request->filled('parent')) {
            $category->parent()->associate($this->find($request->parent));
        } else {
            $category->parent()->dissociate();
        }

        $category->save();
    }

    public function deleteCategory($categoryId)
    {
        if ($categoryId == config('app.fallback-category')) {
            abort(403, trans('general.messages.delete-fallback-category'));
        }

        $this->delete($categoryId);
    }

    public function getRootCategories()
    {
        return $this->model->doesntHave('parent')->with('childs')->get();
    }

}
