<?php

namespace App\Repositories\Interfaces;

interface LikeRepositoryInterface extends RepositoryInterface
{

    public function of($userId, $bookId);

    public function check($userId, $bookId);

    public function toggle($userId, $bookId);

    public function getByUserId($userId);

}
