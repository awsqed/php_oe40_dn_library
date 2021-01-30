<?php

namespace App\Repositories;

use App\Models\BorrowRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;

class BorrowRequestRepository extends BaseRepository implements BorrowRequestRepositoryInterface
{

    public function getModel()
    {
        return BorrowRequest::class;
    }

    public function createBorrowRequest($userId, $bookId, $from, $to)
    {
        $this->model->create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function getLatestProcessing($userId, $bookId)
    {
        return $this->model->where('user_id', $userId)
                            ->where('book_id', $bookId)
                            ->where('status', null)
                            ->latest()
                            ->first();
    }

    public function getCurrentBorrowing($userId, $bookId)
    {
        return $this->model->where('user_id', $userId)
                            ->where('book_id', $bookId)
                            ->where('status', config('app.borrow-request.status-code.accepted'))
                            ->where('returned_at', null)
                            ->latest()
                            ->first();
    }

    public function ofUser($userId)
    {
        return $this->model->with('book')
                            ->where('user_id', $userId)
                            ->defaultSort()
                            ->paginate(config('app.num-rows'));
    }

    public function search($search, $filter, $withPaginator = true)
    {
        $result = $this->model->with('user', 'book');

        $configKey = 'app.borrow-request.status-code';

        if (is_null($filter) || $filter === '') {
            $filter = config("{$configKey}.new");
        }

        switch ($filter) {
            case 'all':
                break;

            case config("{$configKey}.accepted"):
            case config("{$configKey}.rejected"):
            case config("{$configKey}.returned"):
            case config("{$configKey}.returned-late"):
                $result->where('status', $filter);
                break;

            case config("{$configKey}.new"):
                $result->where('status', null);
                break;

            case config("{$configKey}.overdue"):
                $result->where('status', config("{$configKey}.accepted"))
                        ->where('returned_at', null)
                        ->where('to', '<', date('Y-m-d'));
                break;
        }

        if (!empty($search)) {
            $search = '%'. str_replace(' ', '%', $search ?: '') .'%';
            $result->where(function ($query) use ($search) {
                $query->whereHas('user', function (Builder $query) use ($search) {
                    $query->whereRaw('LOWER(first_name) like ?', $search)
                            ->orWhereRaw('LOWER(last_name) like ?', $search);
                })->orWhereHas('book', function (Builder $query) use ($search) {
                    $query->whereRaw('LOWER(title) like ?', $search);
                });
            });
        }

        return $withPaginator
                ? $result->defaultSort()
                            ->paginate(config('app.num-rows'))
                            ->withQueryString()
                : $result->get();
    }

    public function updateBorrowRequest($borrowRequestId, $action)
    {
        $borrowRequest = $this->find($borrowRequestId);

        $attributes = [];
        switch ($action) {
            case 'accept':
                $attributes['status'] = config('app.borrow-request.status-code.accepted');
                $attributes['processed_at'] = now();
                break;
            case 'reject':
                $attributes['status'] = config('app.borrow-request.status-code.rejected');
                $attributes['processed_at'] = now();
                break;
            case 'return':
                $attributes['status'] = date('Y-m-d') > $borrowRequest->to
                                ? config('app.borrow-request.status-code.returned-late')
                                : config('app.borrow-request.status-code.returned');
                $attributes['returned_at'] = now();
                break;
            default:
                return;
        }

        $this->update($borrowRequestId, $attributes);
    }

}
