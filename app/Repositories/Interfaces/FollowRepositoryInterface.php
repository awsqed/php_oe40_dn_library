<?php

namespace App\Repositories\Interfaces;

interface FollowRepositoryInterface extends RepositoryInterface
{

    public function of($userId, $followableType, $followableId);

    public function check($userId, $followableType, $followableId);

    public function toggle($userId, $followableType, $followableId);

    public function getFollowers($followableType, $followableId);

    public function getUserFollowers($userId);

    public function getAuthorFollowers($authorId);

    public function getFollowings($userId, $followableType);

}
