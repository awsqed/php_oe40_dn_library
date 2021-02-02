<?php

namespace App\Repositories\Interfaces;

interface BorrowRequestRepositoryInterface extends RepositoryInterface
{

    public function createBorrowRequest($userId, $bookId, $from, $to);

    public function getLatestProcessing($userId, $bookId);

    public function getCurrentBorrowing($userId, $bookId);

    public function ofUser($userId);

    public function search($search, $filter, $withPaginator = true);

    public function updateBorrowRequest($borrowRequestId, $action);

    public function whereDate($date, $field = 'created_at');

    public function whereMonth($month, $field = 'created_at');

    public function whereYear($year, $field = 'created_at');

}
