<?php

namespace App\Repositories\Interfaces;

interface AuthorRepositoryInterface extends RepositoryInterface
{

    public function createAuthor($request);

    public function updateAuthor($authorId, $request);

    public function getRandomAuthors($limit = null);

}
