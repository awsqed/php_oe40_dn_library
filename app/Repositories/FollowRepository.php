<?php

namespace App\Repositories;

use App\Models\Follow;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Interfaces\FollowRepositoryInterface;

class FollowRepository extends BaseRepository implements FollowRepositoryInterface
{

    public function getModel()
    {
        return Follow::class;
    }

    public function of($userId, $followableType, $followableId)
    {
        return $this->model->withTrashed()
                            ->where('user_id', $userId)
                            ->where('followable_type', $followableType)
                            ->where('followable_id', $followableId)
                            ->first();
    }

    public function check($userId, $followableType, $followableId)
    {
        return optional($this->of($userId, $followableType, $followableId))->trashed() === false;
    }

    public function toggle($userId, $followableType, $followableId)
    {
        $follow = $this->of($userId, $followableType, $followableId);
        if (is_null($follow)) {
            $this->create([
                'user_id' => $userId,
                'followable_type' => $followableType,
                'followable_id' => $followableId,
            ]);
        } elseif ($follow->trashed()) {
            $follow->restore();
        } else {
            $follow->delete();
        }
    }

    public function getFollowers($followableType, $followableId)
    {
        return $this->model->with('user.imageRelation')
                            ->where('followable_type', $followableType)
                            ->where('followable_id', $followableId)
                            ->latest('followed_at');
    }

    public function getUserFollowers($userId)
    {
        return $this->getFollowers('user', $userId)->paginate(config('app.num-follows-profile'));
    }

    public function getAuthorFollowers($authorId)
    {
        return $this->getFollowers('author', $authorId)->paginate(config('app.num-followers'));
    }

    public function getFollowings($userId, $followableType)
    {
        return $this->model->with('followable.imageRelation')
                            ->where('user_id', $userId)
                            ->where('followable_type', $followableType)
                            ->latest('followed_at')
                            ->paginate(config('app.num-follows-profile'));
    }

}
