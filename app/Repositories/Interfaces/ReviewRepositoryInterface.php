<?php

namespace App\Repositories\Interfaces;

interface ReviewRepositoryInterface extends RepositoryInterface
{

    public function createReview($userId, $bookId, $request);

    public function check($userId, $bookId);

    public function ofUser($userId);

    public function ofBook($bookId);

}
