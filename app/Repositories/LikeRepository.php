<?php

namespace App\Repositories;

use App\Models\Like;
use App\Repositories\Interfaces\LikeRepositoryInterface;

class LikeRepository extends BaseRepository implements LikeRepositoryInterface
{

    public function getModel()
    {
        return Like::class;
    }

    public function of($userId, $bookId)
    {
        return $this->model->withTrashed()
                            ->where('user_id', $userId)
                            ->where('book_id', $bookId)
                            ->first();
    }

    public function check($userId, $bookId)
    {
        return optional($this->of($userId, $bookId))->trashed() === false;
    }

    public function toggle($userId, $bookId)
    {
        $like = $this->of($userId, $bookId);
        if (is_null($like)) {
            $this->create([
                'user_id' => $userId,
                'book_id' => $bookId,
            ]);

            return true;
        } elseif ($like->trashed()) {
            $like->restore();

            return true;
        } else {
            $like->delete();

            return false;
        }
    }

    public function getByUserId($userId)
    {
        return $this->model->with('book.image')
                            ->where('user_id', $userId)
                            ->latest('liked_at')
                            ->paginate(config('app.num-rows'));
    }

}
