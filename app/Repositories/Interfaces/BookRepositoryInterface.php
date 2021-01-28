<?php

namespace App\Repositories\Interfaces;

interface BookRepositoryInterface extends RepositoryInterface
{

    public function getRandomBooks($limit = null);

    public function search($categoryIds, $search = null);

    public function ofAuthor($authorId);

}
