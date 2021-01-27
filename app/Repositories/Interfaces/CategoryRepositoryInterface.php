<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface extends RepositoryInterface
{

    public function allWithoutFallback();

    public function getValidParents($categoryId);

    public function updateCategory($categoryId, $request);

    public function deleteCategory($categoryId);

}
