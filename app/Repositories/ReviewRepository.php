<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{

    public function getModel()
    {
        return Review::class;
    }

    public function createReview($userId, $bookId, $request)
    {
        if ($this->check($userId, $bookId)) {
            abort(403, trans('general.messages.already-reviewed'));
        }

        $this->create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'reviewed_at' => now(),
        ]);
    }

    public function check($userId, $bookId)
    {
        return $this->model->where('user_id', $userId)
                            ->where('book_id', $bookId)
                            ->get()
                            ->isNotEmpty();
    }

    public function ofUser($userId)
    {
        return $this->model->with('book.author', 'book.imageRelation')
                            ->where('user_id', $userId)
                            ->latest('reviewed_at')
                            ->paginate(config('app.num-rows'));
    }

    public function ofBook($bookId)
    {
        return $this->model->with('user.imageRelation')
                            ->where('book_id', $bookId)
                            ->latest('reviewed_at')
                            ->paginate(config('app.num-rows'));
    }

}
