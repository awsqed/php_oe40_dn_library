<?php

namespace App\Repositories\Interfaces;

interface BorrowRequestRepositoryInterface extends RepositoryInterface
{

    public function createBorrowRequest($userId, $bookId, $from, $to);

    public function getLatestProcessing($userId, $bookId);

    public function getCurrentBorrowing($userId, $bookId);

    public function ofUser($userId);

    public function search($search, $filter = null);

    public function updateBorrowRequest($borrowRequestId, $action);

}
